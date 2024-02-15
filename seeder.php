<?php
use App\models\Customer;
use App\models\Invoice;
use App\models\Invoice\Payment;

function generatePhoneNumber(): string
{
    $number = '+';
    for ($i = 0; $i < 11; $i++) {
        $number .= rand(0, 9);
    }
    return $number;
}

function seed()
{
    $customer1 = new Customer('Tom Cruise', generatePhoneNumber(), 'America/New_York');
    $customer2 = new Customer('Happy Guy', generatePhoneNumber(),'Europe/Paris');
    $customer3 = new Customer('Lucy Dorito', generatePhoneNumber(), 'Asia/Tokyo');

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
    $payment->setDate(new DateTime());
    $payment->setAmount($invoice3->getTotalAmount());
    $invoice3->setPaymentDate($payment);

    $invoice4 = new Invoice($customer3);
    $invoice4->setCreationDate((new DateTime())->sub(new DateInterval('P64D')));
    $invoice4->setTotalAmount(250);

    return [$invoice1, $invoice2, $invoice3, $invoice4];
}

