<?php

namespace App\Shop\Products\Requests;

use App\Shop\Base\BaseFormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends BaseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_number' => ['required'],
            'sku' => ['required'],
            'shop_id' => ['required'],
            'name' => ['required'],
            'quality' => ['required'],
            'price' => ['required']
        ];
    }
}
