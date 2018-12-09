<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prepaid extends Model
{
    protected $guarded = ['id'];

    public function orders() {
        return $this->morphOne(Order::class, 'bussinesstypetable');
    }

    public function createPrepaid($prepaid){
        $created = Prepaid::create($prepaid);
        return $created->id;
    }
}
