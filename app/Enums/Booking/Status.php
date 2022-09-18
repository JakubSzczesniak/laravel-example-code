<?php

namespace App\Enums\Booking;

enum Status: string
{
    case CREATED = 'created';
    case CONFIRMED = 'confirmed';
    case CANCELED = 'canceled';
}
