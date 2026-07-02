<?php

return [
    'issuer' => [
        'name' => env('INVOICE_ISSUER_NAME', 'EproExpo Global Technologies Ltd.'),
        'address_line_1' => env('INVOICE_ISSUER_ADDRESS_1', '104 Convention Plaza, Bandra Kurla Complex'),
        'address_line_2' => env('INVOICE_ISSUER_ADDRESS_2', 'Mumbai, MH, 400051, India'),
        'email' => env('INVOICE_ISSUER_EMAIL', 'billing@eproexpo.com'),
        'support_email' => env('INVOICE_SUPPORT_EMAIL', 'support@eproexpo.com'),
        'gst_number' => env('INVOICE_ISSUER_GST'),
    ],
    'gst_rate' => (float) env('INVOICE_GST_RATE', 0),
    'currency_symbol' => env('INVOICE_CURRENCY_SYMBOL', '₹'),
    'support_email' => env('INVOICE_SUPPORT_EMAIL', 'support@eproexpo.com'),
];
