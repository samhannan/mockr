<?php

namespace Tests\Actions;

use App\Actions\StoreEndpointAction;
use Tests\TestCase;

class StoreEndpointActionTest extends TestCase
{
    public function test_will_generate_an_endpoint()
    {
        $action = $this->partialMock(StoreEndpointAction::class, function ($mock) {
            $mock
                ->shouldReceive('generateKey')
                ->andReturn('ABC123');
        });

        $endpoint = $action->generateEndpoint();

        $this->assertEquals(route('api.endpoint', ['key' => 'ABC123']), $endpoint);
    }

    public function test_will_keep_generating_key_until_unique()
    {
        // @todo
    }
}
