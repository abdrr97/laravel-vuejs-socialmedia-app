<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function friends()
    {
        return $this->hasMany(Friend::class);
    }

    public function follow(User $user)
    {
        if ($this->friends()->where('friend_id', $user->id)->first())
        {
            return null;
        }
        return $this->friends()->save(new Friend([
            'friend_id' => $user->id,
        ]));
    }

    public function is_following()
    {
        return Friend::where('user_id', auth()->id())->where('friend_id', $this->id)->first();
    }
}
