<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function logged_in_user()
    {
        $user = auth()->user();
        return response()->json(['user' => $user], 200);
    }

    public function view_profile(User $user)
    {
        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function follow(User $user)
    {
        $friend = auth()->user()->follow($user);

        if ($friend === null)
            return response()->json(['message' => 'Already a Friend'], 500);

        return response()->json($friend, 200);
    }

    public function unfollow(User $user)
    {
        $following = $user->is_following();

        if ($following === null)
        {
            return response()->json(['message' => 'Im not Following you 😢'], 500);
        }
        $following->delete();
        return response()->json(['message' => 'Successfully unFollowed 😢'], 403);
    }
}
