<?php

use App\Models\User;
use Illuminate\Support\Facades\Broadcast;

// para syang gates to authenticate if the passed id is authorized na mag enter sa channel
Broadcast::channel('users.{id}', function (User $user, $id) {
    return (int) $user->id === (int) $id;
});