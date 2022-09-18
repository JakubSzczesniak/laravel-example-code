<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;

final class ShowUserController extends Controller
{
    public function __invoke(User $user): UserResource
    {
        $user->load('bookings');

        return new UserResource($user);
    }
}
