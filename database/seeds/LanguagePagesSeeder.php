<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagePagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $language_pages = array(
            array('id' => '1', 'title' => 'Header Menu', 'is_active' => '1', 'created_at' => '2020-09-08 06:40:27', 'updated_at' => '2020-09-08 06:40:27'),
            array('id' => '2', 'title' => 'Homepage', 'is_active' => '1', 'created_at' => '2020-09-08 08:26:24', 'updated_at' => '2020-09-08 08:26:24'),
            array('id' => '3', 'title' => 'Login', 'is_active' => '1', 'created_at' => '2020-09-08 08:42:31', 'updated_at' => '2020-09-08 08:42:31'),
            array('id' => '4', 'title' => 'Footer', 'is_active' => '1', 'created_at' => '2020-09-08 08:50:59', 'updated_at' => '2020-09-08 08:50:59'),
            array('id' => '5', 'title' => 'Register', 'is_active' => '1', 'created_at' => '2020-09-08 08:56:23', 'updated_at' => '2020-09-08 08:56:23'),
            array('id' => '6', 'title' => 'Forgot Password', 'is_active' => '1', 'created_at' => '2020-09-08 09:08:57', 'updated_at' => '2020-09-08 09:08:57'),
            array('id' => '7', 'title' => 'My Account', 'is_active' => '1', 'created_at' => '2020-09-08 09:38:48', 'updated_at' => '2020-09-08 09:38:48'),
            array('id' => '8', 'title' => 'Address Page', 'is_active' => '1', 'created_at' => '2020-09-08 10:42:39', 'updated_at' => '2020-09-08 10:42:39'),
            array('id' => '9', 'title' => 'Category Page', 'is_active' => '1', 'created_at' => '2020-09-08 11:19:39', 'updated_at' => '2020-09-08 11:19:39'),
            array('id' => '10', 'title' => 'Products Page', 'is_active' => '1', 'created_at' => '2020-09-09 10:30:18', 'updated_at' => '2020-09-09 10:30:18'),
            array('id' => '11', 'title' => 'Product Details Page', 'is_active' => '1', 'created_at' => '2020-09-09 10:30:31', 'updated_at' => '2020-09-09 10:30:31'),
            array('id' => '12', 'title' => 'Cart Page', 'is_active' => '1', 'created_at' => '2020-09-09 11:50:11', 'updated_at' => '2020-09-09 11:50:11'),
            array('id' => '13', 'title' => 'Wishlist Page', 'is_active' => '1', 'created_at' => '2020-09-09 11:50:42', 'updated_at' => '2020-09-09 11:50:42'),
            array('id' => '14', 'title' => 'Checkout Page', 'is_active' => '1', 'created_at' => '2020-09-09 16:21:29', 'updated_at' => '2020-09-09 16:21:29'),
            array('id' => '15', 'title' => 'Common', 'is_active' => '1', 'created_at' => '2020-09-10 05:23:03', 'updated_at' => '2020-09-10 05:23:03')
        );

        foreach ($language_pages as $key => $language_page) {
            DB::table('language_pages')->insert($language_page);
        }
    }
}
