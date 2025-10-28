<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatConversation extends Model
{
    protected $guarded = [];


    protected function assistant()
    {
        return $this->belongsTo(ChatAssistant::class);
    }

    protected function conversation()
    {
        return $this->belongsTo(ChatConversation::class, 'conversation_id');
    }

    protected function user()
    {
        return $this->belongsTo(User::class);
    }
}
