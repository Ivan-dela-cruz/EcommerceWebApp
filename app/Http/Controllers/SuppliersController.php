<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
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

    public function pdf(){
        $suppliers = Supplier::orderBy('name','ASC')->get();

        $pdf = PDF::loadView('pdf.pdf_suppliers', compact('suppliers'));
        $nombrePdf = 'reporte-proveedores' . time() . '.pdf';

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, $nombrePdf);
    }

}
