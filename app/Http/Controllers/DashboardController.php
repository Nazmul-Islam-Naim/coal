<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;
use Session;
use Auth;
use DB;

class DashboardController extends Controller
{	
	public function index() {
		return view('dashboard');
	}
}
