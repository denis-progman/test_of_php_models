<?php

use App\models\Customer;
use App\models\Invoice;
use App\models\Invoice\Payment;
use App\services\Invoices;
use \Mockery as m;

class InvoicesTest extends \PHPUnit\Framework\TestCase
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

        $this->assertEmpty($this->service->fetchInvoices());
    }

    /** @test */
    public function return_array_with_one_invoice()
    {
        $customer = new Customer('Tom Cruise');

        $invoice = new Invoice($customer);
        $invoice->setCreationDate(new DateTime());
        $invoice->setTotalAmount(150);

        $payment = new Payment();
        $payment->setPaymentDate(new DateTime());
        $payment->setAmount(150);

        $invoice->setPayment($payment);

        $this->databaseLayerMock->shouldReceive('runQuery')->once()->andReturn([$invoice]);

        $result = $this->service->fetchInvoices();

        $this->assertNotEmpty($result);
        $this->assertEquals(150, $result[0]->getTotalAmount());
        $this->assertEquals(150, $result[0]->getPayment()->getAmount());
    }
}
