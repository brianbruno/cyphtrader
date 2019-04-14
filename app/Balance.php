<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model {

    public function bot() {
        return $this->hasOne('App\UserSistema', 'id', 'bot_id')->first();
    }

}
