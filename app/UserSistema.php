<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserSistema extends Authenticatable {
    use Notifiable;

    protected $table = "users";
    public $timestamps = false;

}
