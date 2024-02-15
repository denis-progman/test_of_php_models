<?php

use App\database\Connection;
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


// Now we can to filter the invoices to find the overdue ones
$overdueInvoices = $invoices->filterOverdue();
// echo $overdueInvoices->toHtmlTable(); // for showing in a web page
// echo "OVERDUE invoices (" . count($invoices->get()) . "):\n\n" . $invoicesService->fetch()->toString(); // for showing in a terminal by the old style
echo "OVERDUE invoices (" . count($overdueInvoices->get()) . "):\n\n";
$overdueInvoices->toTerminalTable();
echo 'Saved to the file: ' . $overdueInvoices->saveToCSVFile("Overdue") . "\n"; // for saving to a file