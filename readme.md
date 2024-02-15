Hello!

Our car repair shop has its own custom-built CRM and Invoicing System, and we need to make some upgrades to it.

The owner wants a list of the invoices that are past due so that we can collect payment.
Past Due Invoices are beyond 30 days old after the creation date and unpaid.
Our receptionist will contact each customer to let the customer know of their invoices.
The receptionist will need:
- the customer's name 
- and phone number 
- as well as the invoice date 
- and the amount owed.

The receptionist may want the results used in other places in the future -- maybe to export as a CSV or PDF.

app.php is a fake CLI tool that can be used to run the code.

Steps:
- Update and create classes that need modification as you see fit
- Create a test for this new logic.

Set up and running tests:
Use php >= 8.0
run: composer install
run: vendor/bin/phpunit tests/
run: php app.php
