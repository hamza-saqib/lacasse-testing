<?php

namespace Tests;

use App\Shop\Addresses\Address;
use App\Shop\Categories\Category;
use App\Shop\Countries\Country;
use App\Shop\Couriers\Courier;
use App\Shop\Couriers\Repositories\CourierRepository;
use App\Shop\Employees\Employee;
use App\Shop\Customers\Customer;
use App\Shop\Employees\Repositories\EmployeeRepository;
use App\Shop\OrderStatuses\OrderStatus;
use App\Shop\OrderStatuses\Repositories\OrderStatusRepository;
use App\Shop\Permissions\Permission;
use App\Shop\Products\Product;
use App\Shop\Roles\Repositories\RoleRepository;
use App\Shop\Roles\Role;
use Gloudemans\Shoppingcart\Cart;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    

    /**
     * Set up the test
     */
    public function setUp()
    {
        
    }

    public function tearDown()
    {
        
    }
}
