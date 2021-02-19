<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function AdminLogin(Request $request){

    }

    public function Adminlogout(Request $request){
        if ($request->session()->exists('user')) {
			$request->session()->forget('user');
			$request->session()->flush();
			return $this->sendResponse([], 200, 'Session cleared');
		}
		return $this->sendResponse([], 200, 'Session cleared');
    }
}
