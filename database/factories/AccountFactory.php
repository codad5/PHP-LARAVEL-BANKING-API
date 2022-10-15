<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            "user_id" => User::all()->random()->id,
            "name" => $this->faker->name(),
            "password" => $this->faker->password(),
            "account_number" => $this->faker->numerify('###-###-####'),
            "account_type" => $this->faker->randomElement(["savings", "current"]),
            "account_balance" => $this->faker->randomFloat(2, 0, 100000),
            "account_status" => $this->faker->randomElement(["active", "inactive"])
        ];
    }
}
