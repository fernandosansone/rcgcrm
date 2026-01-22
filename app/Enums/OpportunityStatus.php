<?php

namespace App\Enums;

enum OpportunityStatus: string
{
    case PROSPECTO = 'prospecto';
    case COTIZACION = 'cotizacion';
    case GANADA = 'ganada';
    case RECHAZADA = 'rechazada';
    case PERDIDA = 'perdida';

    /**
     * Estados finales (no se recontacta)
     */
    public function isFinal(): bool
    {
        return in_array($this, [
            self::GANADA,
            self::PERDIDA,
        ]);
    }

    /**
     * Estados que permiten seguimiento
     */
    public function allowsFollowUp(): bool
    {
        return !$this->isFinal();
    }
}
