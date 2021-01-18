<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGateway extends Model
{
    protected $fillable = ['user_id', 'gateway_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gateway()
    {
        return $this->belongsTo(Gateway::class);
    }
}
