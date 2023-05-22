<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailOrder extends Model
{
    //
    protected $table = 'detail_order';

    protected $fillable = ['order_id', 'product_id','qty','price'];
    public function order(){
        //1 chi tiết hóa đơn có thể thuộc vào nhiều danh mục
        return $this->belongsTo('App\Order','order_id');
    }
    public function product(){
      
        return $this->belongsTo('App\Product','product_id');
    }
}
