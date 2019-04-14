<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserSistema extends Authenticatable {
    use Notifiable;

    protected $table = "users";
    public $timestamps = false;

    public function user() {
        return $this->belongsTo('App\User', 'id', 'id_user');
    }

    public function balances() {
        return $this->hasMany('App\Balance', 'bot_id', 'id');
    }

    public function operations() {
        return $this->hasMany('App\Operation', 'bot_id', 'id');
    }
}
