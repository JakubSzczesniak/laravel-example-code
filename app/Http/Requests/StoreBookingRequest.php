<?php

namespace App\Http\Requests;

use App\Models\Vacancy;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

final class StoreBookingRequest extends FormRequest
{
    protected $stopOnFirstFailure = false;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '*.starts_at' => ['required', 'date', 'after:today'],
            '*.ends_at' => ['required', 'date', 'after:starts_at'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            collect($validator->safe()->all())->each(function($period, $index) use ($validator) {
                $startsAt = new CarbonImmutable($period['starts_at']);
                $endsAt = new CarbonImmutable($period['ends_at']);

                $vacancies = Vacancy::select(['when'])
                    ->whereBetween('when', [$startsAt, $endsAt])
                    ->where('amount', '>', 0)
                    ->get();

                if ($vacancies->count() < ($startsAt->diff($endsAt)->days + 1)) {
                    $validator->errors()->add(
                        sprintf('period.%d', $index), 'No vacancies for this period'
                    );
                }
            });
        });
    }
}
