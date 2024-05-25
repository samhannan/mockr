<?php

namespace Database\Factories;

use App\Models\Endpoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class EndpointFactory extends Factory
{
    protected $model = Endpoint::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->url(),
            'method' => $this->faker->randomElement(['get', 'post', 'put', 'patch', 'delete']),
            'status_code' => $this->faker->randomElement(['200', '201', '400', '401', '404', '500']),
            'key' => $this->faker->randomNumber(8)
        ];
    }
}
