<?php

namespace App\Enums;

enum UnitOfMeasure: string
{
    case UNIDAD = 'unidad/es';
    case KG = 'kg';
    case M = 'm';
    case LT = 'lt';
    case HORA = 'hora';

    public static function values(): array
    {
        return array_map(fn(self $c) => $c->value, self::cases());
    }
}
