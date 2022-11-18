<?php



namespace App\Shop\Shops\Repositories;

use App\Shop\Products\Product;
use Jsdecena\Baserepo\BaseRepository;

use App\Shop\Shops\Shop;
use Illuminate\Support\Collection;
use App\Shop\Shops\Repositories\Interfaces\ShopRepositoryInterface;

use App\Shop\Shops\Transformations\ShopTransformable;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class ShopRepository extends BaseRepository implements ShopRepositoryInterface

{

    use ShopTransformable;

    /**

     * ShopRepository constructor.

     * @param Shop $shop

     */

    public function __construct(Shop $shop)

    {

        parent::__construct($shop);

        $this->model = $shop;

    }



    /**

     * List all the Shops

     *

     * @param string $order

     * @param string $sort

     * @param array $columns

     * @return Collection

     */

    public function getAllShops(string $order = 'id', string $sort = 'desc', array $columns = ['*']) : Collection

    {

        return $this->all($columns, $order, $sort);

    }


    public function findShopById($shopId) : Shop
    {
        try {

            return $this->transformShop($this->findOneOrFail($shopId));

        } catch (Exception $e) {

            throw new Exception($e);

        }
    }

    
    public function createShop(array $params) : Shop
    {
        try {
            $data = collect($params)->all();
            $shop = new Shop($data);
            $shop->save();

            return $shop;
        } catch (QueryException $e) {
            throw new Exception($e->getMessage(), 500, $e);
        }
    }

    public function updateShop(int $shopId, array $params)
    {
        $shop = $this->findOneOrFail($shopId);
        try {
            if($shop->status != $params['status']){
                Product::where('shop_id', $shopId)->update(['status'=>$params['status']]);
            }
            return $shop->update($params);
        } catch (QueryException $e) {
            throw new Exception($e);
        }
    }

    public function deleteShop(int $shopId) : bool
    {
        $shop = $this->findOneOrFail($shopId);
        return $shop->delete();
    }
}

