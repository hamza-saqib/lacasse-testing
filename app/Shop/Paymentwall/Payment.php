<?php
namespace App\Shop\Paymentwall;
 
// use Illuminate\Http\Request;
// use Illuminate\Validation\ValidationException;
// use Illuminate\Support\Facades\Hash;
// use App\User;
require_once('../paymentwall/lib/paymentwall.php');
class Payment
{
    public static function  save_log($token, $ket_log, $post_log)
    {
      try{
        $getuser = User::where('api_token', $token)->first();
        if(!$getuser){
          $id = 0;
        }else{
          $id =   $getuser->id_user;
        }
        try {
            $data =  t_log::create([
              'id_user'=> $id,
              'ket_log'=> $ket_log,
              'post_log'=> $post_log,
            ]);
        } catch (\Illuminate\Database\QueryException $ex) {
          //dd ($ex->getMessage());
        }
      } catch(\Illuminate\Database\QueryException $ex){
          //dd ($ex->getMessage());
      }
 
    }
}