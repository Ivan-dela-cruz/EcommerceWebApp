<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\MilkRecord;
use App\Models\Supplier;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class MilkRecordController extends Controller
{
    public function suppliersByMilkiRecords(Request $request)
    {
        $time_record = $request->query('time');
        //fechas
        $now = Carbon::now("America/Guayaquil");
        $date = $now->format('Y-m-d');
        //proveedores
        $suppliers = Supplier::all();

        //PROVEEDORES ORDEÑADOS
        $income = null;
        $income = Income::where('date', $date)->where('time_milk_record', $time_record)->first(['id']);
        $list = new Collection();
        if (!is_null($income)) {
            $suppliers_record = MilkRecord::where('income_id', $income->id)->get(['id', 'supplier_id', 'income_id']);
            foreach ($suppliers as $k => $v) {
                $supplier_milk = null;
                $supplier_milk = $suppliers_record->firstWhere('supplier_id', $v->id);
                if (!is_null($supplier_milk)) {
                    unset($suppliers[$k]);
                }
            }
        }
        foreach ($suppliers as $k => $v) {
            $item = [
                'id' => $v->id,
                'num_document' => $v->num_document,
                'name' => $v->name,
                'last_name' => $v->last_name,
                'email' => $v->email,
                'phone' => $v->phone,
                'url_image' => $v->photo,
            ];
            $list->push($item);
        }
        //dd($list);

        return response()->json([
            'success' => true,
            'suppliers' => $list,
            'code' => 'SUCCESS_FOUND_SUPPLIERS',
            'status' => 200
        ], 200);

    }

    public function milkRecorder(Request $request)
    {
        Log::debug('TIME ====>>'.$request->time_milk_record);
        $now = Carbon::now("America/Guayaquil");
        $date = $now->format('Y-m-d');
        $time = $now->format('H:i:s');
        $year = $now->year;

        $income = null;
        $income = Income::where('date', $date)->where('time_milk_record', $request->time_milk_record)->first();

        if (is_null($income)) {
            $income = new Income();
            $income->company_id = 1;
            $income->year = $year;
            $income->date = $date;
            $income->hour = $time;
            $income->total_liters = 0;
//            $income->price = 0;

            //$income->status = $request->status;
            $income->time_milk_record = $request->time_milk_record;
//            $income->status_milking = $request->status_milking;
            $income->save();
        }

        $supplier = Supplier::find($request->supplier_id);

        $milk_record = new MilkRecord();
        $milk_record->income_id = $income->id;
        $milk_record->supplier_id = $supplier->id;
        $milk_record->total_liters = $request->total_liters;
        $milk_record->price = $request->price;
        $milk_record->sub_total =$request->total_liters * $request->price;
        $milk_record->year = $year;
        $milk_record->date = $date;
        $milk_record->hour = $time;
        $milk_record->save();

        ///TOTAL DE LITROS SUMATORIA
        $income->total_liters = $income->total_liters + $request->total_liters;
        $income->save();
        return $this->suppliersByMilkiRecords($request);
    }

//    public function suppliers()
//    {
//
//        $list = new Collection();
//
//        $supplier = Supplier::all();
//
//        foreach ($supplier as $data){
//            $item = [
//                'id' => $data->id,
//                'num_document' => $data->num_document,
//                'name' => $data->name,
//                'last_name' => $data->last_name,
//                'email' => $data->email,
//                'phone' => $data->phone
//            ];
//            $list->push($item);
//        }
//
//        return response()->json([
//            'success' => true,
//            'suppliers' => $list
//        ], 200);
//    }

}
