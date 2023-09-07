<?php

declare(strict_types=1);

use App\Http\Controllers\AuthController;
use App\Http\Controllers\V1\MessageController;
use App\Http\Controllers\V1\RoomController;
use App\Http\Controllers\V1\RoomMemberController;
use App\Http\Controllers\V1\TagController;
use App\Http\Controllers\V1\TaskController;
use App\Http\Controllers\V1\TaskStatusController;
use App\Http\Controllers\V1\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'v1',
], function () {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::post('login', [AuthController::class, 'login']);
        Route::post('refresh-token', [AuthController::class, 'refreshToken']);
        Route::get('me', [AuthController::class, 'getInfo'])->middleware('verified_token');
    });

    Route::group([
        'prefix' => '',
        'middleware' => ['api', 'verified_token'],
    ], function () {
        Route::resource('task-statuses', TaskStatusController::class);

        Route::group([
            'prefix' => 'tasks',
        ], function () {
            Route::put('order', [TaskController::class, 'order']);
            Route::put('order-by', [TaskController::class, 'orderByType']);
            Route::put('status', [TaskController::class, 'changeStatus']);
            Route::resource('/', TaskController::class);
            Route::get('latest', [TaskController::class, 'getTasksLatest']);
        });

        Route::group([
            'prefix' => 'rooms',
        ], function () {
            Route::get('latest', [RoomController::class, 'latest']);
            Route::get('type', [RoomController::class, 'getRoomsByType']);
        });

        Route::get('room-members/room', [RoomMemberController::class, 'getRoom']);


        Route::resource('rooms', RoomController::class);
        Route::resource('messages', MessageController::class);

        Route::resource('room-members', RoomMemberController::class);

    });

    Route::group([
        'prefix' => 'tags',
        'middleware' => ['api', 'verified_token'],
    ], function () {
        Route::resource('/', TagController::class);
    });

    Route::group([
        'prefix' => 'users',
        'middleware' => ['api', 'verified_token'],
    ], function () {
        Route::resource('/', UserController::class);

        Route::get('/search', [UserController::class, 'getListUserForSearch']);
    });
});
