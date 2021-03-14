<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Lga;
use App\Models\Discount;
use App\Models\ClientDiscount;
use App\Models\ServiceDiscount;
use App\Models\ServiceRequest;
use App\Models\Service;
use App\Models\Category;
use App\Models\Account;
use App\Models\Estate;
use App\Models\EstateDiscountHistory;
use App\Traits\Utility;
use App\Traits\Loggable;
use Carbon\Carbon;


class DiscountController extends Controller
{
    use Utility;
    use Loggable;
    //
    public function index()
    {
        $discounts = Discount::orderBy('id', 'DESC')->get();
        return response()->view('admin.discount.list', compact('discounts'));
    }

    public function create()
    {
    
        $data['entities'] = $this->entityArray();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')
            ->get();
        return response()
            ->view('admin.discount.add', $data);
    }

    public function store(Request $request)
    {
        //Validate discount input
      
        $this->validateRequest($request);
        $this->validateFieldRequest($request);
      
    
        $fields = [
        'specified_request_count_morethan' => $request->specified_request_count_morethan,
        'specified_request_count_equalto' => $request->specified_request_count_equalto, 
        'specified_request_amount_from' => $request->specified_request_amount_from,
        'specified_request_amount_to' => $request->specified_request_amount_to,
        'specified_request_start_date' => $request->specified_request_start_date,
        'specified_request_end_date' => $request->specified_request_end_date,
        'specified_request_lga' => $request->specified_request_lga
         ];
     
        $entity = $request->input('entity');
        $users = $this->filterEntity($request);
        $update = '';
        $parameterArray = [
        'field' => array_filter($fields) , 
        'users' =>  $request->users,
        'category' => isset($request->category)? $request->category: '' ,
        'services' => isset($request->services)?$request->services:'',
        'estate' => isset($request->estate_name) ? $request->estate_name: ''
       ];
  
       
        $discount = Discount::create([
            'name' => $request->input('discount_name') ,
             'entity' => $request->input('entity') , 
             'notify' => $request->input('notify') , 
             'rate' => $request->input('rate') , 
             'duration_start' => $request->input('start_date') , 
             'duration_end' => $request->input('end_date') , 
             'description' => $request->input('description') , 
            'parameter' => json_encode($parameterArray) ,
            'created_by' => Auth::user()->email,
            'status' => 'activate'
            ]);

         
        if ($discount)
        {

            switch ($entity)
            {
                case 'client':
                    $update = $this->createUsersDiscount($request, $discount);
                break;
                case 'estate':
                    if (empty($request->estate_name))
                    {
                        $update = $this->createEstateUsersDiscount($request, $discount);
                    }
                    else
                    {
                        $update = $this->createEstateTypeUsersDiscount($request, $discount, $request->estate_name);
                    }
                    $this->createEstateHistory($request, $discount);
                break;
                case 'service':
                    if (!empty($request->services)){
                        $update = $this->createServiceDiscount($request, $discount);
                    }else{
                        $update = $this->createAllServiceDiscount($request, $discount);
                    }
                 
                break;
                default:
                    # code...
                    
                break;
            }

        }

        if ($update)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' Created discount' . $request->input('discount_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount created successfully');

        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to create ' . $request->input('discount_name');
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.add_discount', app()
                ->getLocale())
                ->with('error', 'An error occurred');

        }

    }


    private function validateRequest($request)
    {
        if($request->entity == 'service'){
           
            return request()->validate(['discount_name' => 'required|unique:discounts,name|max:250', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'category' =>  'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);
        }else{
            return request()->validate(['discount_name' => 'required|unique:discounts,name|max:250', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'users' => 'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);

        }
    }

    private function validateFieldRequest($request)
    {
            return request()->validate([
                'specified_request_count_morethan' => 'nullable|numeric',
                'specified_request_count_equalto' => 'nullable|numeric',
                'specified_request_amount_from'  => 'nullable|numeric',
                'specified_request_amount_to'   => 'nullable|numeric',
           ]);
        
    }

    public function show($language, $discount)
    {
        $status = Discount::where('uuid', $discount)->first();
        $data = ['discount' => $status, ];
        $data['entities'] = $this->entityArray();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')
            ->get();
        return response()
            ->view('admin.discount.summary', $data);
    }



    public function delete($language, $discount)
    {

        $discountExists = Discount::where('uuid', $discount)->first();
        $disountEntity = Discount::select('entity')->where('uuid', $discount)->first();
       
        if( $disountEntity->entity == 'service'){
            ServiceDiscount::where('discount_id', $discount)->delete();
        }
        if( $disountEntity->entity != 'service'){
            ClientDiscount::where('discount_id', $discount)->delete();
        }
        //Casted to SoftDelete
        $softDeleteUser = $discountExists->delete();
        if ($softDeleteUser)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deleted ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount has been deleted');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to delete ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');

        }
    }

    public function deactivate($language, $discount)
    {

        $discountExists = Discount::where('uuid', $discount)->first();
        $disountEntity = Discount::select('entity')->where('uuid', $discount)->first();
       
        if( $disountEntity->entity == 'service'){
            ServiceDiscount::where('discount_id', $discount)->update(['status' => 'deactivate']);
        }
        if( $disountEntity->entity != 'service'){
            ClientDiscount::where('discount_id', $discount)->update(['status' => 'deactivate' ]);
        }
        $deactivateDiscount = Discount::where('uuid', $discount)->update(['status' => 'deactivate', ]);

        if ($deactivateDiscount)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deactivated ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount has been deactivated');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to deactivate ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function reinstate($language, $discount)
    {
        $status = '';
        $discountExists = Discount::where('uuid', $discount)->first();
        $disountEntity = Discount::select('entity')->where('uuid', $discount)->first();
       
        if( $disountEntity->entity == 'service'){
            ServiceDiscount::where('discount_id', $discount)->update(['status' => 'activate']);
        }
        if( $disountEntity->entity != 'service'){
            ClientDiscount::where('discount_id', $discount)->update(['status' => 'activate' ]);
        }

     
        $deactivateDiscount = Discount::where('uuid', $discount)->update(['status' => 'activate', ]);
  

        if ($deactivateDiscount)
        {
            $type = 'Request';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email . ' deactivated ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return redirect()->route('admin.discount_list', app()
                ->getLocale())
                ->with('success', 'Discount has been deactivated');
        }
        else
        {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to activate ' . $discountExists->name;
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred');
        }
    }

    public function discountUsers(Request $request)
    {
        if ($request->ajax())
        {
            $wh = $d =  $est= [];
            $groupby = '';
            $replace_amount = 'middle_name';
            $replace_user = 'user_id';
            parse_str($request->data, $fields);
            $entity = $fields['entity'];
            $replace_value = 'user_id';

            $chk_fields = ['specified_request_count_morethan' => $fields['specified_request_count_morethan'], 'specified_request_count_equalto' => $fields['specified_request_count_equalto'], 'specified_request_amount_from' => $fields['specified_request_amount_from'], 'specified_request_amount_to' => $fields['specified_request_amount_to'], 'specified_request_start_date' => $fields['specified_request_start_date'], 'specified_request_end_date' => $fields['specified_request_end_date'], ];

            if ($fields['specified_request_count_morethan'] != '')
            {
                $wh[] = ['sr.users', '>=', $fields['specified_request_count_morethan']];
                $groupby = 'group by user_id';
                if ($entity == 'estate')
                {
                    $groupby = 'group by uuid';
                    $replace_value = " '*'";
                }

            }

            if ($fields['specified_request_count_equalto'] != '')
            {
                $wh[] = ['sr.users', '=', $fields['specified_request_count_equalto']];
                $groupby = 'group by user_id';
                if ($entity == 'estate')
                {
                    $groupby = 'group by uuid';
                    $replace_value = " '*'";
                }

            }

            if ($fields['specified_request_amount_from'] != '')
            {
                $wh[] = ['sr.total_amount', '>=', $fields['specified_request_amount_from']];
                $replace_amount = "total_amount";
                $replace_user = 'total_amount, user_id';
                $groupby = 'group by total_amount, user_id';
                if ($entity == 'estate')
                {
                    $replace_value = "total_amount";
                    $groupby = 'group by total_amount, uuid';
                }
            }

            if ($fields['specified_request_amount_to'] != '')
            {
                $wh[] = ['sr.total_amount', '<=', $fields['specified_request_amount_to']];
                $replace_amount = "total_amount";
                $replace_user = 'total_amount, user_id';
                $groupby = 'group by total_amount, user_id';
                if ($entity == 'estate')
                {
                    $replace_value = "total_amount";
                    $groupby = 'group by total_amount, uuid';
                }

            }

            if ($fields['specified_request_start_date'] != '')
            {
                $start_date = date('Y-m-d h:i:s', strtotime($fields['specified_request_start_date']));
                $wh[] = ['sr.created_at', '>=', "$start_date"];
                $replace_amount = "created_at";
                $replace_user = 'created_at,user_id';
                $groupby = 'group by user_id,created_at';
                if ($entity == 'estate')
                {
                    $replace_value = "created_at";
                    $groupby = 'group by uuid,created_at';
                }
            }

            if ($fields['specified_request_end_date'] != '')
            {
                $start_date = date('Y-m-d h:i:s', strtotime($fields['specified_request_end_date']));
                $wh[] = ['sr.created_at', '<=', "$end_date"];
                $replace_amount = "created_at";
                $replace_user = 'created_at,user_id';
                $groupby = 'group by user_id,created_at';
                if ($entity == 'estate')
                {
                    $replace_value = "created_at";
                    $groupby = 'group by uuid,created_at';
                }
            }

            if (isset($fields['lga']) && $fields['lga'] != '')
            {
                $wh[] = ['lga_id', '=', $fields['lga']];
                $groupby = 'group by user_id';
                if ($entity == 'estate')
                {
                    $wh[] = ['est.lga_id', '=', $fields['lga']];
                    $replace_value = "created_at";
                    $groupby = 'group by uuid,created_at';
                }
            }

            if (isset($fields['estate_name']) && $fields['estate_name'] != '')
            {
                $est[] = ['est.estate_name', '=', $fields['estate_name']];
            }

       

            if (count($wh) == 0)
            {
                $groupby = 'group by user_id';
                if ($entity == 'estate')
                {
                    $groupby = 'uuid';
                    $replace_value = "'*'";
                }

            }

            switch ($entity)
            {
                case 'client':
                    if (count(array_filter($chk_fields)) > 0)
                    {
                        $dataArry = ServiceRequest::select('sr.user_id', $replace_amount, 'first_name', 'last_name')->from(ServiceRequest::raw("(select  $replace_user, count(user_id) as users from service_requests $groupby)
                        sr Join accounts ac ON sr.user_id=ac.user_id Join clients cs ON sr.user_id=cs.account_id "))->where($wh)->withTrashed()
                                   ->get();
                    }
                    else
                    {
                        $dataArry = Account::select('accounts.user_id', 'first_name', 'last_name')
                        ->join('clients', 'accounts.user_id', '=', 'clients.account_id')
                        ->join('users', 'users.id', '=', 'accounts.user_id')
                        ->orderBy('accounts.user_id', 'ASC')
                        ->get();
                    }
                    $name = '';
                    $optionValue = '';
                    $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                    $optionValue .= " <option value='' data-divider='true'></option>";
                    foreach ($dataArry as $row)
                    {
                        $name = $row->first_name . ' ' . $row->last_name;
                        $optionValue .= "<option value='$row->user_id' {{ old('lga') == $row->user_id ? 'selected' : ''}}>$name</option>";
                    }

                    $data = array(
                        'options' => $optionValue
                    );

                break;
                case 'estate':
                    if (count(array_filter($chk_fields)) > 0)
                    {
                        $dataArry = ServiceRequest::select('sr.uuid', 'first_name', 'last_name')->from(ServiceRequest::raw("(select uuid,  $replace_value,  COUNT(uuid) as users from service_requests $groupby)
                         sr Join estates est ON sr.uuid=est.uuid"))->where($wh)->withTrashed()
                            ->get();

                    }
                    else
                    {
                        $dataArry = Estate::from('estates as est')->select('uuid', 'first_name', 'last_name')
                            ->where($est)->orderBy('est.id', 'ASC')
                            ->get();
                    }


                    $name = '';
                    $optionValue = '';
                    $optionValue .= "<option value='[all]' class='select-all'>All Users </option>";
                    $optionValue .= " <option value='' data-divider='true'></option>";
                    foreach ($dataArry as $row)
                    {
                        $name = $row->first_name . ' ' . $row->last_name;
                        $optionValue .= "<option value='$row->uuid' {{ old('user') == $row->uuid ? 'selected' : ''}}>$name</option>";
                    }

                    $data = array(
                        'options' => $optionValue
                    );

                break;
              
             
                default:
                $data =[];
                break;
            }
            return response()->json($data);

        }
    }

    public function getLGA(Request $request)
    {
        if ($request->ajax())
        {
            $lgas = [];
            $lgas = Lga::select('id', 'name')->where('state_id', $request->state_id)
                ->orderBy('name', 'ASC')
                ->get();
            $optionValue = '';
            $optionValue .= "<option value=''>Select </option>";
            foreach ($lgas as $row)
            {

                $optionValue .= "<option value='$row->id' {{ old('lga') == $row->id ? 'selected' : ''}}>$row->name</option>";
            }

            $data = array(
                'lgas' => $optionValue
            );

        }
        return response()->json($data);
    }

    public function estates(Request $request)
    {
        if ($request->ajax())
        {
            
            $estates = [];
            $estates = Estate::select('id', 'estate_name')->orderBy('estate_name', 'ASC')
                ->get();
            $select = $request->estate_name? str_replace('"', "", $request->estate_name ): 'select';
            $optionValue = '';
            $optionValue .= "<option value=''> $select </option>";
            foreach ($estates as $row)
            {

                $optionValue .= "<option value='$row->estate_name' {{  $request->estate_name == $row->id ? 'selected' : ''}}>$row->estate_name</option>";
            }

            $data = array(
                'estates' => $optionValue
            );

        }

        return response()->json($data);

    }

    public function category(Request $request)
    {
        if ($request->ajax())
        {
            $category = [];
            $category = Category::select('id', 'name', )->orderBy('name', 'ASC')
                ->get();
            $optionValue = '';
            $optionValue .= "<option value='all' class='select-all'>All Service Category </option>";
            foreach ($category as $row)
            {
                if($row->name != 'Uncategorized')
                $optionValue .= "<option value='$row->id' >$row->name</option>";
            }

            $data = array(
                'category' => $optionValue
            );
        }
        return response()->json($data);

    }


    public function categoryServices(Request $request)
    {
        if ($request->ajax())
        {
           
            $service = []; 
            if (in_array("all", $request->data))
            {
                $service = Service::select('id', 'name')->orderBy('name', 'ASC')
                    ->get();
            }
            else
            {
                $service = Service::select('id', 'name')->whereIn('category_id', $request->data)
                    ->orderBy('name', 'ASC')
                    ->get();
            }
            $optionValue = '';
            $optionValue .= "<option value='all-services' class='select-all'>All services </option>";
            foreach ($service as $row)
            {
              
                $optionValue .= "<option value='$row->id' >$row->name</option>";
            }
            $data = array(
                'service' => $optionValue
            );
        }

        return response()->json($data);
    }

 

    private function createUsersDiscount($request, $discounts)
    {
        $allusers = [];     
       foreach ($request->users as $user)
        {           
         $discount = ClientDiscount::create([
            'discount_id' => $discounts->uuid,
            'discount_name' => $request->input('discount_name') ,
            'entity' => $request->input('entity') , 
            'notify' => $request->input('notify') ,
            'rate' => $request->input('rate') ,
            'description' => $request->input('description') ,
            'created_by' => Auth::user()->email,
            'user_id'=> $user,
            'status' => 'activate'
    
                ]);
        }

        return true;
    }


    private function createEstateUsersDiscount($request, $discounts)
    {
        $allusers = [];    
     
       foreach ($request->users as $user)
        {           
         $discount = ClientDiscount::create([
            'discount_id' => $discounts->uuid,
            'discount_name' => $request->input('discount_name') ,
            'entity' => $request->input('entity') , 
            'notify' => $request->input('notify') ,
            'rate' => $request->input('rate') ,
            'description' => $request->input('description') ,
            'created_by' => Auth::user()->email,
            'uuid'=> $user,
            'status' => 'activate'
    
                ]);
        }

        return true;
    }


 

    private function createEstateTypeUsersDiscount($request, $discounts, $type)
    {
       
        $users = Estate::select('id')->where('estate_name', $type)->whereIn('id', $request->users)
        ->get();

        foreach ($users as $user)
        {           
         $discount = ClientDiscount::create([
            'discount_id' => $discounts->uuid,
            'discount_name' => $request->input('discount_name') ,
            'entity' => $request->input('entity') , 
            'notify' => $request->input('notify') ,
            'rate' => $request->input('rate') ,
            'description' => $request->input('description') ,
            'created_by' => Auth::user()->email,
            'user_id'=> $user->id,
            'status' => 'activate'
    
                ]);
        }
        return true;
    }

    private function createEstateHistory($request, $discounts)
    {
        $discount = EstateDiscountHistory::create([
        'discount_id' => $discounts->uuid,
        'name' => $request->input('discount_name'),
        'estate_name' => $request->input('estate_name')? $request->input('estate_name'): 'all users'  ,
        'notify' => $request->input('notify') ,
        'rate' => $request->input('rate') ,
        'duration_start' => $request->input('start_date') ,
        'duration_end' => $request->input('end_date') , 
        'created_by' => Auth::user()->email, 
        'status' => 'activate'
         ]);

    }

    private function createServiceDiscount($request, $discounts)
    {     
     
        $all_services = Service::select('uuid')->whereIn('id', $request->services)
        ->orderBy('name', 'ASC')
        ->get();
        foreach ($all_services  as $service)
        {
            $service = ServiceDiscount::create([
                'discount_id' => $discounts->uuid,
                'discount_name' => $request->input('discount_name') ,
                'entity' => $request->input('entity') , 
                'notify' => $request->input('notify') ,
                'rate' => $request->input('rate') ,
                'description' => $request->input('description') ,
                'created_by' => Auth::user()->email,
                'service_id'=> $service->uuid,
                'status' => 'activate'
                    ]);
        }
        return true;
    }




   

    private function createAllServiceDiscount($request, $discounts)
    {    
        
        $all_services = Service::select('uuid')->whereIn('category_id', $request->category)
        ->orderBy('name', 'ASC')
        ->get();   
        foreach ($all_services as $service)
        {
                 
         $service = ServiceDiscount::create([
        'discount_id' => $discounts->uuid,
        'discount_name' => $request->input('discount_name') ,
        'entity' => $request->input('entity') , 
        'notify' => $request->input('notify') ,
        'rate' => $request->input('rate') ,
        'description' => $request->input('description') ,
        'created_by' => Auth::user()->email,
        'service_id'=> $service->uuid,
        'status' => 'activate'
            ]);

        }
        return true;
    }


}

