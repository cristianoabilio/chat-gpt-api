<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GenerateContent extends Model
{
    protected $guarded = [];

    protected function user()
    {
        return $this->belongsTo(User::class);
    }

    protected function template()
    {
        return $this->belongsTo(Template::class);
    }
}
