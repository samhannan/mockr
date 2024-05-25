<?php

namespace Tests\Http\Controllers;

use App\Actions\StoreEndpointAction;
use App\Models\Endpoint;
use Tests\TestCase;

class EndpointControllerTest extends TestCase
{
    public function test_can_create_an_endpoint()
    {
        $this->actingAs($this->user);

        $this->withoutExceptionHandling();

        $this->partialMock(StoreEndpointAction::class, function ($mock) {
            $mock->shouldReceive('generateKey')
                ->andReturn('ABC123');
        });

        $this
            ->followingRedirects()
            ->post(route('endpoints.store'), [
                'method' => 'post',
                'status_code' => 200,
                'delay' => 3,
            ])
            ->assertOk();

        $this->assertDatabaseHas('endpoints', [
            'method' => 'post',
            'status_code' => 200,
            'delay' => 3,
            'user_id' => $this->user->id,
            'key' => 'ABC123',
            'url' => route('api.endpoint', ['key' => 'ABC123']),
        ]);
    }

    public function test_can_delete_an_endpoint()
    {
        $this->actingAs($this->user);

        $this->withoutExceptionHandling();

        $endpoint = Endpoint::factory()
            ->for($this->user)
            ->create();

        $this
            ->followingRedirects()
            ->delete(route('endpoints.destroy', $endpoint))
            ->assertOk();

        $this->assertSoftDeleted('endpoints', [
            'id' => $endpoint->id,
        ]);
    }
}
