<?php
namespace App\Http\Controllers\Admin\Categories;
use DB;
use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Admin\Categories\Requests\CreateCategoryRequest;
use App\Http\Controllers\Admin\Categories\Requests\UpdateCategoryRequest;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Shop\Categories\Category;
class CategoryController extends Controller
{
    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepo;

    /**
     * CategoryController constructor.
     *
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepo = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list = $this->categoryRepo->rootCategories('name', 'asc');

        return view('admin.categories.list', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all())
        ]);
    }

    public function carmodel()
    {
        //$list = $this->categoryRepo->rootCategories('name', 'desc');
        $list = $this->categoryRepo->listIsparts(['type'=>1], 'name', 'asc');
        return view('admin.categories.carmodel', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all())
        ]);
    }
    public function carsubmodel()
    {
        $list = $this->categoryRepo->rootCategories('created_at', 'desc');

        return view('admin.categories.list', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all())
        ]);
    }
    public function carparts()
    {
        $list = $this->categoryRepo->rootCategories('created_at', 'desc');

        return view('admin.categories.list', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all())
        ]);
    }
    public function subparts()
    {
        $list = $this->categoryRepo->rootCategories('created_at', 'desc');

        return view('admin.categories.list', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all())
        ]);
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function partgroups()
    {
        $list = $this->categoryRepo->partGroupCategories('name', 'asc');

        return view('admin.categories.parts', [
            'categories' => $this->categoryRepo->paginateArrayResults($list->all())
        ]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = $_GET['type'];
        $brands = $this->categoryRepo->listIsparts(['type'=>0], 'name', 'asc');
        $isparts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');
        //dd($brands);
        $view = 'admin.categories.create';
        if($type == 'carmodel')
        {
            $bid = $_GET['bid'];
            return view('admin.categories.create_carmodel', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc'),
                'isparts' => $isparts,
                'type' => $type,
                'bid' => $bid,
                'brands' => $brands
            ]);
        }
        elseif($type == 'carsubmodel')
        {
            $bid = $_GET['bid'];
            $mid = $_GET['mid'];
            $carmodels = $this->categoryRepo->listIsparts(['parent_id'=>$bid], 'name', 'asc');
            return view('admin.categories.create_carsubmodel', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc'),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands,
                'bid' => $bid,
                'mid' => $mid,
                'carmodels' => $carmodels
            ]);
        }
        elseif($type == 'carparts')
        {
            return view('admin.categories.create_carparts', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc'),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands
            ]);
        }
        elseif($type == 'sub_part')
        {
            $pid = $_GET['pid'];
            $carParts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');
            return view('admin.categories.create_sub_part', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc'),
                'isparts' => $isparts,
                'type' => $type,
                'carParts' => $carParts,
                'pid'       => $pid
            ]);
        }
        elseif($type == 'piece')
        {
            $spid   = $_GET['spid'];
            $pid    = $_GET['pid'];
            $carParts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');
            $subParts = $this->categoryRepo->listIsparts(['type'=>4], 'name', 'asc');
            //dd($subParts);
            return view('admin.categories.create_piece', [
                'categories'    => $this->categoryRepo->listCategories('name', 'asc'),
                'isparts'       => $isparts,
                'type'          => $type,
                'brands'        => $brands,
                'spid'          => $spid,
                'pid'           => $pid,
                'carParts'      => $carParts,
                'subParts'      => $subParts
            ]);
        }
        else{
            return view($view, [
                'categories' => $this->categoryRepo->listCategories('name', 'asc'),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands
            ]); 
        }

                /*$view = 'admin.categories.create_carmodel';
                break;
            case 'carsubmodel':
                $view = 'admin.categories.create_carsubmodel';
                break;
            case 'carparts':
                $view = 'admin.categories.create_carparts';
                break;
            case 'sub_part':
                $view = 'admin.categories.create_sub_part';
                break;
            case 'piece':
                $view = 'admin.categories.create_piece';
                break;
        endswitch;*/
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreateCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $type = $request->input('type');
        //dd($request->input());
        $this->categoryRepo->createCategory($request->except('_token', '_method'));
        if($type == 'brand')
            return redirect()->route('admin.categories.index')->with('message', 'Category created');
        elseif($type == 'carmodel'){
            $brand = $request->input('parent');
            return redirect('admin/categories/'.$brand.'?type=carmodel')->with('message', 'Car model created');
        }
        elseif($type == 'carsubmodel'){
            $brand = $request->input('parent');
            $bid = $request->input('bid');
            $mid = $request->input('mid');
            return redirect('admin/categories/'.$mid.'?type=carsubmodel')->with('message', 'Car model created');
        }
        elseif($type == 'carparts'){
            /*$src = '../storage/app/public/categories';
            $dst = 'storage/categories';
            $files = scandir($src);
            //dd($files);
            foreach($files as $file){
                if ($file != "." && $file != ".."){
                    copy("$src/$file", "$dst/$file");
                }
            }*/
            return redirect('admin/partgroups/')->with('message', 'Car part created');
        }
        elseif($type == 'sub_part'){
            /*$brand = $request->input('parent');
            $bid = $request->input('bid');*/
            $pid = $request->input('pid');
            return redirect('admin/categories/'.$pid.'?type=car_subpart')->with('message', 'Sub Part created');
        }
        elseif($type == 'piece'){
            /*$brand = $request->input('parent');
            $bid = $request->input('bid');*/
            /*"type" => "piece"
            "spid" => "85"
            "pid" => "44"
            "cp" => "44"
            "parent" => "85"
            */
            $sub_partId = $request->input('parent');
            $cp = $request->input('cp');
            return redirect('admin/categories/'.$sub_partId.'?type=part_piece&pid='.$cp)->with('message', 'Piece created');
            //admin/categories/85?type=part_piece&pid=44
        }
        //return redirect()->route('admin.categories.index')->with('message', 'Category created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $type = $_GET['type'];
        $category = $this->categoryRepo->findCategoryById($id);
        $cat = new CategoryRepository($category);
        //dd($category);
        $brandId = $category->parent_id;
        $brand = false;
        if($brandId){
            $brand = $this->categoryRepo->findCategoryById($brandId);
            //dd($brand);
        }
        if($type == 'carmodel'){
            return view('admin.categories.show_carmodel', [
                'category'      => $category,
                'categories'    => $category->children,
                'products'      => $cat->findProducts(),
                'brand'         => $brand,
                'brandId'       => $brandId
            ]);
        }
        elseif($type == 'carsubmodel'){
            return view('admin.categories.show_carsubmodel', [
                'category'      => $category,
                'categories'    => $category->children,
                'products'      => $cat->findProducts(),
                'brand'         => $brand,
                'brandId'       => $brandId
            ]);
        }
        elseif($type == 'carparts'){
            $subModelId = $category->parent_id;
            $subModel = $this->categoryRepo->findCategoryById($subModelId);
            $brand = $this->categoryRepo->findCategoryById($subModel->parent_id);
            $car_parts = $this->categoryRepo->listSubCategories('id', explode(',',$category->available_part), 'name', 'asc');
            //dd($car_parts);
            return view('admin.categories.show_carparts', [
                'category'      => $category,
                'categories'    => $category->children,
                'products'      => $cat->findProducts(),
                'brand'         => $brand,
                'subModel'      => $subModel,
                'car_parts'     => $car_parts
            ]);
        }
        elseif($type == 'sub_part'){
            //dd($category);
            //dd($category->parent_id);
            //$subModelId = $_GET['pid'];
            $partId = $_GET['pid'];
            //$subModelId = $category->parent_id;
            //$part = $this->categoryRepo->findCategoryById($partId);
            //dd($part);
            //$subModelId = $part->parent_id;
            $subModel = $this->categoryRepo->findCategoryById($partId);
            $model = $this->categoryRepo->findCategoryById($subModel->parent_id);
            //dd($subModel);
            $brand = $this->categoryRepo->findCategoryById($model->parent_id);
            //$car_parts = $this->categoryRepo->listSubCategories('id', explode(',',$category->available_part), 'name', 'asc');
            return view('admin.categories.show_subpart', [
                'category'      => $category,
                'categories'    => $category->children,
                'products'      => $cat->findProducts(),
                'brand'         => $brand,
                'subModel'      => $subModel,
                'model'         => $model,
                'partId'        => $partId
                //'car_parts'     => $car_parts,
                //'part'          => $part
            ]);
        }
        elseif($type == 'car_subpart'){
            //dd($category);
            //dd($category->parent_id);
            //$subModelId = $_GET['pid'];
            //$partId = $_GET['pid'];
            $partId = $category->id;
            //$part = $this->categoryRepo->findCategoryById($partId);
            //dd($part);
            //$subModelId = $part->parent_id;
            $carParts = $this->categoryRepo->findCategoryById($partId);
            //$model = $this->categoryRepo->findCategoryById($subModel->parent_id);
            ////dd($subModel);
            //$brand = $this->categoryRepo->findCategoryById($model->parent_id);
            //$car_parts = $this->categoryRepo->listSubCategories('id', explode(',',$category->available_part), 'name', 'asc');
            return view('admin.categories.show_car_subpart', [
                'category'      => $category,
                'categories'    => $category->children,
                'products'      => $cat->findProducts(),
                //'brand'         => $brand,
                'carParts'      => $carParts,
                //'model'         => $model,
                'partId'        => $partId
                //'car_parts'     => $car_parts,
                //'part'          => $part
            ]);
        }
        elseif($type == 'piece'){
            $partId = $_GET['pid'];
            $subpart = $this->categoryRepo->findCategoryById($category->parent_id);
            $part = $this->categoryRepo->findCategoryById($partId);
            $subModel = $this->categoryRepo->findCategoryById($partId);
            $model = $this->categoryRepo->findCategoryById($subModel->parent_id);
            //dd($subModel);
            $brand = $this->categoryRepo->findCategoryById($model->parent_id);
            return view('admin.categories.show_piece', [
                'category'      => $category,
                'categories'    => $category->children,
                'products'      => $cat->findProducts(),
                'brand'         => $brand,
                'subModel'      => $subModel,
                'model'         => $model,
                'partId'        => $partId,
                'part'          => $part,
                'subpart'       => $subpart
            ]);
        }
        elseif($type == 'part_piece'){
            $partId = $_GET['pid'];
            /*$subpart = $this->categoryRepo->findCategoryById($category->parent_id);
            $part = $this->categoryRepo->findCategoryById($partId);
            $subModel = $this->categoryRepo->findCategoryById($partId);
            $model = $this->categoryRepo->findCategoryById($subModel->parent_id);
            //dd($subModel);
            $brand = $this->categoryRepo->findCategoryById($model->parent_id);*/
            $carPart = $this->categoryRepo->findCategoryById($partId);
            //dd($carPart);
            return view('admin.categories.show_part_piece', [
                'category'      => $category,
                'categories'    => $category->children,
                //'products'      => $cat->findProducts(),
                'partId'        => $partId,
                'carPart'       => $carPart
                /*'brand'         => $brand,
                'subModel'      => $subModel,
                'model'         => $model,
                'partId'        => $partId,
                'part'          => $part,
                'subpart'       => $subpart*/
            ]);
        }
        elseif($type == 'carmodel'){
            return view($view, [
                'category'      => $category,
                'categories'    => $category->children,
                'products'      => $cat->findProducts(),
                'brand'         => $brand
            ]);
        }
        /*
                $view = 'admin.categories.show_carmodel';
                break;
            case 'carsubmodel':
                $view = 'admin.categories.show_carsubmodel';
                break;
            case 'carparts':
                $view = 'admin.categories.show_carparts';
                break;
            case 'sub_part':
                $view = 'admin.categories.show_sub_part';
                break;
            case 'piece':
                $view = 'admin.categories.show_piece';
                break;
            default:
                $view = 'admin.categories.show';
                break;
        endswitch;
        return view($view, [
            'category'      => $category,
            'categories'    => $category->children,
            'products'      => $cat->findProducts(),
            'brand'         => $brand
        ]);*/
        /*return view('admin.categories.show', [
            'category' => $category,
            'categories' => $category->children,
            'products' => $cat->findProducts()
        ]);*/
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // echo $id;
        @$type = $_GET['type'];
        $isparts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');
        $brands = $this->categoryRepo->listIsparts(['type'=>0], 'name', 'asc');
        $view = 'admin.categories.edit';

        if($type == 'carmodel'){
            return view('admin.categories.edit_carmodel', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc', $id),
                'category' => $this->categoryRepo->findCategoryById($id),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands
            ]);
        }
        elseif($type == 'carsubmodel'){
            $bid = $_GET['bid'];
            $mid = $_GET['mid'];
            $carmodels = $this->categoryRepo->listIsparts(['parent_id'=>$bid], 'name', 'asc');
            //dd($carmodels);
            return view('admin.categories.edit_carsubmodel', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc', $id),
                'category' => $this->categoryRepo->findCategoryById($id),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands,
                'bid' => $bid,
                'mid' => $mid,
                'carmodels' => $carmodels
            ]);
        }
        elseif($type == 'carparts'){
            return view('admin.categories.edit_carparts', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc', $id),
                'category' => $this->categoryRepo->findCategoryById($id),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands
            ]);
        }
        elseif($type == 'sub_part'){
            $pid = $_GET['pid'];
            //$carParts = $this->categoryRepo->findCategoryById($pid);
            $carParts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');
            //dd($carParts);
            //dd($this->categoryRepo->findCategoryById($id));
            $cat = $this->categoryRepo->findCategoryById($id);

           $category_data  = DB::table('categories')->where('id', $cat->id)->first();

           

            return view('admin.categories.edit_sub_part', [
                //'categories' => $this->categoryRepo->listCategories('name', 'asc', $id),
                'category' => $this->categoryRepo->findCategoryById($id),
                'isparts' => $isparts,
                'type' => $type,
                //'brands' => $brands,
                'pid'   => $pid,
                'carParts' => $carParts,
                'cat_data'=> $category_data
            ]);
        }
        elseif($type == 'piece'){
            $spid   = $_GET['spid'];
            $pid    = $_GET['pid'];
            $carParts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');
            $subParts = $this->categoryRepo->listIsparts(['type'=>4], 'name', 'asc');
             $cat = $this->categoryRepo->findCategoryById($id);

           $category_data  = DB::table('categories')->where('id', $cat->id)->first();

            //dd($subParts);
            return view('admin.categories.edit_piece', [
                'categories'    => $this->categoryRepo->listCategories('name', 'asc'),
                'category' => $this->categoryRepo->findCategoryById($id),
                'isparts'       => $isparts,
                'type'          => $type,
                'brands'        => $brands,
                'spid'          => $spid,
                'pid'           => $pid,
                'carParts'      => $carParts,
                'subParts'      => $subParts,
                'cat_data'      => $category_data
            ]);
            /*return view('admin.categories.edit_piece', [
                'categories' => $this->categoryRepo->listCategories('name', 'asc', $id),
                'category' => $this->categoryRepo->findCategoryById($id),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands
            ]);*/
        }
        else{
            $cat = $this->categoryRepo->findCategoryById($id);
            $category_data  = DB::table('categories')->where('id', $cat->id)->first();
            
            
            return view($view, [
                'categories' => $this->categoryRepo->listCategories('name', 'asc', $id),
                'category' => $this->categoryRepo->findCategoryById($id),
                'isparts' => $isparts,
                'type' => $type,
                'brands' => $brands,
                'category_data'=> $category_data
            ]); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateCategoryRequest $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, $id)
    {

          
        //dd($request->input());
        $category = $this->categoryRepo->findCategoryById($id);
        $type = $request->input('type');
        $update = new CategoryRepository($category);
        $update->updateCategory($request->except('_token', '_method'));

        $request->session()->flash('message', 'Update successful');
        if($type == 'carsubmodel'){
            $bid = $request->input('bid');
            $mid = $request->input('mid');
            return redirect('admin/categories/'.$id.'/edit?type='.$type.'&bid='.$bid.'&mid='.$mid);
        }
        elseif($type == 'sub_part'){
            $pid = $request->input('pid');
            return redirect('admin/categories/'.$id.'/edit?type='.$type.'&pid='.$pid);
        }
        elseif($type == 'piece'){
            $pid = $request->input('pid');
            $spid = $request->input('spid');
            return redirect('admin/categories/'.$id.'/edit?type='.$type.'&spid='.$spid.'&pid='.$pid);
        }
        elseif($type == 'carparts'){
           /* $src = '../storage/app/public/categories';
            $dst = 'storage/categories';
            $files = scandir($src);
            //dd($files);
            foreach($files as $file){
                if ($file != "." && $file != ".."){
                    copy("$src/$file", "$dst/$file");
                }
            }*/
            return redirect('admin/categories/'.$id.'/edit?type='.$type);
        }
        else
            return redirect('admin/categories/'.$id.'/edit?type='.$type);

        //return redirect()->route('admin.categories.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id, Request $request)
    {
        
        $type = $request->input('type');
        if($type == 'carpartsUnassign'){
            //dd($request->input());
            $smid = $request->input('smid');
            //$available_part = $request->input('available_part');
            $category = $this->categoryRepo->findCategoryById($smid);
            $available_part = explode(',', $category->available_part);
            if (($key = array_search($id, $available_part)) !== false) {
                unset($available_part[$key]);
            }
            //dd($available_part);
            Category::where('id', '=', $smid)->update(array('available_part' => implode(',', $available_part)));
            $request->session()->flash('message', 'Update successful');
            return redirect('admin/categories/'.$smid.'?type=carparts');
        }
        else{
            $category = $this->categoryRepo->findCategoryById($id);
            $category->products()->sync([]);
            $category->delete();
            $type = $request->has('type')?$request->input('type'):'';
            request()->session()->flash('message', 'Delete successful');
            if($type == 'carmodel')
            {
                $brandId = $request->input('brandId');
                return redirect('admin/categories/'.$brandId.'?type=carmodel');
            }
            elseif($type == 'carsubmodel')
            {
                $mid = $request->input('mid');
                return redirect('admin/categories/'.$mid.'?type=carsubmodel');
            }
            elseif($type == 'carparts')
            {
                return redirect('admin/partgroups/');
            }
            elseif($type == 'car_subpart')
            {
                $pid = $request->input('pid');
                return redirect('admin/categories/'.$pid.'?type=car_subpart');
            }
            elseif($type == 'part_piece')
            {
                $pid = $request->input('pid');
                $spid = $request->input('spid');
                return redirect('admin/categories/'.$spid.'?type=part_piece&pid='.$pid);
            }
            else
                return redirect()->route('admin.categories.index');
        }
        
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function removeImage(Request $request)
    {
        $cat_id = $_REQUEST['category'];
        $cover = '';

        DB::update('update categories set cover = ? where id = ?',[$cover,$cat_id]);


        $this->categoryRepo->deleteFile($request->only('category'));



        request()->session()->flash('message', 'Image delete successful');
        return redirect('/admin/categories/'.$cat_id.'/edit?type=carparts');

       // return redirect()->route('admin.categories.edit/', $request->input('category'));
    }
    public function assignCarParts(Request $request){
        $type = $request->input('type');
        $smid = $request->input('smid');
        $carParts = $this->categoryRepo->listIsparts(['is_part'=>1], 'name', 'asc');
        //dd($carParts);
        //$subModelId = $category->parent_id;
        $subModel = $this->categoryRepo->findCategoryById($smid);
        $brand = $this->categoryRepo->findCategoryById($subModel->parent_id);
        //dd($this->categoryRepo->findCategoryById($smid));
        return view('admin.categories.assign_parts', [
            'categories'    => $this->categoryRepo->listCategories('name', 'asc'),
            'category'      => $this->categoryRepo->findCategoryById($smid),
            'type'          => $type,
            'smid'          => $smid,
            'carParts'      => $carParts,
            'subModel'      => $subModel,
            'brand'         => $brand
        ]);
    }
    public function saveParts(Request $request){
        //dd($request->input());
        $type = $request->input('type');
        $smid = $request->input('smid');
        $available_part = $request->input('available_part');
        $category = $this->categoryRepo->findCategoryById($smid);
        //dd($category);
        if(empty($available_part))
            Category::where('id', '=', $smid)->update(array('available_part' => ''));
        else
            Category::where('id', '=', $smid)->update(array('available_part' => implode(',', $available_part)));
        /* $update = new CategoryRepository($category);
        $update->updateCategory($request->except('_token', '_method', 'smid'));*/
        $request->session()->flash('message', 'Update successful');
        return redirect('admin/assignCarParts?type=carparts&smid='.$smid);
    }
    public function unassignParts(Request $request){
        dd($request->input());
    }
}