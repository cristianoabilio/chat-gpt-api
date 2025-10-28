<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatAssistant extends Model
{
    protected $guarded = [];


    protected function conversation()
    {
        return $this->hasMany(ChatConversation::class, 'assistant_id');
    }
}
