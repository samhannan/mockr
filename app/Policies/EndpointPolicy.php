<?php

namespace App\Policies;

use App\Models\Endpoint;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EndpointPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Endpoint $endpoint): bool
    {
        return $user->is($endpoint->creator);
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Endpoint $endpoint): bool
    {
        return $user->is($endpoint->creator);
    }

    public function delete(User $user, Endpoint $endpoint): bool
    {
        return $user->is($endpoint->creator);
    }

    public function restore(User $user, Endpoint $endpoint): bool
    {
        return $user->is($endpoint->creator);
    }

    public function forceDelete(User $user, Endpoint $endpoint): bool
    {
        return $user->is($endpoint->creator);
    }
}
