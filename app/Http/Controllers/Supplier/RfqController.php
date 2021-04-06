<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Route;

use App\Models\User;
use App\Models\ActivityLog;
use App\Models\UserType;
use App\Traits\Loggable;
use Illuminate\Support\Facades\URL;
use App\Models\Rfq;

class RfqController extends Controller
{
    use Loggable; 

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    public function __construct() {
        $this->middleware('auth:web');
    }

    public function index(){

        $rfqs = Rfq::orderBy('created_at', 'DESC')->get();

        return view('supplier.rfq.index', [
            'rfqs'   =>  $rfqs,
        ])->with('i');
    }

    public function rfqDetails($language, $uuid){

        $rfqDetails = Rfq::where('uuid', $uuid)->firstOrFail();

        return view('supplier.rfq._details', [
            'rfqDetails'    =>  $rfqDetails,
        ])->with('i');
    }

}
