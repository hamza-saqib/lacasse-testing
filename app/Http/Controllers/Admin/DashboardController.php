<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Shop\Customers\Customer;
use App\Shop\Orders\Order;
use App\Shop\Products\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $breadcumb = [
            ["name" => "Dashboard", "url" => route("admin.dashboard"), "icon" => "fa fa-dashboard"],
            ["name" => "Home", "url" => route("admin.dashboard"), "icon" => "fa fa-home"],

        ];
        populate_breadcumb($breadcumb);
        $noOfNewOrders = Order::where('order_status_id', 6)->count();
        $noOfPendingOrders = Order::where('order_status_id', 2)->count();
        $noOfProducts = Product::count();
        $noOfCustomers = Customer::count();
        return view('admin.dashboard', compact('noOfNewOrders', 'noOfPendingOrders', 'noOfProducts', 'noOfCustomers'));
    }
}
