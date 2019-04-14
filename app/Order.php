<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {

    public function operation() {
        return $this->belongsTo('App\Operation', 'operation_id', 'id');
    }
}
