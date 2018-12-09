<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prodcomm extends Model
{
    protected $guarded = ['id'];
    
    public function orders() {
        return $this->morphOne(Order::class, 'bussinesstypetable');
    }

    public function createProdcomm($prodcomm){
        $created = Prodcomm::create($prodcomm);
        return $created->id;
    }
}
