<?php

namespace App\Http\Controllers\Api;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function index(Request $request)
    {
        $sliders = Banner::where('status','active')->orderBy('title','ASC')->get(['id','title','description','photo']);

        return response()->json([
            'success' => true,
            'sliders' => $sliders
        ], 200);
    }
}
