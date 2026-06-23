<?php

namespace App\Domain\Shared\Support;

use RuntimeException;

class EnvFileUpdater
{
    /**
     * @param  array<string, string|null>  $values
     */
    public static function set(array $values, ?string $path = null): void
    {
        $path = $path ?: base_path('.env');

        if (! is_file($path) || ! is_writable($path)) {
            throw new RuntimeException('.env file is missing or not writable.');
        }

        $contents = file_get_contents($path);
        if ($contents === false) {
            throw new RuntimeException('Unable to read .env file.');
        }

        foreach ($values as $key => $value) {
            if ($value === null) {
                continue;
            }

            $escaped = self::escapeValue($value);
            $pattern = '/^' . preg_quote($key, '/') . '=.*/m';

            if (preg_match($pattern, $contents)) {
                $contents = preg_replace($pattern, $key . '=' . $escaped, $contents, 1);
            } else {
                $contents = rtrim($contents) . PHP_EOL . $key . '=' . $escaped . PHP_EOL;
            }
        }

        if (file_put_contents($path, $contents) === false) {
            throw new RuntimeException('Unable to write .env file.');
        }
    }

    protected static function escapeValue(string $value): string
    {
        if ($value === '' || preg_match('/[\s#\'"]/', $value)) {
            return '"' . str_replace('"', '\\"', $value) . '"';
        }

        return $value;
    }
}
