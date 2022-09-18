<?php

namespace App\Http\Controllers\Booking;

use App\Exceptions\NoPriceForProvidedPeriodException;
use App\Http\Controllers\Controller;
use App\Http\Requests\CalculateBookingRequest;
use App\Utils\PriceCalculator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;

final class CalculateBookingController extends Controller
{
    public function __invoke(CalculateBookingRequest $request): JsonResponse
    {
        try {
            $price = PriceCalculator::calculate(
                new Carbon($request->input('starts_at')),
                new Carbon($request->input('ends_at'))
            );
        } catch (NoPriceForProvidedPeriodException $exception) {
            return new JsonResponse('No vacancies in this period', JsonResponse::HTTP_BAD_REQUEST);
        }


        return new JsonResponse(['price' => $price], JsonResponse::HTTP_OK);
    }
}
