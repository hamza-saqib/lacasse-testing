<?php

namespace App\Shop\Shops\Transformations;

use App\Shop\Shops\Shop;

trait ShopTransformable
{
    /**
     * Transform the shop
     *
     * @param Shop $shop
     * @return Shop
     */
    protected function transformShop(Shop $shop)
    {
        $shopTemp = new Shop;
        $shopTemp->id = (int) $shop->id;
        $shopTemp->name = $shop->name;
        $shopTemp->status = $shop->status;
        $shopTemp->noOfProducts = $shop->noOfProducts();
        $shopTemp->noOfOrders = $shop->noOfOrders();
        $shopTemp->noOfCompletedOrders = $shop->noOfCompletedOrders();
        $shopTemp->totalCompletedOrdersAmount = $shop->totalCompletedOrdersAmount();
        $shopTemp->created_at = $shop->created_at;
        $shopTemp->updated_at = $shop->updated_at;
        
        return $shopTemp;
    }
}
