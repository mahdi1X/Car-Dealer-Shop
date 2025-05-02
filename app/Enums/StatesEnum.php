<?php

namespace App\Enums;

enum StatesEnum: string
{
    case PENDING = 'pending';
    case CANCELED = 'canceled';

    case COMPLETED ='completed';

    public static function toArray(): array
    {
       return array_column(StatesEnum::cases(), 'value');
    }
}

?>