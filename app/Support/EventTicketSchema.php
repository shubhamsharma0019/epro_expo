<?php

namespace App\Support;

use Illuminate\Support\Facades\Schema;

class EventTicketSchema
{
    public static function isReady(): bool
    {
        static $ready = null;

        if ($ready !== null) {
            return $ready;
        }

        $ready = Schema::hasTable('bookings') && Schema::hasTable('tickets');

        return $ready;
    }
}
