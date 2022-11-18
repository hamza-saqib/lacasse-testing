<?php

namespace App\Shop\Products\Transformations;

use App\Shop\Products\Product;
use Illuminate\Support\Facades\Storage;

trait ProductTransformable
{
    /**
     * Transform the product
     *
     * @param Product $product
     * @return Product
     */
    protected function transformProduct(Product $product)
    {
        $prod = new Product;
        $prod->id = (int) $product->id;
        $prod->name = $product->name;
        $prod->item_number = $product->item_number;
        $prod->sku = $product->sku;
        $prod->slug = $product->slug;
        $prod->is_part = $product->is_part;
        $prod->description = $product->description;
        $prod->summary = $product->summary;
        $prod->shopName = $product->shop? $product->shop->name : '';
        $prod->cover = asset("storage/$product->cover");
        $prod->quality = $product->quality;
        $prod->price = $product->price;
        $prod->status = $product->status;
        $prod->weight = (float) $product->weight;
        $prod->mass_unit = $product->mass_unit;
        $prod->sale_price = $product->sale_price;
        $prod->transportation_price = $product->transportation_price;
        $prod->brand_id = (int) $product->brand_id;

        $prod->car_model = (int) $product->car_model;
        $prod->car_submodel = (int) $product->car_submodel;
        $prod->sub_part = (int) $product->sub_part;
        $prod->pieces = $product->pieces;
        return $prod;
    }
}
