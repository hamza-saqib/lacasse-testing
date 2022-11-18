<?php
use App\Shop\Orders\Order;
use Illuminate\Support\Facades\Validator;
//use DB;
if (!function_exists("helper_test")) {
    function helper_test()
    {
        echo "it is working";
    }
}

if (!function_exists("populate_breadcumb")) {
    /**
     * popular data to layouts.admin.app when send from controller
     *
     *<h1> controller example </h1>
     * <pre>
     *  $data = [
     * ["name" => "Dashboard1", "url" => route("admin.dashboard")],
     * ["name" => "Products1", "url" => request()->fullUrl()]
     * ];
     *
     * populate_breadcumb($data)
     * </pre>
     *
     * @param $data
     * @return void
     */
    function populate_breadcumb($data)
    {
        $validated = validate_breadcumb($data);
        if ($validated["valid"] === true) {
            view()->composer([
                "layouts.admin.app"
            ], function ($view) use ($data) {
                $view->with(
                    [
                        "breadcumbs" => $data
                    ]
                );
            });
        }

    }

}

if (!function_exists('validate_breadcumb')) {

    /**
     * validate breadcumb data
     * @param $data
     * @return array
     */
    function validate_breadcumb($data)
    {
        $validated = false;
        $errors = [];
        foreach ($data as $key => $item) {
            $messages = [
                'required' => "The :attribute field is required at index: $key.",
                "url" => "The :attribute format is invalid at index: $key"

            ];
            $validator = Validator::make($item, [
                'name' => 'required',
                'url' => "required|url",
//                "icon" => ""
            ], $messages);
            if ($validator->fails()) {
                $validated = false;
                $errors[] = $validator->errors();

            } else {
                $validated = true;
            }
        }
        return ["errors" => $errors, "valid" => $validated];
    }
}

if (!function_exists('getUserOrders')) {

    /**
     * validate breadcumb data
     * @param $data
     * @return array
     */
    function getUserOrders($user_id)
    {
        $orders = Order::where('customer_id', $user_id)->get();
        return $orders = $orders->count();
        //return ["errors" => $errors, "valid" => $validated];
    }
}

function countMakeProducts($make, $partCategoryId){
    //echo $make;
    //echo '<br/>'.$partCategoryId;
    $results = DB::select( DB::raw("SELECT count(*) as totalProducts FROM category_product WHERE category_id = '$partCategoryId'") );
    //dd($results);
    return $results[0]->totalProducts;
}
function countMakeProducts2($b, $m, $s, $p, $sp, $pi){
    //echo $make;
    //echo '<br/>'.$partCategoryId;
    $query = "SELECT count(*) as totalProducts FROM products WHERE status = 1 AND brand_id = '$b' AND car_model = '$m' AND car_submodel = '$s' and is_part = '$p' AND sub_part = '$sp' AND FIND_IN_SET('$pi', pieces) ";
    $results = DB::select( DB::raw($query) );
    //dd($results);
    return $results[0]->totalProducts;
}


function available_parts($catID){
    $results = DB::select( DB::raw("SELECT available_part as parts FROM categories WHERE id = '$catID'") );
    //dd($results);
    if($results)
        return $results[0]->parts;
    else
        return '';
}
function getTotalProducts($b, $m, $s, $p){
    $query = "SELECT count(*) as totalProducts FROM products WHERE brand_id = '$b' and car_model = '$m' and car_submodel = '$s' and is_part = '$p' and status = 1";
    $results = DB::select( DB::raw($query) );
    //dd($results);
    return $results[0]->totalProducts;
}