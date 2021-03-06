<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friend extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        'id'
    ];

    public function friend()
    {
        return $this->hasOne(User::class, 'friend_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
