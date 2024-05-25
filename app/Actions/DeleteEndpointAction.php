<?php

namespace App\Actions;

use App\Models\Endpoint;

class DeleteEndpointAction
{
    public function handle(Endpoint $endpoint): void
    {
        $endpoint->delete();
    }
}
