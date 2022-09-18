<?php

namespace App\Http\Controllers\Booking;

use App\Http\Controllers\Controller;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

final class IndexBookingController extends Controller
{
    public function __invoke(Request $request): ResourceCollection
    {
        DB::connection()->enableQueryLog();
        $bookings = Booking::with([
            'stateHistory' => function($q) {
                $q->where('field', '=', 'status');
            }
        ])->paginate();

        return BookingResource::collection($bookings)->additional([DB::getQueryLog()]);
    }
}
