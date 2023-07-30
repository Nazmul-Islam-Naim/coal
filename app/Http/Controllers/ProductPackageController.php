<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductPackage;
use App\Models\FoodType;
use Validator;
use Session;
use Auth;
use DB;

class ProductPackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= ProductPackage::paginate(50);
        $data['alltype']= FoodType::all();
        return view('sell.package', $data);
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
        $validator = Validator::make($request->all(), [
            'food_type' => 'required',
            'package_code' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }

        $input = $request->all();
        $input['status'] = 1;

        if($request->hasFile('image')) {
            $image = $request->file('image');
            $time = date('Ymdhis');
            $name = $time.rand(1, 99999) . '.' . $image->getClientOriginalExtension();
            $Path = public_path('/storage/app/public/uploads/product_package/');
            $image->move($Path, $name);
            $input['image'] = $name;
        }

        DB::beginTransaction();
        try{
            $bug=0;
            $insert= ProductPackage::create($input);
            DB::commit();
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
            DB::rollback();
        }

        if($bug==0){
            Session::flash('flash_message','Package Successfully Added !');
            return redirect()->back()->with('status_color','success');
        }else{
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data['single_data'] = ProductPackage::findOrFail($id);
        $data['alldata']= ProductPackage::paginate(50);
        return view('sell.package', $data);
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
        $data=ProductPackage::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'food_type' => 'required',
            'package_code' => 'required',
            'name' => 'required',
            'price' => 'required',
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
              
        $input = $request->all();
        
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $time = date('Ymdhis');
            $name = $time.rand(1, 99999) . '.' . $image->getClientOriginalExtension();
            $Path = public_path('/storage/app/public/uploads/product_package/');
            $image->move($Path, $name);
            $input['image'] = $name;
            
            $img_path='/storage/app/public/uploads/product_package/'.$data['image'];
            if($data['image']!=null and file_exists($img_path)){
                unlink($img_path);
            }
        }else{
            $input['image'] = $data->image;
        }

        try{
            $bug=0;
            $data->update($input);
        }catch(\Exception $e){
            $bug=$e->errorInfo[1];
        }

        if($bug==0){
            Session::flash('flash_message','Package Successfully Updated !');
            return redirect()->back()->with('status_color','warning');
        }else{
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
        $data = ProductPackage::findOrFail($id);
        $action = $data->delete();

        if($action){
            Session::flash('flash_message','Package Successfully Deleted !');
            return redirect()->back()->with('status_color','danger');
        }else{
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
