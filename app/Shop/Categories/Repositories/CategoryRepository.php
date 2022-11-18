<?php

namespace App\Shop\Categories\Repositories;

use Jsdecena\Baserepo\BaseRepository;
use App\Shop\Categories\Category;
use App\Shop\Categories\Exceptions\CategoryInvalidArgumentException;
use App\Shop\Categories\Exceptions\CategoryNotFoundException;
use App\Shop\Categories\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Shop\Products\Product;
use App\Shop\Products\Transformations\ProductTransformable;
use App\Shop\Tools\UploadableTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use DB;
class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    use UploadableTrait, ProductTransformable;

    /**
     * CategoryRepository constructor.
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        parent::__construct($category);
        $this->model = $category;
    }

    /**
     * List all the categories
     *
     * @param string $order
     * @param string $sort
     * @param array $except
     * @return \Illuminate\Support\Collection
     */
    public function listCategories(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->orderBy($order, $sort)->get()->except($except);
    }

    public function listIsparts($wh =[], string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->where($wh)->orderBy($order, $sort)->get()->except($except);
    }
    public function listProductCategories($wh =[], string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->where($wh)->orderBy($order, $sort)->get()->except($except);
    }
    public function listSubCategories($col, $wh, string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->whereIn($col, $wh)->orderBy($order, $sort)->get()->except($except);
    }

    public function mostSearchedParts($b, $m, $s, $p){
        /*echo $partGroupId;
        die;*/
        $query = "Select c.*, ms.counts from categories c join most_searched ms on c.id = ms.pi where ms.b = $b and ms.m = $m and ms.s = $s and ms.p = $p order by ms.counts desc limit 12";
        
        //$results = \DB::select($query);
        return \DB::select($query);
        //dd($results);
    }
    public function updateView($b, $m, $s, $p, $pi){
        $query = "Select * from most_searched where b = $b AND m = $m and s=$s and p=$p and pi =$pi";
        $result =  \DB::select($query);
        if(empty($result)){
            \DB::table('most_searched')->insert([
                'b' => $b,
                'm' => $m,
                's' => $s,
                'p' => $p,
                'pi' => $pi,
                'counts' => 1
            ]);
        }
        else{
            \DB::update('update most_searched set counts = counts + 1 where b = ? and m = ? and s = ? and p = ? and pi = ?', [$b, $m, $s, $p, $pi]);
        }
    }
    /**
     * List all root categories
     * 
     * @param  string $order 
     * @param  string $sort  
     * @param  array  $except
     * @return \Illuminate\Support\Collection  
     */
    public function rootCategories(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->whereIsRoot()
            ->where('is_part', 0)
            ->orderBy($order, $sort)
            ->get()
            ->except($except);
    }

    /**
     * List all root categories
     * 
     * @param  string $order 
     * @param  string $sort  
     * @param  array  $except
     * @return \Illuminate\Support\Collection  
     */
    public function partGroupCategories(string $order = 'id', string $sort = 'desc', $except = []) : Collection
    {
        return $this->model->whereIsRoot()
            ->where('is_part', 1)
            ->orderBy($order, $sort)
            ->get()
            ->except($except);
    }
    /**
     * Create the category
     *
     * @param array $params
     *
     * @return Category
     * @throws CategoryInvalidArgumentException
     * @throws CategoryNotFoundException
     */
    public function createCategory(array $params) : Category
    {
        try {

            $collection = collect($params);
            $collection['available_part']='';
            if(!empty( $collection['available_part'])){
                $collection['available_part'] = implode(',', $collection['available_part']);
            }
            //dd($collection);
            if (isset($params['name'])) {
                $slug = str_slug($params['name']);
            }
            switch($params['type']):
                case 'brand':
                    $collection['type'] = 0;
                    break;
                case 'carmodel':
                    $collection['type'] = 1;
                    break;
                case 'carsubmodel':
                    $collection['type'] = 2;
                    break;
                case 'carparts':
                    $collection['type'] = 3;
                    break;
                case 'sub_part':
                    $collection['type'] = 4;
                    break;
                case 'piece':
                    $collection['type'] = 5;
                    break;
            endswitch;
            $cover = '';
            if ( isset($params['cover']) && ($params['cover'] instanceof UploadedFile) && !empty( $params['cover'] ) ) {
                $cover = $this->uploadOne($params['cover'], 'categories');
            }

            $merge = $collection->merge(compact('slug', 'cover'));

            $category = new Category($merge->all());

            if (isset($params['parent'])) {
                $parent = $this->findCategoryById($params['parent']);
                $category->parent()->associate($parent);
            }

            $category->save();
            return $category;
        } catch (QueryException $e) {
            throw new CategoryInvalidArgumentException($e->getMessage());
        }
    }

    /**
     * Update the category
     *
     * @param array $params
     *
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function updateCategory(array $params) : Category
    {


        $category = $this->findCategoryById($this->model->id);
        $collection = collect($params)->except('_token');
        //dd($collection);
        switch($params['type']):
            case 'brand':
                $collection['type'] = 0;
                break;
            case 'carmodel':
                $collection['type'] = 1;
                break;
            case 'carsubmodel':
                $collection['type'] = 2;
                break;
            case 'carparts':
                    $collection['type'] = 3;
                    break;
            case 'sub_part':
                    $collection['type'] = 4;
                    break;
            case 'piece':
                    $collection['type'] = 5;
                    break;
            default: 
            $collection['type'] = 5;

        endswitch;
        if(isset($collection['available_part']))
            $collection['available_part'] = implode(',', $collection['available_part']);
        else
            $collection['available_part'] = NULL;
        $slug = str_slug($collection->get('name'));
        //$cover = '';



        if($params['type'] == '' || isset($params['type'])){

            $params['type'] = 0;

        }


        if (isset($params['cover'])  && ($params['cover'] instanceof UploadedFile)) {
            $cover = $this->uploadOne($params['cover'], 'categories');
        } 
        else{
            if(isset($params['old_cover'])){
                $cover = $params['old_cover'];
            } else {
                $cover = null;
            }
        }

        $merge = $collection->merge(compact('slug', 'cover'));

        // set parent attribute default value if not set
        $params['parent'] = $params['parent'] ?? 0;

        // If parent category is not set on update
        // just make current category as root
        // else we need to find the parent
        // and associate it as child
        if ( (int)$params['parent'] == 0) {
            $category->saveAsRoot();
        } else {
            $parent = $this->findCategoryById($params['parent']);
            $category->parent()->associate($parent);
        }

        $category->update($merge->all());
        
        return $category;
    }
    public function getProducts($b, $m, $s, $p, $sp, $pi, $status=1){
        $query = "Select * from products WHERE status = ".$status." and brand_id = '$b' AND car_model = '$m' AND car_submodel = '$s' and is_part = '$p' AND sub_part = '$sp' AND FIND_IN_SET('$pi', pieces)";
        return $results = DB::select( DB::raw($query) );
    }
    
    /**
     * @param int $id
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryById(int $id) : Category
    {
        try {
            return $this->findOneOrFail($id);
        } catch (ModelNotFoundException $e) {
            abort(404);
            //throw new CategoryNotFoundException($e->getMessage());
        }
    }

    /**
     * Delete a category
     *
     * @return bool
     * @throws \Exception
     */
    public function deleteCategory() : bool
    {
        return $this->model->delete();
    }

    /**
     * Associate a product in a category
     *
     * @param Product $product
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function associateProduct(Product $product)
    {
        return $this->model->products()->save($product);
    }

    /**
     * Return all the products associated with the category
     *
     * @return mixed
     */
    public function findProducts() : Collection
    {
        return $this->model->products;
    }

    /**
     * @param array $params
     */
    public function syncProducts(array $params)
    {
        $this->model->products()->sync($params);
    }


    /**
     * Detach the association of the product
     *
     */
    public function detachProducts()
    {
        $this->model->products()->detach();
    }

    /**
     * @param $file
     * @param null $disk
     * @return bool
     */
    public function deleteFile(array $file, $disk = null) : bool
    {
        return $this->update(['cover' => null], $file['category']);
    }

    /**
     * Return the category by using the slug as the parameter
     *
     * @param array $slug
     *
     * @return Category
     * @throws CategoryNotFoundException
     */
    public function findCategoryBySlug(array $slug) : Category
    {
        try {
            return $this->findOneByOrFail($slug);
        } catch (ModelNotFoundException $e) {
            throw new CategoryNotFoundException($e);
        }
    }

    /**
     * @return mixed
     */
    public function findParentCategory()
    {
        return $this->model->parent;
    }

    /**
     * @return mixed
     */
    public function findChildren()
    {
        return $this->model->children;
    }
    /**
     * @return mixed
     */
    public function getsubcategory($data)
    {
        return $this->model->where($data)->orderBy('name', 'ASC')->get();
    }
}
