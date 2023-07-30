<?php

namespace App\Http\Controllers;

use App\Http\Requests\LocalSupplier\CreateRequest;
use App\Http\Requests\LocalSupplier\UpdateRequest;
use App\Models\LocalSupplier;
use App\Models\LocalSupplierLedger;
use App\Models\BankAccount;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Validator;
use Session;

class LocalSupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['localSuppliers']= LocalSupplier::paginate(250);
        return view('localSupplier.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('localSupplier.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        $data = $request->all();
        $data['bill'] = $request->pre_due??0;
        $data['due'] = $request->pre_due??0;
        try{
            $localSupplier = LocalSupplier::create($data);
            LocalSupplierLedger::create([
                'local_supplier_id' => $localSupplier->id,
                'date' => Carbon::now(),
                'reason' => 'Previous due',
                'amount' => $request->pre_due??0
            ]);
            Session::flash('flash_message','Local Supplier Successfully Added !');
            return redirect()->route('local-suppliers.index')->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data['localSupplier']= LocalSupplier::findOrFail($id);
        return view('localSupplier.ledger', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['localSupplier']= LocalSupplier::findOrFail($id);
        return view('localSupplier.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->all();
        $token = Arr::pull($data, '_token');
        $method = Arr::pull($data, '_method');
        $preDue = Arr::pull($data, 'pre_due');
        $localSupplier = LocalSupplier::findOrFail($id);
        $data['bill'] =abs($localSupplier->bill - $localSupplier->preDue->amount + ($request->pre_due??0));
        $data['due'] =abs($localSupplier->bill - $localSupplier->preDue->amount +  ($request->pre_due??0));
        try{
            $localSupplier = LocalSupplier::where('id', $id)->update($data);
            LocalSupplierLedger::where([['local_supplier_id',$id],['reason', 'like', '%Previous due%']])->update([
                'amount' => $request->pre_due??0
            ]);
            Session::flash('flash_message','Local Supplier Successfully Updated !');
            return redirect()->route('local-suppliers.index')->with('status_color','success');
        }catch(\Exception $e){
            dd($e->getMessage());
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            LocalSupplier::where('id', $id)->delete();
            Session::flash('flash_message','Local Supplier Successfully Deleted !');
            return redirect()->route('local-suppliers.index')->with('status_color','success');
        }catch(\Exception $e){
            dd($e->getMessage());
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }

    // bill actions
    public function payableSuppliers(){
        $data['payableSuppliers']= LocalSupplier::where('due', '>', 0)->paginate(250);
        return view('localSupplier.payableSuppliers', $data);
    }

    public function paymentForm($id){
        $data['bankAccounts']= BankAccount::all();
        $data['payableSupplier']= LocalSupplier::findOrFail($id);
        return view('localSupplier.paymentForm', $data);
    }
}
