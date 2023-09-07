<?php

declare(strict_types=1);

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('all-message', function (User $user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('room.{roomId}', function (User $user, int $roomId) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('public-channel', function (User $user) {
    return ['id' => $user->id, 'name' => $user->name];
});
