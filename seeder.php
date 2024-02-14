<?php
use App\models\Customer;
use App\models\Invoice;
use App\models\Invoice\Payment;

function seed()
{
    $customer1 = new Customer('Tom Cruise', 'America/New_York');
    $customer2 = new Customer('Happy Guy', 'Europe/Paris');
    $customer3 = new Customer('Lucy Dorito');

    $invoice1 = new Invoice($customer1);
    $invoice1->setCreationDate((new DateTime())->sub(new DateInterval('P35D')));
    $invoice1->setTotalAmount(250);

    $invoice2 = new Invoice($customer1);
    $invoice2->setCreationDate((new DateTime())->sub(new DateInterval('P5D')));
    $invoice2->setTotalAmount(350);

    $invoice3 = new Invoice($customer2);
    $invoice3->setCreationDate((new DateTime())->sub(new DateInterval('P45D')));
    $invoice3->setTotalAmount(150);
    $payment = new Payment();
    $payment->setPaymentDate(new DateTime());
    $payment->setAmount($invoice3->getTotalAmount());
    $invoice3->setPayment($payment);

    $invoice4 = new Invoice($customer3);
    $invoice4->setCreationDate((new DateTime())->sub(new DateInterval('P64D')));
    $invoice4->setTotalAmount(250);

    return [$invoice1, $invoice2, $invoice3, $invoice4];
}

