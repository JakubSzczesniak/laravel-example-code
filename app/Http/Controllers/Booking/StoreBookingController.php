<?php

namespace App\Http\Controllers\Booking;

use App\Events\BookingStored;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

final class StoreBookingController extends Controller
{
    public function __invoke(StoreBookingRequest $request): ResourceCollection
    {
        $bookings = collect();

        foreach ($request->validated() as $period) {
            $booking = Booking::create(array_merge($period, ['user_id' => Auth::user()->id]));
            $bookings->push($booking);

            event(new BookingStored($booking));
        }

        return BookingResource::collection($bookings);
    }
}
