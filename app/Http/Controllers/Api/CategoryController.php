<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status','active')->orderBy('title','ASC')->get(['id','title','summary']);

        return response()->json([
            'success' => true,
            'categorias' => $categories
        ], 200);
    }
}
