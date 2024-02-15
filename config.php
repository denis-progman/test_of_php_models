<?php
return [
    "app" => [
        "timezone" => env('APP_TIMEZONE', 'UTC'),
        "file_storage" => "files",
    ],
    "invoice" => [
        "payment_due" => env('INVOICE_DUE_DAYS', 30),
    ],
];
