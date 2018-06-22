<?php

namespace App\Http\Requests;

use App\Models\ProductSku;
use Illuminate\Foundation\Http\FormRequest;

class AddCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'sku_id'=>[
                'required',
                function ($attribute, $value, $fail) {
                    if (!$sku = ProductSku::find($value)) {
                        $fail('该商品不存在');
                    }
                    if (!$sku->product->on_sale) {
                        $fail('该商品未上架');
                    }
                    if ($sku->stock === 0) {
                        $fail('该商品已售完');
                    }
                    if ($sku->stock < $this->input('amount')) {
                        $fail('该商品库存不足');
                    }
                },
            ],
            'amount'=>['required','numeric','min:1']
        ];
    }

    public function messages()
    {
        return [
          'sku_id.required'=>'请选择商品'
        ];
    }
    public function attributes()
    {
        return ['amount'=>'商品数量'];
    }
}
