<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EWalletController extends Controller
{
     /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function clients(){

        return view('admin.ewallet.clients')->with('i');
    }

    public function transactions(){

        return view('admin.ewallet.transactions')->with('i');
    }

    public function clientHistory(){

        return view('admin.ewallet.client_history')->with('i');
    }
}
