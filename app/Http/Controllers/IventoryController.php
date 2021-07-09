<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
class IventoryController extends Controller
{
    public function products()
    {
        $products=Product::getAllProduct();
        return view('backend.inventories.index', compact('products'));
    }
    public function ordenes()
    {
        $orders=Order::orderBy('id','DESC')->paginate(10);
        return view('backend.inventories.ordenes', compact('orders'));
    }
}
