<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\LoyaltyManagement;
use App\Models\LoyaltyManagementHistory;
use App\Models\ServiceRequest;
use Carbon\Carbon;
use App\Models\Client;
use App\Models\User;
use App\Models\UserType;




class LoyaltyManagementController extends Controller
{
    use Utility, Loggable;
    //
    public function index()
    {
        $loyalty = LoyaltyManagement::select('accounts.first_name', 'accounts.last_name', 'accounts.user_id', 'loyalty_managements.*')
        ->orderBy('accounts.user_id', 'DESC')
        ->join('accounts', 'accounts.user_id', '=', 'loyalty_managements.client_id')
        ->get();
        return response()->view('admin.loyalty.list', compact('loyalty'));
    }

    public function create()
    {
        $data['clients']=  Client::select('accounts.first_name', 'accounts.last_name', 'accounts.user_id')->orderBy('clients.user_id', 'DESC')
        ->join('accounts', 'accounts.user_id', '=', 'clients.user_id')
        ->get();

        return response()->view('admin.loyalty.add', $data);
    }

    public function store(Request $request){
        $this->validateRequest($request);

        $loyalty = LoyaltyManagement::create([
            'client_id' => $request->input('users') ,
             'points' => $request->input('points'), 
             'type' => 'credited'
             
            ]);
            if($loyalty){
                $loyalty_history = LoyaltyManagementHistory::create([
                    'loyalty_id' => $loyalty->id,
                     'client_id' => $request->input('users')
                     
                    ]);
         

                $type = 'Request';
                $severity = 'Informational';
                $actionUrl = Route::currentRouteAction();
                $message = Auth::user()->email . ' Created loyalty for' . $request->input('users');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.loyalty_list', app()
                    ->getLocale())
                    ->with('success', 'Loyalty created successfully');
    
            }
            else
            {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to create ' . $request->input('users');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.add_loyalty', app()
                    ->getLocale())
                    ->with('error', 'An error occurred');
    
            }

    }

    private function validateRequest($request)
    {
         return request()->validate([
             'users' => 'required', 
             'points' => 'required',
              ]);
        
       
    }


    public function loyaltyUsers(Request $request)
    {
        if ($request->ajax())
        {
            $name = $optionValue = '';
           $amount = $request->amount;
           if($amount != ''){

           $dataArry = ServiceRequest::select('client_id','first_name', 'last_name')->where('total_amount', '=', $amount)
           ->join('accounts', 'accounts.user_id', '=', 'service_requests.client_id')
                ->get();

            $optionValue .= "<option value='' class='select-all'>All Users </option>";
            foreach ($dataArry as $row)
            {
                $name = $row->first_name . ' ' . $row->last_name;
                $optionValue .= "<option value='$row->client_id' {{ old('users') == $row->client_id ? '' : ''}}>$name</option>";
            }
        }else{

            $dataArry = ServiceRequest::select('client_id','first_name', 'last_name')
            ->join('accounts', 'accounts.user_id', '=', 'service_requests.client_id')
            ->groupBy('client_id')
                 ->get();
 
             $optionValue .= "<option value='' class='select-all'>All Users </option>";
             foreach ($dataArry as $row)
             {
                 $name = $row->first_name . ' ' . $row->last_name;
                 $optionValue .= "<option value='$row->client_id' {{ old('users') == $row->client_id ? '' : ''}}>$name</option>";
             }

        }

            $data = array(
                'options' => $optionValue
            );

        }

        return response()->json($data);
    
    }




    public function show($language, $loyalty)
    {
       
            $status =  LoyaltyManagement::select('accounts.first_name', 'accounts.last_name', 'accounts.user_id', 'loyalty_managements.*')
            ->orderBy('accounts.user_id', 'DESC')
            ->where('loyalty_managements.uuid', $loyalty)
            ->join('accounts', 'accounts.user_id', '=', 'loyalty_managements.client_id')
            ->first();
            $data = ['loyalty' => $status ];
            return response()->view('admin.loyalty.summary', $data);
    }
 
  
       
 
    public function edit($language, $loyalty)
    {
        $status = LoyaltyManagement::select('*')->where('uuid', $loyalty)->first();
        $data = ['status' => $status];
        $data['apply_discounts'] = ['Total bill', 'Materials', 'Labour cost', 'FixMaster royalty', 'Logistics'];
        $json = json_decode($status->parameter);
        $data['field']= $json->field;
        $data['users']= json_encode($json->users);
        $data['estate']= json_encode($json->estate);
        $data['category']= json_encode($json->category);
        $data['services']= json_encode($json->services);
        $data['entities'] = $this->entityArray();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')->get();
        $data['request_lga']= isset($data['field']->specified_request_lga)? Lga::select('*')->where('id',  $data['field']->specified_request_lga)->first(): '';
        $data['request_state']= isset($data['field']->specified_request_lga)? State::select('*')->where('id',  $data['request_lga']['state_id'])->first(): '';
        return response()->view('admin.loyalty.edit', $data);
    }

   
   

}

