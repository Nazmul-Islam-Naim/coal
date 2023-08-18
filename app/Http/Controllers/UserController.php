<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Validator;
use Response;
use Session;
use Auth;
use Hash;
use DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['alldata']= User::where('type', '!=', '1')->get();
        return view('users.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.create');
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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'type_id' => 'required'
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        try{
            User::create([
                'name' => $request->name,
                'password' => Hash::make($request->password),
                'password_hint' => $request->password,
                'email'    => $request->email,
                'type'    => $request->type_id,
            ]);
            Session::flash('flash_message','User Successfully Added !');
            return redirect()->route('user.index')->with('status_color','success');
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
        $data['single_data'] = User::findOrFail($id);
        return view('users.edit', $data);
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
        $data=User::findOrFail($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$data->id,
            'type'    => $request->type_id,
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        
        $input = $request->all();

        if ($request->password !="") {
            $input['password'] = Hash::make($request->password);
            $input['password_hint'] = $request->password;
        }else{
            $input['password'] = $data->password;
        }

        try{
            $data->update($input);
            Session::flash('flash_message','User Successfully Updated !');
            return redirect()->route('user.index')->with('status_color','warning');
        }catch(\Exception $e){
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
        //
    }

    /**
     * change password form
     */
    public function changePassword(){
        return view('users.changePassword');
    }

    /**
     * update password
     */
    public function updatePassword(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'password' => ['required', 'confirmed'],
        ]);
        if ($validator->fails()) {
            Session::flash('flash_message', $validator->errors());
            return redirect()->back()->with('status_color','warning');
        }
        $data=User::findOrFail($id);
        $input = $request->all();
        $input['password'] = Hash::make($request->password);
        $input['password_hint'] = $request->password;
        try{
            $data->update($input);
            Session::flash('flash_message','Password Updated !');
            return redirect()->back()->with('status_color','success');
        }catch(\Exception $e){
            Session::flash('flash_message','Something Error Found !');
            return redirect()->back()->with('status_color','danger');
        }
    }
}
