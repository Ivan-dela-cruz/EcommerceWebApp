<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    public function index()
    {
//        $users=User::orderBy('id','ASC')->paginate(10);
        return view('backend.suppliers.index');
    }

    public function create(){
        $users=User::orderBy('id','ASC')->paginate(10);
        return view('backend.suppliers.create')->with('users',$users);
    }

    public function edit($id){
        return view('backend.suppliers.edit',compact('id'));
    }

}
