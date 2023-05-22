<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $table = 'orders';

    protected $fillable = ['customer_id', 'order_code','date_order','total','payment','note','status'];
    public function detail_orders(){
        //1 hóa đơn có thể có nhiều chi tiết hóa đơn 
        return $this->hasMany('App\DetailOrder');
    }
    public function customer(){
        //1 đơn hàng chỉ có 1 khách đặt hàng
        return $this->belongsTo('App\Customer','customer_id');
    }

}
