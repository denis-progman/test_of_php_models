<?php
return [
    "app" => [
        "timezone" => env('APP_TIMEZONE', 'UTC'),
    ],
    "invoice" => [
        "payment_due" => env('INVOICE_DUE_DAYS', 30),
    ],
];
