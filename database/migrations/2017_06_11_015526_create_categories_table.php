<?php

use Kalnoy\Nestedset\NestedSet;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('cover')->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            NestedSet::columns($table);
            $table->integer('is_part')->default(0);
            $table->string('available_part', 400)->nullable();
            $table->boolean('show_on_product')->default(0);
            $table->string('type')->default(0);
            $table->string('total_views')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('categories', function (Blueprint $table) {

            $sm = Schema::getConnection()->getDoctrineSchemaManager();

            $doctrineTable = $sm->listTableDetails('categories');

            if ($doctrineTable->hasIndex('categories__lft__rgt_parent_id_index')) 
            {
                $table->dropIndex('categories__lft__rgt_parent_id_index');
            }

        });

        Schema::dropIfExists('categories');
    }
}
