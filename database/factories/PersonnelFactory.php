<?php

namespace Database\Factories;

use App\Models\Personnel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Personnel>
 */
class PersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    private static $counter = 1;

    public function definition()
    {

        return [
            // 'id' => 112390 . self::$counter++,
            'first_name' => $this->faker->firstName,
            'mid_initial' => strtoupper($this->faker->randomLetter()) . '.',
            'last_name' => $this->faker->lastName,
            'sex' => $this->faker->randomElement(['male', 'female']),
            'email' => $this->faker->unique()->safeEmail,
            'phone' => '09' . $this->faker->randomNumber(9, true),
            'address' => $this->faker->streetAddress(),
            'is_admin' =>  $this->faker->boolean(),
        ];
    }
}
