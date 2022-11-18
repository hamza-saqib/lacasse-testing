<?php



use Illuminate\Support\Facades\Schema;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Database\Migrations\Migration;



class AddShopIdInProductsTable extends Migration

{

    /**

     * Run the migrations.

     *

     * @return void

     */

    public function up()

    {

        Schema::table('products', function (Blueprint $table) {

            $table->unsignedInteger('shop_id')->nullable()->after('id');
            $table->integer('car_model')->nullable()->after('brand_id');
            $table->integer('car_submodel')->nullable()->after('car_model');
            $table->integer('is_part')->nullable()->after('car_submodel');
            $table->integer('sub_part')->nullable()->after('is_part');
            $table->string('pieces', 1000)->after('sub_part')->nullable();
            $table->string('item_number')->after('pieces')->nullable();
            
        });

    }



    /**

     * Reverse the migrations.

     *

     * @return void

     */

    public function down()

    {

        Schema::table('products', function (Blueprint $table) {

            $table->dropColumn(['shop_id']);

        });

    }

}

