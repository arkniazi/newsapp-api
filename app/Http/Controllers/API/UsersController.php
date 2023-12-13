<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return UserResource
     */
    public function update(UpdatePasswordRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return new UserResource($user);
    }

}
