<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;

final class ShowBookingController extends Controller
{
    public function __invoke(Booking $booking): BookingResource
    {
        $booking->load('user');

        return new BookingResource($booking);
    }
}
