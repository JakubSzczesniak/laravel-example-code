<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class VacancyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'when' => $this->faker->dateTimeBetween('now', '+ 1 year'),
            'price' => $this->faker->numberBetween(1000,10000),
            'amount' => $this->faker->numberBetween(1, 10),
        ];
    }
}
