<?php

namespace App\Http\Controllers\Front;

use App\Shop\Categories\Repositories\CategoryRepository;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Http\Controllers\Controller;

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
     * Find the category via the slug
     *
     * @param string $slug
     * @return \App\Shop\Categories\Category
     */
    public function getCategory(string $slug)
    {
        $category = $this->categoryRepo->findCategoryBySlug(['slug' => $slug]);

        $repo = new CategoryRepository($category);

        $products = $repo->findProducts()->where('status', 1)->all();

        return view('front.categories.category', [
            'category' => $category,
            'products' => $repo->paginateArrayResults($products, 20)
        ]);
    }

    public function tabGetCategory()
    {
        $miancategory = $this->categoryRepo->findBy(['parent_id' => NULL]);
        return view('front.categories.subcategory', [
            'cateslug'=>$slug,
            'miancategory' => $miancategory,
            //'products' => $repo->paginateArrayResults($products, 20)
        ]);
    }

    public function getpartgroups(string $slug ='')
    {
        if($slug){
            $cate = $this->categoryRepo->findOneByOrFail(['slug' => $slug]);
            //dd($cate);
            $submake = $this->categoryRepo->findOneByOrFail(['id' => $cate->parent_id]);
            $make = $this->categoryRepo->findOneByOrFail(['id' => $submake->parent_id]);
            //dd($make);
            $makeName = $make->name;
            $makeSlug = $make->slug;
            $partsGroup = $this->categoryRepo->findBy([ 'is_part' => 1 ]);
        }else{
            $subcategory = $this->categoryRepo->findBy([ 'parent_id' =>NULL]);
            $makeName = '';
            $makeSlug = '';
        }
        $b = isset($_GET['b'])?$_GET['b']:0;
        $m = isset($_GET['m'])?$_GET['m']:0;
        $s = isset($_GET['s'])?$_GET['s']:0;
        //echo "<pre>";print_r($partsGroup);die;
        return view('front.categories.partgroups', [
            'category' => $cate,
            'cateslug'=>$slug,
            'subcategory' => $partsGroup,
            'make' => $makeName,
            'makeSlug'=> $makeSlug,
            'model' => $slug,
            'b' => $b,
            'm' => $m,
            's' => $s
        ]);

    }
    public function getsubcategory(string $slug ='')
    {   
        $bid = 0;
        if($slug){
            $cate = $this->categoryRepo->findOneByOrFail(['slug' => $slug]);
            //$subcategory = $this->categoryRepo->findBy([ 'parent_id' => $cate->id ]);
            $bid = $cate->id;
            $subcategory =$this->categoryRepo->getsubcategory([ 'parent_id' => $cate->id ]);
            /*if($subcategory->count())
                $models = $this->categoryRepo->findBy([ 'parent_id' => $subcategory[0]->id ]);
            else 
                $models = [];*/
            $models = [];
            if($subcategory->count()){
                foreach($subcategory as $sc)
                    $models[$sc->id] = $this->categoryRepo->findBy([ 'parent_id' => $sc->id ]);
            }
            //dd($models);
        }else{
            //$subcategory = $this->categoryRepo->getsubcategory([ 'parent_id' =>NULL]);
            $subcategory = $this->categoryRepo->rootCategories('name', 'asc');
            $models = [];
        }
        //echo "<pre>";print_r($subcategory);die;
        return view('front.categories.subcategory', [
            'cateslug'=>$slug,
            'subcategory' => $subcategory,
            'make' => $slug,
            'models' => $models,
            'bid' => $bid
        ]);
    }

    public function showallpartgroups(string $ispart, string $make, string $model)
    {
        $partgroup = $this->categoryRepo->findCategoryById($ispart);
        $partgroupname = $partgroup->name;
        $partgroups = $this->categoryRepo->getsubcategory([ 'parent_id' =>$ispart ]);
        $mostSearchedParts = [];
        $b = isset($_GET['b'])?$_GET['b']:0;
        $m = isset($_GET['m'])?$_GET['m']:0;
        $s = isset($_GET['s'])?$_GET['s']:0;
        $p = isset($_GET['p'])?$_GET['p']:0;
        if($partgroups->count() > 0){
            $mostSearchedParts = $this->categoryRepo->mostSearchedParts($b, $m, $s, $p);
        }
        //dd($partgroups);
        //die;
        $partgroupsSubCats = [];
        foreach($partgroups as $pg){
            $catsArr = [];
            $subCats = $this->categoryRepo->getsubcategory([ 'parent_id' =>$pg->id ]);
            if($subCats->count()){
                foreach($subCats as $sc){
                    $catsArr[$sc->id] = $sc->name;
                }
            }
            $partgroupsSubCats[$pg->id] = $catsArr;
        }
        //dd($mostSearchedParts);
        
        return view('front.categories.showallpartgroups', compact(
            'mostSearchedParts',
            'partgroup',
            'partgroups',
            'make',
            'model',
            'partgroupname',
            'ispart',
            'partgroupsSubCats',
            'b',
            'm',
            's',
            'p'
        ));
    }

    public function showallproducts(string $ispart, string $cateid, string $make, string $model)
    {
        $b = isset($_GET['b'])?$_GET['b']:0;
        $m = isset($_GET['m'])?$_GET['m']:0;
        $s = isset($_GET['s'])?$_GET['s']:0;
        $p = isset($_GET['p'])?$_GET['p']:0;
        $pi = $cateid;
        $this->categoryRepo->updateView($b, $m, $s, $p, $pi);
        $cate = $this->categoryRepo->findCategoryById($cateid);
        //dd($cate);
        /*$cate->total_views = $cate->total_views + 1;
        $cate->save();*/
        //$products = $cate->products;
        $products = $this->categoryRepo->getProducts($b, $m, $s, $p, $cate->parent_id, $pi);
        //dd($products);
        $partgroup = $this->categoryRepo->findCategoryById($ispart);
        $partgroupname = $partgroup->name;
        $parts= $this->categoryRepo->findCategoryById($cateid);
        $partsname = $parts->name;
        //echo"<pre>";print_r($partsname);die;
        return view('front.products.products-page', compact(
            'products',
            'make',
            'model',
            'partgroupname',
            'partsname',
            'ispart',
            'b',
            'm',
            's',
            'p'
        ));
    }
}
