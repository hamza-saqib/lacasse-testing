<?php

namespace App\Shop\Shops\Repositories\Interfaces;

use App\Shop\Shops\Shop;
use Illuminate\Support\Collection;
use Jsdecena\Baserepo\BaseRepositoryInterface;

interface ShopRepositoryInterface extends BaseRepositoryInterface
{
    public function getAllShops(string $order = 'id', string $sort = 'desc', array $columns = ['*']): Collection;
    public function findShopById($shopId): Shop;
    public function deleteShop(int $shopId): bool;
    public function createShop(array $shopDetails): Shop;
    public function updateShop(int $shopId, array $newDetails);
}
