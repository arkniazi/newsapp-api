<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserPreferenceRequest;
use App\Http\Resources\UserPreferenceResource;
use App\Models\UserPreference;
use Illuminate\Support\Facades\Auth;

class UserPreferencesController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @return UserPreferenceResource
     */
    public function fetch()
    {
        $user = Auth::user();
        $preferences = UserPreference::where('user_id', $user->id)->first();

        if (!$preferences) {
            return response()->json(['message' => 'Preferences not found'], 404);
        }

        return new UserPreferenceResource(json_decode($preferences->preferences));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserPreferenceRequest $request)
    {
        $user = Auth::user();
        $preferences = UserPreference::where('user_id', $user->id)->first();
        if(!$preferences){
            $preferences = UserPreference::make();
        }
        $preferences->user_id = $user->id;
        $preferences->preferences = json_encode($request->validated());
        $preferences->save();
        
        return response()->json([
            'message' => 'Preferences updated successfully',
            'preferences' => new UserPreferenceResource(json_decode($preferences->preferences)),
        ]);
    }
}
