<?php



namespace App\Shop\Shops;



use App\Shop\Products\Product;

use Illuminate\Database\Eloquent\Model;



class Shop extends Model

{

    protected $fillable = ['name', 'status'];



    /**

     * @return \Illuminate\Database\Eloquent\Relations\HasMany

     */

    public function products()

    {

        return $this->hasMany(Product::class);

    }

    public function noOfProducts()
    {
        return count($this->hasMany(Product::class)->get());
    }

    public function noOfOrders()
    {
        return count($this->hasMany(Product::class)->join('order_product', 'order_product.product_id', 'products.id')
        ->join('orders', 'orders.id', 'order_product.order_id')->get());
    }

    public function noOfCompletedOrders()
    {
        return count($this->hasMany(Product::class)->join('order_product', 'order_product.product_id', 'products.id')
        ->join('orders', 'orders.id', 'order_product.order_id')->where('order_status_id')->get());
    }

    public function totalCompletedOrdersAmount()
    {
        return $this->hasMany(Product::class)->join('order_product', 'order_product.product_id', 'products.id')
        ->join('orders', 'orders.id', 'order_product.order_id')->where('order_status_id')->sum('orders.total_paid');
    }
}

