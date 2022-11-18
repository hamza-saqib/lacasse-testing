<?php

namespace App\Http\Controllers\Admin\Shops;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Shop\Products\Product;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Orders\Repositories\Interfaces\OrderRepositoryInterface;
use App\Shop\Orders\Transformers\OrderTransformable;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Shops\Repositories\ShopRepository;
use App\Shop\Shops\Repositories\Interfaces\ShopRepositoryInterface;
use App\Shop\Shops\Shop;
use App\Shop\Shops\Transformations\ShopTransformable;

class ShopController extends Controller
{
    use ShopTransformable, ProductTransformable, OrderTransformable;

    private $shopRepo;
    private $productRepo;
    private $orderRepo;

    public function __construct(ShopRepositoryInterface $shopRepository,
                                ProductRepositoryInterface $productRepository,
                                OrderRepositoryInterface $ordreRepository) {
        $this->shopRepo = $shopRepository;
        $this->productRepo = $productRepository;
        $this->orderRepo = $ordreRepository;

        $this->middleware(['permission:create-product, guard:employee'], ['only' => ['create', 'store']]);
        $this->middleware(['permission:update-product, guard:employee'], ['only' => ['edit', 'update']]);
        $this->middleware(['permission:delete-product, guard:employee'], ['only' => ['destroy']]);
        $this->middleware(['permission:view-product, guard:employee'], ['only' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->shopRepo->getAllShops();
        $shops = $list->map(function (Shop $shop) {
            return $this->transformShop($shop);
        })->all();

        return view('admin.shops.list', [
            'shops' => $this->shopRepo->paginateArrayResults($shops, 25)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.shops.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->shopRepo->createShop($request->except('_token', '_method'));
        return redirect()->route('admin.shops.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $shop = $this->shopRepo->findShopById($id);
        return view('admin.shops.show', compact('shop'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('admin.shops.edit', ['shop' => $this->shopRepo->findShopById($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $data = $request->except('_method', '_token');

        if($this->shopRepo->updateShop($id, $data)){
            $request->session()->flash('message', 'Update successful');
            return redirect()->route('admin.shops.edit', $id);
        } else {
            $request->session()->flash('message', 'Error While Updating');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->shopRepo->deleteShop($id);

        return redirect()->route('admin.shops.index')->with('message', 'Delete successful');
    }

    
    public function showProducts($id)
    {
        $shop = $this->shopRepo->findShopById($id);
        $list = $shop->products;
        
        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        $noOfActiveProducts = Product::where('status', 1)->where('shop_id', $id)->count();
        $totalActiveAmount = Product::where('status', 1)->where('shop_id', $id)->sum('price');
        $noOfProducts = Product::where('shop_id', $id)->count();
        $totalAmount = Product::where('shop_id', $id)->sum('price');

        return view('admin.products.list', [
            'products' => $this->productRepo->paginateArrayResults($products, 25),
            'noOfActiveProducts'=>$noOfActiveProducts,
            'totalActiveAmount'=>$totalActiveAmount,
            'noOfProducts'=>$noOfProducts,
            'totalAmount'=>$totalAmount,
        ]);
    }

    public function showOrders($id)
    {
        $startDate = request()->input('start_date') ?? null;
        $endDate = request()->input('end_date') ?? null;

        $shop = $this->shopRepo->findShopById($id);
        $list = $this->orderRepo->listOrdersByShop($id, $startDate, $endDate, 'created_at', 'desc');

        if (request()->has('q')) {
            $list = $this->orderRepo->searchOrder(request()->input('q') ?? '');
        }

        $orders = $this->orderRepo->paginateArrayResults($this->transFormOrders($list), 10);

        $pendingOrders = 0;
        $totalOrders = count($orders);
        $totalAmount = 0;
        $totalAmountRecived = 0;
        foreach ($orders as $key => $order) {
            if($order->order_status_id == 2){
                $pendingOrders = $pendingOrders + 1;
            } elseif ($order->order_status_id == 1) {
                $totalAmountRecived = $totalAmountRecived + $order->total_paid;
            }
            $totalAmount = $totalAmount + $order->total_paid;
        }

        return view('admin.orders.list', [  'shopId' => $id,
                                            'orders' => $orders,
                                            'pendingOrders'=>$pendingOrders,
                                            'totalOrders'=>$totalOrders,
                                            'totalAmount'=>$totalAmount,
                                            'totalAmountRecived'=>$totalAmountRecived ]);
    }
}
