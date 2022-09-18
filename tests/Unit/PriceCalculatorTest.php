<?php

namespace Tests\Unit;

use App\Exceptions\NoPriceForProvidedPeriodException;
use App\Models\Vacancy;
use App\Utils\PriceCalculator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PriceCalculatorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @dataProvider correctData
     */
    public function test_price(string $startsAt, string $endsAt, array $vacancies, int $expectedPrice)
    {
        Vacancy::factory()->createMany($vacancies);

        $price = PriceCalculator::calculate(new Carbon($startsAt), new Carbon($endsAt));

        $this->assertEquals($expectedPrice, $price);
    }

    /**
     * @test
     *
     * @dataProvider failData
     */
    public function test_exception(string $startsAt, string $endsAt, array $vacancies)
    {
        $this->expectException(NoPriceForProvidedPeriodException::class);

        Vacancy::factory()->createMany($vacancies);

        PriceCalculator::calculate(new Carbon($startsAt), new Carbon($endsAt));
    }


    private function failData(): array
    {
        return [
            'scenario 1' => [
                'starts_at' => '2023-01-01',
                'ends_at' => '2023-01-03',
                'vacancies' => [
                    [
                        'when' => '2023-01-03',
                        'amount' => '2',
                        'price' => 100,
                    ],
                    [
                        'when' => '2023-01-04',
                        'amount' => '3',
                        'price' => 200,
                    ],
                    [
                        'when' => '2023-01-05',
                        'amount' => '1',
                        'price' => 300,
                    ]
                ],
            ],
            'scenario 2' => [
                'starts_at' => '2023-01-01',
                'ends_at' => '2023-01-01',
                'vacancies' => [],
            ]
        ];
    }

    private function correctData(): array
    {
        return [
            'scenario 1' => [
                'starts_at' => '2023-01-01',
                'ends_at' => '2023-01-03',
                'vacancies' => [
                    [
                        'when' => '2023-01-01',
                        'amount' => '2',
                        'price' => 100,
                    ],
                    [
                        'when' => '2023-01-02',
                        'amount' => '3',
                        'price' => 200,
                    ],
                    [
                        'when' => '2023-01-03',
                        'amount' => '1',
                        'price' => 300,
                    ]
                ],
                'result' => 600
            ],
            'scenario 2' => [
                'starts_at' => '2023-01-01',
                'ends_at' => '2023-01-01',
                'vacancies' => [
                    [
                        'when' => '2023-01-01',
                        'amount' => '2',
                        'price' => 100,
                    ],
                    [
                        'when' => '2023-01-02',
                        'amount' => '3',
                        'price' => 200,
                    ],
                    [
                        'when' => '2023-01-03',
                        'amount' => '1',
                        'price' => 300,
                    ]
                ],
                'result' => 100
            ]
        ];
    }
}
