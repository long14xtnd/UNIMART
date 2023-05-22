<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
    protected $table = 'customers';

    protected $fillable = ['fullname', 'address','phone','email','note'];
    public function orders(){
        //1 khách hàng có thể có nhiều đơn hàng
        return $this->hasMany('App\Order');
    }
}
