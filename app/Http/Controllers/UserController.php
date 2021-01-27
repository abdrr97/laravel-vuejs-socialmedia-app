<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function view_profile(User $user)
    {
        return view('user.profile', [
            'user' => $user
        ]);
    }

    public function follow(User $user)
    {
        $friend = auth()->user()->follow($user);
    }
}
