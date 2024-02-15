<?php

namespace App\models;

use App\models\Invoice\Payment;
use DateTime;
use Exception;

class Invoice
{
    protected \DateTime $creationDate;
    protected ?Payment $payment = null;
    protected array $items;
    protected float $totalAmount = 0;
    protected int $paymentDue;

    const OVERDUE_REPORT_FIELDS = [
        'customer.name' => [
            'label' => 'Customer Name',
        ],
        'customer.phoneNumber' => [
            'label' => 'Customer Phone Number',
        ],
        'creationDate' => [
            'type' => 'datetime',
            'label' => 'Creation Date',
        ],
        'totalAmount' => [
            'label' => 'Total Amount',
        ],
        'payment.date' => [
            "type" => "datetime",
            'label' => 'Payment Date',
            'rule' => [
                null => 'Not Paid',
            ],
        ],
        'payment.amount' => [
            'label' => 'Payment Amount',
            'rule' => [
                null => 'Not Paid',
            ],
        ],
        'PaymentOverdue' => [
            'type' => 'boolean',
            'label' => 'Is Payment Overdue',
            'rule' => [
                true => 'Yes',
                false => 'No',
            ]
        ],
    ];

    public function __construct(protected ?Customer $customer = null)
    {
        $this->paymentDue = config('invoice.payment_due');
    }

    public function setCreationDate(\DateTime $date)
    {
        $this->creationDate = $date;
    }

    public function getCreationDate(): DateTime
    {
        return $this->creationDate;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setPaymentDate(Payment $payment) : void
    {
        $this->payment = $payment;
    }

    public function createPayment() : Payment
    {
        $this->payment = new Payment();

        return $this->payment;
    }

    public function getPayment() : Payment|null
    {
        return $this->payment;
    }

    public function setTotalAmount(float $amount) : void
    {
        $this->totalAmount = $amount;
    }

    public function getTotalAmount() : float
    {
        return $this->totalAmount;
    }

    /**
     * @throws Exception
     */
    public function isPaymentOverdue() : bool
    {
        $now = new DateTime();
        $dueDate = (new DateTime($this->creationDate->format('Y-m-d')))->add(new \DateInterval("P{$this->paymentDue}D"));
        $now->setTimezone($this->customer->getTimeZone());
        return $now > $dueDate;
    }

    public function toArray() : array
    {
        $invoiceArray = [];
        foreach (self::OVERDUE_REPORT_FIELDS as $field => $fieldSettings) {
            $type = (isset($fieldSettings['type']) && $fieldSettings['type']) ? $fieldSettings['type'] : 'string';
            $requestChain = explode('.', $field);
            $data = $this;
            foreach ($requestChain as $chainLink) {
                $data = $data->{($type == "boolean" ? 'is' : 'get') . ucfirst($chainLink)}();
                if ($data === null) {
                    break;
                }
            }
            $invoiceArray[$field] = (($data && $type == "datetime") ? $data->format('Y-m-d H:i:s') : $data);
        }
        return $invoiceArray;
    }

    public function toString() : string
    {
        $str = '';
        foreach ($this->toArray() as $key => $value) {
            $str .= "$key: $value\n";
        }
        return "$str\n";
    }
}
