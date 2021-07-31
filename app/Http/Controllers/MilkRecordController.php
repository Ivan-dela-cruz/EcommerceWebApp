<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\MilkRecord;
use Illuminate\Http\Request;

class MilkRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes= Income::all();
        return view('backend.milk-record.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $income = Income::find($id);
        return view('backend.milk-record.show', compact('income'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $milk = MilkRecord::find($id);
        return view('backend.milk-record.edit', compact('milk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'total_liters'=>'required|numeric',
            'price'=>'required|numeric',
            'sub_total'=>'required|numeric',
        ]);
        $milk = MilkRecord::find($id);
        if(is_null($milk)){
            request()->session()->flash('error','No se econtró un registro para  actualizar!');
            return redirect()->route('milk-record.show',$milk->income_id);
        }
        $milk->total_liters = $request->total_liters;
        $milk->price = $request->price;
        $milk->sub_total =$request->total_liters*$request->price;
        $status=$milk->save();
        //UPDATE INCOME
        $total_lit = MilkRecord::where('income_id',$milk->income_id)->sum('total_liters');
        $total_sub = MilkRecord::where('income_id',$milk->income_id)->sum('sub_total');
        $income = Income::find($milk->income_id);
        $income->total_liters = $total_lit;
        $income->total_price = $total_sub;
        $income->save();

        if($status){
            request()->session()->flash('success','Registro actualizado con exíto');
        }
        else{
            request()->session()->flash('error','Error al actualizar el registro!');
        }
        return redirect()->route('milk-record.show',$milk->income_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $milk = MilkRecord::findOrFail($id);
        $income = $milk->income_id;
        $status = $milk->delete();
        //UPDATE INCOME
        $total_lit = MilkRecord::where('income_id',$milk->income_id)->sum('total_liters');
        $total_sub = MilkRecord::where('income_id',$milk->income_id)->sum('sub_total');
        $income = Income::find($milk->income_id);
        $income->total_liters = $total_lit;
        $income->total_price = $total_sub;
        $income->save();
        
        if($status){
            request()->session()->flash('success','Registro eliminado correctamente');
        }
        else{
            request()->session()->flash('error','Error al eliminar el registro');
        }
        return redirect()->route('milk-record.show',$income);
    }
}
