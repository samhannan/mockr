<?php

use App\Http\Controllers\InvokeEndpointController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'api.',
], function ()
{
    Route::match(['get', 'post', 'put', 'patch', 'delete'], '/e/{key}', InvokeEndpointController::class)
        ->name('endpoint');
});
