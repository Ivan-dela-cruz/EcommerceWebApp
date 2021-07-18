<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class ProductController extends Controller
{
    public function products(Request $request)
    {

        $products = Product::where('status','active')->orderBy('title','ASC')->get();

        $list = new Collection();

        foreach ($products as $data){
            $item = [
                'id' => $data->id,
                'cat_id' => $data->cat_id,
                'condition' => $data->condition,
                'title' => $data->title,
                'price' => number_format($data->price, "2",".",""),
                'stock' => $data->stock,
                'description' => $data->description,
                'photo' => $data->photo,
            ];
            $list->push($item);
        }
        return response()->json([
            'success' => true,
            'products' => $list,
        ], 200);
    }

    public function productsByCategory($id)
    {


        $products = Product::where('status','active')
        ->where('cat_id',$id)
        ->orderBy('title','ASC')->get();

        $list = new Collection();

        foreach ($products as $data){
            $item = [
                'id' => $data->id,
                'cat_id' => $data->cat_id,
                'condition' => $data->condition,
                'title' => $data->title,
                'price' => number_format($data->price, "2",".",""),
                'stock' => $data->stock,
                'description' => $data->description,
                'photo' => $data->photo,
            ];
            $list->push($item);
        }

        return response()->json([
            'success' => true,
            'products' => $list
        ], 200);
    }

}
