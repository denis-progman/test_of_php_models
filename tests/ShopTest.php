<?php

use App\models\Customer;
use App\models\Invoice\Payment;
use App\Models\Shop;

class ShopTest extends \PHPUnit\Framework\TestCase
{

    /** @test */
    public function can_set_and_access_basic_shop_properties()
    {
        $shop = new Shop();
        $shop->setName('A Cool Repair Shop');
        $shop->setLocation('123 Main St, Lewes, DE 19958');

        $this->assertEquals('A Cool Repair Shop', $shop->getName());
        $this->assertEquals('123 Main St, Lewes, DE 19958', $shop->getLocation());
    }

    /** @test */
    public function can_add_and_access_invoices()
    {
        $shop = new Shop();

        // create a payment
        $customer = new Customer('Tom Cruise', '+1234567890');

        $invoice = new \App\Models\Invoice($customer);
        $invoice->setCreationDate(new DateTime());

        $payment = new Payment();
        $payment->setDate(new DateTime());
        $payment->setAmount(150);

        $invoice->setPaymentDate($payment);

        $shop->addInvoice($invoice);

        $this->assertCount(1, $shop->getInvoices());
        $this->assertEquals($invoice, $shop->getInvoices()[0]);
    }

}
