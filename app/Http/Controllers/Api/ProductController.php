<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function products(Request $request)
    {

        $products = Product::where('status','active')->orderBy('title','ASC')->get(['id','cat_id','condition','title','price','stock','description','photo']);

        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }

    public function productsByCategory($id)
    {


        $products = Product::where('status','active')
        ->where('cat_id',$id)
        ->orderBy('title','ASC')->get(['id','cat_id','condition','title','price','stock','description','photo']);

        return response()->json([
            'success' => true,
            'products' => $products
        ], 200);
    }

}
