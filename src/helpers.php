<?php

declare(strict_types = 1);

use App\Enums\Logger;

if (!function_exists('logger')) {
    function logger(Logger $status, string $msg, ?Throwable $e = null): void
    {
        $error = '';
        if (!is_null($e)) {
            $error = sprintf(
                "%s in %s on %d",
                $e->getMessage(),
                $e->getFile(),
                $e->getLine());
        }
        $data = sprintf("[%s] %s %s\n", $status->label(), $msg, $error);
        $output = fopen('php://output', 'wb');
        fwrite($output, $data);
    }
}
