<?php

use App\models\Customer;
use App\models\Invoice;
use App\models\Invoice\Payment;
use App\services\Invoices;
use \Mockery as m;

class OverdueInvoicesTest extends \PHPUnit\Framework\TestCase
{
    protected Invoices $service;
    protected $databaseLayerMock;

    public function setUp() : void
    {
        parent::setUp();

        $this->databaseLayerMock = m::mock('Something');
        $this->service = new Invoices($this->databaseLayerMock);
    }

    /** @test */
    public function return_empty_array_if_nothing_found()
    {
        $this->databaseLayerMock->shouldReceive('runQuery')->once()->andReturn([]);

        $this->assertEmpty($this->service->fetch()->get());
    }

    /** @test */
    public function return_array_with_one_invoice()
    {
        $customer = new Customer('Tom Cruise', '+1234567890');

        $invoice = new Invoice($customer);
        $invoice->setCreationDate((new DateTime())->sub(new DateInterval('P45D')));
        $invoice->setTotalAmount(150);

        $payment = new Payment();
        $payment->setDate(new DateTime());
        $payment->setAmount(150);

        $invoice->setPaymentDate($payment);

        $this->databaseLayerMock->shouldReceive('runQuery')->once()->andReturn([$invoice]);

        $serviceResult = $this->service->fetch()->filterOverdue();
        $result = $serviceResult->get();
        $this->assertNotEmpty($result);
        $this->assertEquals(150, $result[0]->getTotalAmount());
        $this->assertEquals(150, $result[0]->getPayment()->getAmount());

        $stringResult = $serviceResult->toString();
        $this->assertNotEmpty($stringResult);
        $this->assertStringContainsString('customer.name: Tom Cruise', $stringResult);
        $this->assertStringContainsString('totalAmount: 150', $stringResult);
        $this->assertStringContainsString('PaymentOverdue: 1', $stringResult);

        $fileResult = $serviceResult->saveToCSVFile();
        $this->assertNotEmpty($fileResult);
        $this->assertFileExists($fileResult);

        $fileChecking = file_get_contents($fileResult);
        $this->assertNotEmpty($fileChecking);
        $this->assertStringContainsString(
            'Customer Name,Customer Phone Number,Creation Date,Total Amount,Payment Date,Payment Amount,Is Payment Overdue',
            $fileChecking
        );
        $this->assertStringContainsString(
            'Tom Cruise,+1234567890,',
            $fileChecking
        );

        if (file_exists($fileResult)) {
            unlink($fileResult);
        }
    }
}
