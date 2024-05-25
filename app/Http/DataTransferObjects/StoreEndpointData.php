<?php

namespace App\Http\DataTransferObjects;

class StoreEndpointData extends DataTransferObject
{
    public string $method;
    public ?int $delay = null;
    public int $status_code;
}
