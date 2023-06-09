<?php

namespace Database\Factories;

use App\Models\Player;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class PlayerFactory extends Factory
{
    protected $model = Player::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
