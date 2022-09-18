<?php

namespace App\Http\Controllers\Booking;

use App\Enums\Booking\Status;
use App\Events\BookingCanceled;
use App\Http\Controllers\Controller;
use App\Http\Requests\CancelBookingRequest;
use App\Http\Resources\BookingResource;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use JakubSzczesniak\EloquentStateMachineWorkflowPro\Exceptions\TransitionNotAllowedException;

final class CancelBookingController extends Controller
{
    public function __invoke(CancelBookingRequest $request, Booking $booking): BookingResource|JsonResponse
    {
        try {
            $booking->status()->transitionTo(Status::CANCELED, [
                'reason' => $request->input('reason')
            ]);

           event(new BookingCanceled($booking));
        } catch (TransitionNotAllowedException $exception) {
            return new JsonResponse('Transition not allowed', JsonResponse::HTTP_BAD_REQUEST);
        }

        return new BookingResource($booking);
    }
}
