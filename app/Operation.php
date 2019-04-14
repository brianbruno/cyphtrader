<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model {

    public function orders() {
        return $this->hasMany('App\Order', 'operation_id', 'id');
    }

    public function bot() {
        return $this->belongsTo('App\UserSistema', 'bot_id', 'id');
    }

}
