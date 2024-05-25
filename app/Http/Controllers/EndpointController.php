<?php

namespace App\Http\Controllers;

use App\Actions\DeleteEndpointAction;
use App\Actions\StoreEndpointAction;
use App\Http\Requests\StoreEndpointRequest;
use App\Models\Endpoint;
use Illuminate\Http\Request;

class EndpointController extends Controller
{
    public function index(Request $request)
    {
    }

    public function create()
    {
    }

    public function store(StoreEndpointRequest $request, StoreEndpointAction $action)
    {
        $action->handle($request->toData(), $request->user());

        session()->flash('success', 'Endpoint created successfully');

        return redirect()->back();
    }

    public function show(Endpoint $endpoint)
    {
    }

    public function edit(Endpoint $endpoint)
    {
    }

    public function update(Request $request, Endpoint $endpoint)
    {
    }

    public function destroy(Endpoint $endpoint, DeleteEndpointAction $action)
    {
        $action->handle($endpoint);

        return redirect()->back();
    }
}
