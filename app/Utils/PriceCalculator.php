<?php

namespace App\Utils;

use App\Exceptions\NoPriceForProvidedPeriodException;
use App\Models\Vacancy;
use Illuminate\Support\Carbon;

class PriceCalculator
{
    /**
     * @throws NoPriceForProvidedPeriodException
     */
    public static function calculate(Carbon $startsAt, Carbon $endsAt): int
    {
        $vacancies = Vacancy::select(['when', 'price'])->whereBetween('when', [$startsAt, $endsAt])->get();

        if ($vacancies->count() < $startsAt->diff($endsAt)->days + 1) {
            throw new NoPriceForProvidedPeriodException();
        }

        return $vacancies->sum('price');
    }
}
