<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'path',
        'user_id',
    ];

    /**
     * Get the user that owns the game.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
