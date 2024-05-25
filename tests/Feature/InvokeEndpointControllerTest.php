<?php

namespace Tests\Feature;

use App\Http\Controllers\InvokeEndpointController;
use App\Models\Endpoint;
use Tests\TestCase;

class InvokeEndpointControllerTest extends TestCase
{

    public function test_returns_405_if_method_does_not_match_endpoint_method()
    {
        $endpoint = Endpoint::factory()
            ->for($this->user)
            ->create([
                'method' => 'post',
            ]);

        $this->get(route('api.endpoint', ['key' => $endpoint->key]), [
            'method' => 'post',
        ])
            ->assertStatus(405);
    }

    public function test_delays_response_if_endpoint_has_delay()
    {
        $this->partialMock(InvokeEndpointController::class, function ($mock) {
            $mock->shouldReceive('delay')
                ->once()
                ->with(1);
        });

        $this->withoutExceptionHandling();

        $endpoint = Endpoint::factory()
            ->for($this->user)
            ->create([
                'method' => 'get',
                'delay' => 1,
                'status_code' => 200,
            ]);

        $this->get(route('api.endpoint', ['key' => $endpoint->key]))
            ->assertOk();
    }

    public static function statusCodeProvider(): array
    {
        return [
            [200],
            [201],
            [400],
        ];
    }

    /**
     * @dataProvider statusCodeProvider
     */
    public function test_returns_correct_status_code_from_endpoint(int $code)
    {
        $endpoint = Endpoint::factory()
            ->for($this->user)
            ->create([
                'method' => 'get',
                'status_code' => $code,
            ]);

        $this->get(route('api.endpoint', ['key' => $endpoint->key]))
            ->assertStatus($code);
    }

    public function test_will_return_a_404_with_an_invalid_endpoint_key()
    {
        $this->get(route('api.endpoint', ['key' => 'invalid']))
            ->assertNotFound();
    }

    public static function methodProvider(): array
    {
        return [
            ['get'],
            ['post'],
            ['put'],
            ['patch'],
            ['delete'],
        ];
    }

    /**
     * @dataProvider methodProvider
     */
    public function test_all_methods_are_accepted(string $method)
    {
        $endpoint = Endpoint::factory()
            ->for($this->user)
            ->create([
                'method' => $method,
                'status_code' => 201,
            ]);

        $this->call($method, route('api.endpoint', ['key' => $endpoint->key]))
            ->assertStatus(201);
    }
}
