<?php

declare(strict_types = 1);

namespace App\Enums;

enum Logger
{
    case Info;
    case Error;

    public function label(): string
    {
        return match ($this) {
            self::Info => 'info',
            self::Error => 'Error'
        };
    }
}
