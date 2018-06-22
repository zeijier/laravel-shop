<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarItem extends Model
{
    protected $fillable=['amount'];

    public $timestamps = false;//timestamps 修饰词必须为public

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function productSku(){
        return $this->belongsTo(ProductSku::class,'product_sku_id');
    }
}
