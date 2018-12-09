<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCartRequest;
use App\Models\CarItem;
use App\Models\ProductSku;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(ProductSku $productSku,AddCartRequest $request){
        $user = $request->user();
        $skuId = $request->sku_id;
        $amount = $request->amount;

        if ($cart = CarItem::where('product_sku_id',$skuId)->first()){
            $cart->update([
               'amount'=>$cart->amount + $amount
            ]);
        }else{
//            否则创建一个新的购物车记录
            $cart = new CarItem(['amount'=>$amount]);
            $cart->user()->associate($user);
            $cart->productSku()->associate($skuId);
            $cart->save();
        }
        return [];
    }
    public function index(Request $request){
        $cartItems = $request->user()->carItem()->with(['productSku.product'])->get();
        //已有收货地址列表
        $addresses = $request->user()->addresses()->orderBy('last_used_at','desc')->get();
        return view('cart.index',compact('cartItems','addresses'));
    }
    public function destroy(Request $request,ProductSku $sku){
        $request->user()->carItem()->where('product_sku_id',$sku->id)->delete();
        return [];
    }
}
