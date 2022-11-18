<?php

namespace App\Http\Controllers\Admin\Products;

use App\Shop\Attributes\Repositories\AttributeRepositoryInterface;
use App\Shop\AttributeValues\Repositories\AttributeValueRepositoryInterface;
use App\Shop\Brands\Repositories\BrandRepositoryInterface;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\ProductAttributes\ProductAttribute;
use App\Shop\Products\Exceptions\ProductInvalidArgumentException;
use App\Shop\Products\Exceptions\ProductNotFoundException;
use App\Shop\Products\Product;
use App\Shop\Shops\Shop;
use App\Shop\Products\Repositories\Interfaces\ProductRepositoryInterface;
use App\Shop\Products\Repositories\ProductRepository;
use App\Shop\Products\Requests\CreateProductRequest;
use App\Shop\Products\Requests\UpdateProductRequest;
use App\Http\Controllers\Controller;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use ProductTransformable, UploadableTrait;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepo;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * @var AttributeRepositoryInterface
     */
    private $attributeRepo;

    /**
     * @var AttributeValueRepositoryInterface
     */
    private $attributeValueRepository;

    /**
     * @var ProductAttribute
     */
    private $productAttribute;

    /**
     * @var BrandRepositoryInterface
     */
    private $brandRepo;

    /**
     * ProductController constructor.
     *
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     * @param AttributeRepositoryInterface $attributeRepository
     * @param AttributeValueRepositoryInterface $attributeValueRepository
     * @param ProductAttribute $productAttribute
     * @param BrandRepositoryInterface $brandRepository
     */
    public function __construct(
        ProductRepositoryInterface $productRepository,
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepositoryInterface $attributeRepository,
        AttributeValueRepositoryInterface $attributeValueRepository,
        ProductAttribute $productAttribute,
        BrandRepositoryInterface $brandRepository
    ) {
        $this->productRepo = $productRepository;
        $this->categoryRepo = $categoryRepository;
        $this->attributeRepo = $attributeRepository;
        $this->attributeValueRepository = $attributeValueRepository;
        $this->productAttribute = $productAttribute;
        $this->brandRepo = $brandRepository;

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
        $list = $this->productRepo->listProducts('id');

        if (request()->has('q') && request()->input('q') != '') {
            $list = $this->productRepo->searchProduct(request()->input('q'));
        }
       // $list  = $list->where('quantity','>',0); 
        $products = $list->map(function (Product $item) {
            return $this->transformProduct($item);
        })->all();

        $noOfActiveProducts = Product::where('status', 1)->count();
        $totalActiveAmount = Product::where('status', 1)->sum('price');
        $noOfProducts = Product::count();
        $totalAmount = Product::sum('price');


        return view('admin.products.list', [
            'products' => $this->productRepo->paginateArrayResults($products, 25),
            'noOfActiveProducts'=>$noOfActiveProducts,
            'totalActiveAmount'=>$totalActiveAmount,
            'noOfProducts'=>$noOfProducts,
            'totalAmount'=>$totalAmount,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //dd($this->categoryRepo->listCategories('name', 'asc'));
        //$categories = $this->categoryRepo->listCategories('name', 'asc');
        $categories = $this->categoryRepo->listProductCategories(['show_on_product'=>1], 'name', 'asc');

        $parentCats = $this->categoryRepo->rootCategories('name', 'asc');
        $brands = [];
        foreach($parentCats as $cat) $brands[] = $cat->id;
        //dd($parents);
        $carModels = $this->categoryRepo->listSubCategories('parent_id', $brands, 'name', 'asc');

        $models = [];
        foreach($carModels as $cm) $models[] = $cm->id;

        $carSubModels = $this->categoryRepo->listSubCategories('parent_id', $models, 'name', 'asc');
        //dd($carSubModels);
        $isparts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');

        $parts = [];
        foreach($isparts as $ip) $parts[] = $ip->id;
        //dd($parts);
        $sub_parts = $this->categoryRepo->listSubCategories('parent_id', $parts, 'name', 'asc');
        return view('admin.products.create', [
            'categories' => $categories,
            'isparts' => $isparts,
            //'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
            'brands'    => $this->categoryRepo->rootCategories('name', 'asc'),
            'shops'    => Shop::all(),
            'carModels' => $carModels,
            'carSubModels' => $carSubModels,
            'sub_parts' => $sub_parts,
            'default_weight' => env('SHOP_WEIGHT'),
            'weight_units' => Product::MASS_UNIT,
            'product' => new Product
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateProductRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $data = $request->except('_token', '_method');
        $shop = Shop::where('id', $data['shop_id'])->first();
        if(!isset($shop) or empty($shop))
        {
            if($shop = Shop::create(['name'=>$data['shop_id']]))
            {
                $data['shop_id'] = $shop->id;
            }
        }
        else
        {
            $data['shop_id'] = $shop->id;
        }
        $data['slug'] = str_slug($request->input('name'));
        if(!empty($request->input('is_part'))){
            $data['is_part'] = implode(",",$request->input('is_part'));
        }

        if ($request->hasFile('cover') && $request->file('cover') instanceof UploadedFile) {
            $data['cover'] = $this->productRepo->saveCoverImage($request->file('cover'));
        }
        $data['pieces'] = !empty($request->input('categories'))?implode(',', $request->input('categories')):'';
        $product = $this->productRepo->createProduct($data);

        $productRepo = new ProductRepository($product);

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }
        /*$src = '../storage/app/public/products';
        $dst = 'storage/products';
        $files = scandir($src);
        //dd($files);
        foreach($files as $file){
            if ($file != "." && $file != ".."){
                copy("$src/$file", "$dst/$file");
            }
        }*/
        return redirect()->route('admin.products.edit', $product->id)->with('message', 'Create successful');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = $this->productRepo->findProductById($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $product = $this->productRepo->findProductById($id);
        $product['shop_id'] = Product::where('id',$id)->first()->shop_id;
        // dd($product);
    //    echo "<pre>";print_r($product);die;
        $productAttributes = $product->attributes()->get();

        $qty = $productAttributes->map(function ($item) {
            return $item->quantity;
        })->sum();

        if (request()->has('delete') && request()->has('pa')) {
            $pa = $productAttributes->where('id', request()->input('pa'))->first();
            $pa->attributesValues()->detach();
            $pa->delete();

            request()->session()->flash('message', 'Delete successful');
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1]);
        }

        //$categories = $this->categoryRepo->listCategories('name', 'asc')->toTree();
        $categories = $this->categoryRepo->listProductCategories(['show_on_product'=>1], 'name', 'asc');
        $parentCats = $this->categoryRepo->rootCategories('name', 'asc');
        $brands = [];
        foreach($parentCats as $cat) $brands[] = $cat->id;
        //dd($parents);
        $carModels = $this->categoryRepo->listSubCategories('parent_id', $brands, 'name', 'asc');

        $models = [];
        foreach($carModels as $cm) $models[] = $cm->id;

        $carSubModels = $this->categoryRepo->listSubCategories('parent_id', $models, 'name', 'asc');
	    $isparts = $this->categoryRepo->listIsparts(['is_part'=>1],'name', 'asc');
        $parts = [];
        foreach($isparts as $ip) $parts[] = $ip->id;
        //dd($parts);
        $sub_parts = $this->categoryRepo->listSubCategories('parent_id', $parts, 'name', 'asc');
        // dd($product);
        return view('admin.products.edit', [
            'product' => $product,
            'images' => $product->images()->get(['src']),
            'categories' => $categories,
            'isparts' => $isparts,
            //'selectedIds' => $product->categories()->pluck('category_id')->all(),
            'selectedIds' => !empty($product->pieces)?explode(',', $product->pieces):[],
            'attributes' => $this->attributeRepo->listAttributes(),
            'productAttributes' => $productAttributes,
            'qty' => $qty,
            //'brands' => $this->brandRepo->listBrands(['*'], 'name', 'asc'),
            'brands'    => $this->categoryRepo->rootCategories('name', 'asc'),
            'shops'    => Shop::all(),
            'carModels' => $carModels,
            'carSubModels' => $carSubModels,
            'sub_parts' => $sub_parts,
            'weight' => $product->weight,
            'default_weight' => $product->mass_unit,
            'weight_units' => Product::MASS_UNIT
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateProductRequest $request
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \App\Shop\Products\Exceptions\ProductUpdateErrorException
     */
    public function update(UpdateProductRequest $request, int $id)
    {
        //dd($request->input());
        $product = $this->productRepo->findProductById($id);
        $productRepo = new ProductRepository($product);

        if ($request->has('attributeValue')) {
            $this->saveProductCombinations($request, $product);
            return redirect()->route('admin.products.edit', [$id, 'combination' => 1])
                ->with('message', 'Attribute combination created successful');
        }

        $data = $request->except(
            'categories',
            '_token',
            '_method',
            'default',
            'image',
            'productAttributeQuantity',
            'productAttributePrice',
            'attributeValue',
            'combination'
        );
        $shop = Shop::where('id', $data['shop_id'])->first();
        if(!isset($shop) or empty($shop))
        {
            if(isset($data['shop_id']))
            {
                if($shop = Shop::create(['name'=>$data['shop_id']]))
                {
                    $data['shop_id'] = $shop->id;
                }
            }
        }
        else
        {
            $data['shop_id'] = $shop->id;
        }
        $data['pieces'] = !empty($request->input('categories'))?implode(',', $request->input('categories')):'';
        $data['slug'] = str_slug($request->input('name'));

        if ($request->hasFile('cover')) {
            $data['cover'] = $productRepo->saveCoverImage($request->file('cover'));
        }

        if ($request->hasFile('image')) {
            $productRepo->saveProductImages(collect($request->file('image')));
        }

        if ($request->has('categories')) {
            $productRepo->syncCategories($request->input('categories'));
        } else {
            $productRepo->detachCategories();
        }
        $productRepo->updateProduct($data);
        /*$src = '../storage/app/public/products';
        $dst = 'storage/products';
        $files = scandir($src);
        //dd($files);
        foreach($files as $file){
            if ($file != "." && $file != ".."){
                copy("$src/$file", "$dst/$file");
            }
        }*/
        return redirect()->route('admin.products.edit', $id)
            ->with('message', 'Update successful');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($id)
    { 

        $product = $this->productRepo->findProductById($id);
        $product->categories()->sync([]);
        $productAttr = $product->attributes();

        $productAttr->each(function ($pa) {
            DB::table('attribute_value_product_attribute')->where('product_attribute_id', $pa->id)->delete();
        });

        $productAttr->where('product_id', $product->id)->delete();

        DB::table('order_product')->where('product_id', $id)->delete();
        
        //$todo->steps->delete();


        $productRepo = new ProductRepository($product);
        $productRepo->removeProduct();

        return redirect()->route('admin.products.index')->with('message', 'Delete successful');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $this->productRepo->deleteFile($request->only('product', 'image'), 'uploads');
        return redirect()->back()->with('message', 'Image delete successful');
    }

    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeThumbnail(Request $request)
    {
        $this->productRepo->deleteThumb($request->input('src'));
        return redirect()->back()->with('message', 'Image delete successful');
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return boolean
     */
    private function saveProductCombinations(Request $request, Product $product): bool
    {
        $fields = $request->only(
            'productAttributeQuantity',
            'productAttributePrice',
            'sale_price',
            'default'
        );

        if ($errors = $this->validateFields($fields)) {
            return redirect()->route('admin.products.edit', [$product->id, 'combination' => 1])
                ->withErrors($errors);
        }

        $quantity = $fields['productAttributeQuantity'];
        $price = $fields['productAttributePrice'];

        $sale_price = null;
        if (isset($fields['sale_price'])) {
            $sale_price = $fields['sale_price'];
        }

        $attributeValues = $request->input('attributeValue');
        $productRepo = new ProductRepository($product);

        $hasDefault = $productRepo->listProductAttributes()->where('default', 1)->count();

        $default = 0;
        if ($request->has('default')) {
            $default = $fields['default'];
        }

        if ($default == 1 && $hasDefault > 0) {
            $default = 0;
        }

        $productAttribute = $productRepo->saveProductAttributes(
            new ProductAttribute(compact('quantity', 'price', 'sale_price', 'default'))
        );

        // save the combinations
        return collect($attributeValues)->each(function ($attributeValueId) use ($productRepo, $productAttribute) {
            $attribute = $this->attributeValueRepository->find($attributeValueId);
            return $productRepo->saveCombination($productAttribute, $attribute);
        })->count();
    }

    /**
     * @param array $data
     *
     * @return
     */
    private function validateFields(array $data)
    {
        $validator = Validator::make($data, [
            'productAttributeQuantity' => 'required'
        ]);

        if ($validator->fails()) {
            return $validator;
        }
    }
}
