<?php

use App\database\Connection;
use App\models\Invoice;
use App\services\Invoices;

require 'core/init.php';
require __DIR__ . '/vendor/autoload.php';
require 'seeder.php';

/*
 * The receptionist will somehow run this php file to generate the list of folks to contact
 * This is in place of a neat web page in the staff CRM.
 */

// Set up our fake database
$databaseConnection = new Connection(seed());
$invoicesService = new Invoices($databaseConnection);
echo "\n\n";
$invoices = $invoicesService->fetch();
echo "ALL invoices (" . count($invoices->get()) . "):\n\n" . $invoicesService->fetch()->toString();
$overdueInvoices = $invoices->filterOverdue();
echo "OVERDUE invoices (" . count($overdueInvoices->get()) . "):\n\n" . $overdueInvoices->toString();