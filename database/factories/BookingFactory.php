<?php

namespace Database\Factories;

use App\Enums\Booking\Status;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'starts_at' => $this->faker->date(),
            'ends_at' => $this->faker->date(),
            'status' => $this->faker->randomElement(Status::cases()),
        ];
    }
}
