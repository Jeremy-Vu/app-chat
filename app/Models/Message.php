<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $table = 'messages';

    protected $fillable = [
        'id',
        'user_id',
        'receiver_id',
        'message',
        'seen'
    ];

    public function user() :BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
