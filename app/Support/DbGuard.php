<?php

namespace App\Support;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use PDOException;
use Throwable;

class DbGuard
{
    private static ?bool $available = null;

    public static function available(): bool
    {
        if (self::$available !== null) {
            return self::$available;
        }

        if (! self::portOpen()) {
            self::$available = false;

            return false;
        }

        try {
            DB::connection()->getPdo();
            self::$available = true;
        } catch (PDOException|QueryException|Throwable) {
            self::$available = false;
        }

        return self::$available;
    }

    public static function markUnavailable(): void
    {
        self::$available = false;
    }

    public static function reset(): void
    {
        self::$available = null;
    }

    public static function isConnectionError(Throwable $exception): bool
    {
        $message = strtolower($exception->getMessage());

        if (
            str_contains($message, 'connection refused')
            || str_contains($message, 'actively refused')
            || str_contains($message, 'could not find driver')
            || str_contains($message, 'server has gone away')
            || str_contains($message, 'no such file or directory')
            || str_contains($message, 'unknown database')
        ) {
            return true;
        }

        if ($exception instanceof QueryException || $exception instanceof PDOException) {
            $code = (string) $exception->getCode();

            return in_array($code, ['2002', '2003', '1049', '1045', 'HY000'], true);
        }

        $previous = $exception->getPrevious();

        return $previous instanceof Throwable
            ? self::isConnectionError($previous)
            : false;
    }

    private static function portOpen(): bool
    {
        $host = (string) config('database.connections.mysql.host', '127.0.0.1');
        $port = (int) config('database.connections.mysql.port', 3306);
        $timeout = (float) config('database.connections.mysql.connect_timeout', env('DB_CONNECT_TIMEOUT', 1));

        $socket = @fsockopen($host, $port, $errno, $errstr, $timeout);

        if ($socket === false) {
            return false;
        }

        fclose($socket);

        return true;
    }

    public static function hasTable(string $table): bool
    {
        if (! self::available()) {
            return false;
        }

        try {
            return Schema::hasTable($table);
        } catch (PDOException|QueryException|Throwable) {
            self::$available = false;

            return false;
        }
    }

    public static function hasColumn(string $table, string $column): bool
    {
        if (! self::hasTable($table)) {
            return false;
        }

        try {
            return Schema::hasColumn($table, $column);
        } catch (PDOException|QueryException|Throwable) {
            self::$available = false;

            return false;
        }
    }

    /** @template T */
    public static function whenAvailable(callable $callback, mixed $default = null): mixed
    {
        if (! self::available()) {
            return $default instanceof \Closure ? $default() : $default;
        }

        try {
            return $callback();
        } catch (PDOException|QueryException|Throwable $exception) {
            if (self::isConnectionError($exception)) {
                self::$available = false;
            }

            return $default instanceof \Closure ? $default() : $default;
        }
    }
}
