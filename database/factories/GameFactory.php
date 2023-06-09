<?php

namespace Database\Factories;

use App\Models\Game;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class GameFactory extends Factory
{
    protected $model = Game::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
        ];
    }
}
