<?php

return [
    'username' => env('TICKET_SCANNER_USERNAME', 'scanner'),
    'password' => env('TICKET_SCANNER_PASSWORD', 'scanner@eproexpo'),
    'login_required' => false,
    'auto_checkin_on_scan' => true,
];
