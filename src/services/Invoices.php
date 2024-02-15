<?php

namespace App\services;


use App\models\Invoice;
use LucidFrame\Console\ConsoleTable;

class Invoices
{
    /**
     * @var Invoice[]
     */
    protected array $invoices = [];

    protected string $fileStorage;

    public function __construct(protected object $databaseLayer)
    {
        $this->fileStorage = config('app.file_storage', './');
    }

    /*
     * Assume this returns an Invoice object with its related Customer + Payment objects.
     * refer to return_array_with_one_invoice() in tests\InvoicesTest.php
     */

    /**
     * @return Invoice[]
     */
    public function get(): array
    {
        return $this->invoices;
    }

    /**
     * @return self
     */
    public function fetch() : self
    {
        $this->invoices = $this->databaseLayer->runQuery('select * from invoices...');
        return $this;
    }

    /**
     * @retun self
     */
    public function filterOverdue(): self
    {
        $this->invoices = array_filter($this->invoices, fn($invoice) => $invoice->isPaymentOverdue());
        return $this;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        $str = '';
        foreach ($this->invoices as $invoice) {
            $str .= $invoice->toString();
        }
        return $str . "--------------------------------\n\n";
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arr = [];
        foreach ($this->invoices as $invoice) {
            $arr[] = $invoice->toArray();
        }
        return $arr;
    }


    public function toTerminalTable(): void
    {
        $table = new ConsoleTable();
        $table->setHeaders(array_column(Invoice::OVERDUE_REPORT_FIELDS, 'label'));
        foreach ($this->invoices as $invoice) {
            $table->addRow(array_values($invoice->toArray()));
        }
        $table->display();
    }

    public function toHtmlTable(): string
    {
        $table = "<table><tr>";
        foreach (array_column(Invoice::OVERDUE_REPORT_FIELDS, 'label') as $header) {
            $table .= "<th>$header</th>";
        }
        $table .= "</tr>";
        foreach ($this->invoices as $invoice) {
            $table .= "<tr>";
            foreach ($invoice->toArray() as $value) {
                $table .= "<td>$value</td>";
            }
            $table .= "</tr>";
        }
        $table .= "</table>";
        return $table;
    }

    public function saveToCSVFile(string $fileNote = ''): string
    {
        $csv = implode(',', array_column(Invoice::OVERDUE_REPORT_FIELDS, 'label')) . "\n";
        foreach ($this->invoices as $invoice) {
            $csv .= implode(',', $invoice->toArray()) . "\n";
        }
        $fileName = "{$this->fileStorage}/" . date('Y-m-d_H-i-s') . "_{$fileNote}_invoices.csv";
        file_put_contents($fileName, $csv);
        return $fileName;
    }
}
