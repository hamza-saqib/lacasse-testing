<?php
namespace App\Http\Controllers\Front;



use App\Shop\Products\Product;

use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;

use App\Http\Controllers\Controller;

use App\Shop\Products\Transformations\ProductTransformable;

use Illuminate\Http\Request;

use DB;

class ProductController extends Controller

{

    use ProductTransformable;



    /**

     * @var ProductRepositoryInterface

     */

    private $productRepo;



    /**

     * ProductController constructor.

     * @param ProductRepositoryInterface $productRepository

     */

    public function __construct(ProductRepositoryInterface $productRepository)

    {

        $this->productRepo = $productRepository;

    }



    /**

     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     */

    public function search()

    {

        if (request()->has('q') && request()->input('q') != '') {

            $list = $this->productRepo->searchProduct(request()->input('q'));

        } else {

            $list = $this->productRepo->listProducts();

        }



        $products = $list->where('status', 1)->map(function (Product $item) {

            return $this->transformProduct($item);

        });



        return view('front.products.product-search', [

            'products' => $this->productRepo->paginateArrayResults($products->all(), 10)

        ]);

    }



    /**

     * Get the product

     *

     * @param string $slug

     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View

     */

    public function show(string $slug)

    {

        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);

        $images = $product->images()->get();

        $category = $product->categories()->first();

        $productAttributes = $product->attributes;



        return view('front.products.product', compact(

            'product',

            'images',

            'productAttributes',

            'category'

        ));

    }



    public function showallproducts(string $ispart, string $make, string $model)

    {
        

        $products = $this->productRepo->findProductByIsPart($ispart);




        // $images = $product->images()->get();

        // $category = $product->categories()->first();

        // $productAttributes = $product->attributes;

       // echo "<pre>";print_r($product);die; 
        
        return view('front.products.products-page', compact(

            'products'

            // 'images',

            // 'productAttributes',

            // 'category'

        ));

    }



    public function showproducts(string $slug)

    {

        $product = $this->productRepo->findProductBySlug(['slug' => $slug]);

        $images = $product->images()->get();

        $category = $product->categories()->first();

        $productAttributes = $product->attributes;

       // echo "<pre>";print_r($images);die;

        return view('front.products.product-detail', compact(

            'product',

            'images',

            'productAttributes',

            'category'

        ));

    }





    public function addwishlist(Request $request)

    {

        $check =  DB::table('wishlist')

        ->where('user_id', '=', \Auth::id())

        ->where('product_id', '=', $request->productid)

        ->get();

         $list = $check->count();

         if($list == 0){

            DB::insert('insert into wishlist (user_id, product_id) values (?, ?)', [\Auth::id(), $request->productid]);

            return "Added successfully";

         }else{

            return "You have already added";

         }

        

        

    }

    public function wishlist()

    {

       $list = DB::table('wishlist')

        ->select("*")

        ->where('user_id', '=', \Auth::id())

        ->get();

        $products = array();

        foreach ($list as $li) {

            $product = $this->productRepo->findProductById($li->product_id);

            array_push($products, $product);

        }

        return view('front.products.wishlist', compact(

            'products'

        ));

    }



    public function removewishlist(Request $request)

    {

        DB::table('wishlist')

        ->where('product_id', $request->productid)

        ->where('user_id',\Auth::id())

        ->delete();

        return "Successfully deleted";

    }

}

