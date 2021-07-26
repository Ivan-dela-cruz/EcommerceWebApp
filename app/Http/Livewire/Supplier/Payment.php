<?php

namespace App\Http\Livewire\Supplier;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use App\SuplierPay;
use App\Models\MilkRecord;
use App\Models\Supplier;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
class Payment extends Component
{
    public $suplier_id = '',$user_id,$date,$biweekly,$address,$description,$total_liters  = 0,$unit_price = 0;
    public $cheese = 0,$serum = 0,$yogurt = 0,$loan = 0,$balanced = 0,$salt = 0,$transaction = 0,$total = 0;
    public $lastDayofMonth,$firstOfMonth;
    public $action = 'POST';
    public $data_id;
    public function mount()
    {
        $type = request('id');
        if($type == 0){
            $this->date = Carbon::now()->format('Y-m-d');
            $this->lastDayofMonth = Carbon::now()->endOfMonth()->toDateString();
            $this->firstOfMonth = Carbon::now()->firstOfMonth()->toDateString();
        }else{
            $data  = SuplierPay::find($type);
            if(!is_null($data)){
                $this->loadData($data);
            }
        }
    }

    public function render()
    {
        if($this->suplier_id!=''){
            $this->address = Supplier::find($this->suplier_id)->address;
        }
        $now = Carbon::now();
        $dateMiddle = Carbon::parse($now->year.'-'.$now->month.'-15');
        $dateInit = Carbon::parse($this->firstOfMonth);
        $dateFinal = Carbon::parse($this->lastDayofMonth);
        if($now <= $dateMiddle ){
            $this->biweekly = 'Primera Quincena';
            $tot_lit = MilkRecord::where('supplier_id',$this->suplier_id)->whereBetween('created_at',[$dateInit,$dateMiddle])->sum('total_liters');
        }
        if($now <= $dateFinal && $now > $dateMiddle){
            $this->biweekly = 'Segunda Quincena';
            $tot_lit = MilkRecord::where('supplier_id',$this->suplier_id)->whereBetween('created_at',[$dateMiddle,$dateFinal])->sum('total_liters');
        }
        try {
            $this->cheese= number_format($this->cheese,2,'.','');
            $this->serum= number_format($this->serum,2,'.','');
            $this->yogurt= number_format($this->yogurt,2,'.','');
            $this->loan= number_format($this->loan,2,'.','');
            $this->balanced= number_format($this->balanced,2,'.','');
            $this->salt= number_format($this->salt,2,'.','');
            $this->transaction= number_format($this->transaction,2,'.','');
            $auxVal = $this->cheese + $this->serum + $this->yogurt + $this->loan + $this->balanced  + $this->salt + $this->transaction;
            $this->total_liters = $tot_lit;
            $this->total =  ($this->total_liters*$this->unit_price)-$auxVal;
            $this->total = number_format($this->total, 2, '.', '');
        } catch (Exception $e) {
            $auxVal = 0;
            $this->total =0;
        }
        $suppliers = DB::table('suppliers')->select('id', DB::raw("CONCAT(suppliers.name,' ',suppliers.last_name) AS name"))->where('suppliers.deleted_at', NULL)->get(['name', 'id']);
        return view('livewire.supplier.payment',compact('suppliers'));
    }
    public function store(){
      
            $this->validateInfo();
            $data_supplier = [
                'suplier_id'=>$this->suplier_id,
                'date'=>$this->date,
                'biweekly'=>$this->biweekly,
                'address'=>$this->address,
                'description'=>$this->description,
                'total_liters'=>$this->total_liters,
                'unit_price'=>$this->unit_price,
                'cheese'=>$this->cheese,
                'serum'=>$this->serum,
                'yogurt'=>$this->yogurt,
                'loan'=>$this->loan,
                'balanced'=>$this->balanced,
                'salt'=>$this->salt,
                'transaction'=>$this->transaction,
                'total'=>$this->total,
            ];

            $supplier = SuplierPay::create($data_supplier);
            $this->resetInputFields();
            $this->alert('success', 'Pago registrado con exito.');
        
    }
    public function update(){
        
            $this->validateInfo();
            $data_supplier = [
                'suplier_id'=>$this->suplier_id,
                'date'=>$this->date,
                'biweekly'=>$this->biweekly,
                'address'=>$this->address,
                'description'=>$this->description,
                'total_liters'=>$this->total_liters,
                'unit_price'=>$this->unit_price,
                'cheese'=>$this->cheese,
                'serum'=>$this->serum,
                'yogurt'=>$this->yogurt,
                'loan'=>$this->loan,
                'balanced'=>$this->balanced,
                'salt'=>$this->salt,
                'transaction'=>$this->transaction,
                'total'=>$this->total,
            ];
            $supplier = SuplierPay::find($this->data_id);
            if(!is_null($supplier)){
                $supplier->update($data_supplier);
                $this->resetInputFields();
                $this->alert('success', 'Pago actualizado con exíto.');
                return;
            }
            $this->alert('error', 'No se encontrón el registro.');
                return;
        
    }
    public function loadData($dataSet){
        $this->data_id = $dataSet->id;
        $this->suplier_id =  $dataSet->suplier_id;
        $this->address =  $dataSet->address;
        $this->description =  $dataSet->description;
        $this->total_liters = $dataSet->total_liters;
        $this->unit_price = $dataSet->unit_price;
        $this->cheese = $dataSet->cheese;
        $this->serum = $dataSet->serum;
        $this->yogurt = $dataSet->yogurt;
        $this->loan = $dataSet->loan;
        $this->balanced = $dataSet->balanced;
        $this->salt = $dataSet->salt;
        $this->transaction = $dataSet->transaction;
        $this->total = $dataSet->total;
        $this->date = $dataSet->date;
        $this->action = 'PUT';
        $this->alert('success', 'Datos recuperados  con exito.');
    }
    public function resetInputFields()
    {
        $this->suplier_id = '';
        $this->address = '';
        $this->description = '';
        $this->total_liters = 0;
        $this->unit_price = 0;
        $this->cheese = 0;
        $this->serum = 0;
        $this->yogurt = 0;
        $this->loan = 0;
        $this->balanced = 0;
        $this->salt = 0;
        $this->transaction = 0;
        $this->total = 0;
    }
    public function validateInfo(){
        $this->Validate([
            'suplier_id'=>'required',
            'date'=>'required',
            'biweekly'=>'required',
            'address'=>'required',
            'description'=>'',
            'total_liters'=>'numeric',
            'unit_price'=>'numeric',
            'cheese'=>'numeric',
            'serum'=>'numeric',
            'yogurt'=>'numeric',
            'loan'=>'numeric',
            'balanced'=>'numeric',
            'salt'=>'numeric',
            'transaction'=>'numeric',
            'total'=>'numeric'
        ]);
    }

}
