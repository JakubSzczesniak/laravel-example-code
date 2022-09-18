<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

final class StoreUserController extends Controller
{
    public function __invoke(StoreUserRequest $request): UserResource
    {
        $user = User::create(array_merge($request->validated(), [
            'password' => Hash::make($request->get('password')),
        ]));

        return new UserResource($user);
    }
}
