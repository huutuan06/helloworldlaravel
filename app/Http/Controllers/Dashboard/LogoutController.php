<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Using this method to logout from Website
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request){
        Auth::logout();
        Session::flush();
        Redirect::back();
        return redirect()->route('login');
    }
}
