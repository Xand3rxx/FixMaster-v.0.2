<?php
namespace App\Http\Controllers;

use Auth;
use Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\State;
use App\Models\Lga;
use App\Models\Discount;
use App\Models\ServiceRequest;
use App\Models\Service;
use App\Models\Category;
use App\Models\Account;
use App\Models\Estate;
use App\Models\EstateDiscountHistory;
use App\Traits\Utility;
use App\Traits\Loggable;

class DiscountController extends Controller
{
    use Utility;
    use Loggable;
    //
    public function index()
    {
        $discounts = Discount::all();
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
        if($request->entity == 'service' && !isset($request->category))return back()->with('error', 'Select category');
    

        $fields = ['specified_request_count_morethan' => $request->specified_request_count_morethan, 'specified_request_count_equalto' => $request->specified_request_count_equalto, 'specified_request_amount_from' => $request->specified_request_amount_from, 'specified_request_amount_to' => $request->specified_request_amount_to, 'specified_request_start_date' => $request->specified_request_start_date, 'specified_request_end_date' => $request->specified_request_end_date, ];
        $entity = $request->input('entity');
        $users = $this->filterEntity($request);
        $update = '';
        $parameterArray = ['field' => array_filter($fields) , 'users' => $request->entity !='service'? $request->users:(isset($request->services)?$request->services: $request->category ) ];

        $discount = Discount::create(['name' => $request->input('discount_name') , 'entity' => $request->input('entity') , 'notify' => $request->input('notify') , 'rate' => $request->input('rate') , 'duration_start' => $request->input('start_date') , 'duration_end' => $request->input('end_date') , 'description' => $request->input('description') , 'parameter' => json_encode($parameterArray) , 'created_by' => Auth::user()->email, 'status' => 'activate']);

        if ($discount)
        {

            switch ($entity)
            {
                case 'user':
                    $update = $this->updateUsersDiscount($request, $discount);
                break;
                case 'estate':
                    if (empty($request->estate_name))
                    {
                        $update = $this->updateEstateUsersDiscount($request, $discount);
                    }
                    else
                    {
                        $update = $this->updateEstateTypeUsersDiscoun($request, $discount, $request->estate_name);
                    }
                    $this->updateEstateHistory($request, $discount);
                break;
                case 'service':
                    if (!empty($request->services)){
                        $update = $this->updateServiceDiscount($request, $discount);
                    }if(!empty($request->category)){
                        $update = $this->updateAllServiceDiscount($request, $discount);
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
           
            return request()->validate(['discount_name' => 'required|unique:discounts,name|max:250', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'category.*' => 'required', 'end_date' => 'required', 'description' => 'max:250']);
        }else{
            return request()->validate(['discount_name' => 'required|unique:discounts,name|max:250', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'users.*' => 'required', 'end_date' => 'required', 'description' => 'max:250']);

        }
    }

    public function show($language, $discount)
    {
        $status = Discount::findOrFail($discount);
        $data = ['discount' => $status, ];
        $data['entities'] = $this->entityArray();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')
            ->get();
        return response()
            ->view('admin.discount.summary', $data);
    }

    public function edit($language, $discount)
    {
        $status = Discount::findOrFail($discount);
        $data = ['status' => $status, ];
        $data['entities'] = $this->entityArray();
        $data['states'] = State::select('id', 'name')->orderBy('name', 'ASC')
            ->get();
        $data['parameters'] = $this->parameterList(['states' => $data['states']]);
        return response()->view('admin.discount.edit', $data);
    }

    public function delete($language, $discount)
    {

        $discountExists = Discount::findOrFail($discount);
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

        $discountExists = Discount::findOrFail($discount);
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
        $discountExists = Discount::findOrFail($discount);
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
            $wh = $d = [];
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
                $wh[] = ['est.id', '=', $fields['estate_name']];
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
                case 'user':
                    if (count(array_filter($chk_fields)) > 0)
                    {
                        $dataArry = ServiceRequest::select('sr.user_id', $replace_amount, 'first_name', 'last_name')->from(ServiceRequest::raw("(select  $replace_user, count(user_id) as users from service_requests $groupby)
                 sr Join accounts ac ON sr.user_id=ac.user_id"))->where($wh)->withTrashed()
                            ->get();

                    }
                    else
                    {
                        $dataArry = Account::select('user_id', 'first_name', 'last_name')->orderBy('accounts.user_id', 'ASC')
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
                            ->where($wh)->orderBy('est.id', 'ASC')
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
                case 'service':
                    if (count(array_filter($chk_fields)) > 0)
                    {
                        $dataArry = ServiceRequest::select('sr.uuid', 'first_name', 'last_name')->from(ServiceRequest::raw("(select uuid,  $replace_value,  COUNT(uuid) as users from service_requests $groupby)
                     sr Join estates est ON sr.uuid=est.uuid"))->where($wh)->withTrashed()
                            ->get();

                    }
                    else
                    {
                        $dataArry = Service::from('services as s')->select('uuid', 'name')
                            ->where($wh)->orderBy('s.id', 'ASC')
                            ->get();
                    }
                    $optionValue = '';
                    $optionValue .= "<option value='[all]' class='select-all'>All Services </option>";
                    foreach ($dataArry as $row)
                    {
                        $optionValue .= "<option value='$row->uuid' {{ old('service') == $row->uuid ? 'selected' : ''}}>$row->name</option>";
                    }

                    $data = array(
                        'options' => $optionValue
                    );

                break;
                default:
                    # code...
                    
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

            $optionValue = '';
            $optionValue .= "<option value=''>Select </option>";
            foreach ($estates as $row)
            {

                $optionValue .= "<option value='$row->estate_name' {{ old('estate_name') == $row->id ? 'selected' : ''}}>$row->estate_name</option>";
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
            $category = Category::select('id', 'name')->orderBy('name', 'ASC')
                ->get();
            $optionValue = '';
            $optionValue .= "<option value='all' class='select-all'>All Service Category </option>";
            foreach ($category as $row)
            {

                $optionValue .= "<option value='$row->id' {{ old('category') == $row->id ? 'selected' : ''}}>$row->name</option>";
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

                $optionValue .= "<option value='$row->id' {{ old('category_service') == $row->id ? 'selected' : ''}}>$row->name</option>";
            }
            $data = array(
                'service' => $optionValue
            );
        }

        return response()->json($data);
    }


    private function updateUsersDiscount($request, $discount)
    {
        $discount_arr = [];
        $user_discount = [];
        $new_discount_array = [];

        foreach ($request->users as $user)
        {
            $client = Account::where('user_id', $user)->first();
            if ($client->discounted)
            {
                $discount_arr = json_decode($client->discounted, true);
                foreach ($discount_arr as $key => $value)
                {
                    $new_discount_array[] = $value;
                }
                $new_discount_array[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['user_id' => $user, 'discounted' => json_encode($new_discount_array) ];
                Account::where('user_id', $user)->update($data);

            }
            else
            {
                $user_discount[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['user_id' => $user, 'discounted' => json_encode($user_discount) ];
                Account::where('user_id', $user)->update($data);
            }

        }
        return true;
    }

    private function updateEstateUsersDiscount($request, $discount)
    {
        $discount_arr = [];
        $user_discount = [];
        $new_discount_array = [];

        foreach ($request->users as $user)
        {
            $client = Estate::where('uuid', $user)->first();
            if ($client->discounted)
            {
                $discount_arr = json_decode($client->discounted, true);
                foreach ($discount_arr as $key => $value)
                {
                    $new_discount_array[] = $value;
                }
                $new_discount_array[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['user_id' => $user, 'discounted' => json_encode($new_discount_array) ];
                Estate::where('uuid', $user)->update($data);

            }
            else
            {
                $user_discount[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['uuid' => $user, 'discounted' => json_encode($user_discount) ];
                Estate::where('uuid', $user)->update($data);
            }

        }
        return true;

    }

    private function updateEstateTypeUsersDiscount($request, $discount, $type)
    {
        $discount_arr = [];
        $user_discount = [];
        $new_discount_array = [];

        foreach ($request->users as $user)
        {
            $client = Estate::where(['uuid' => $user, 'estate_name' => $type])->first();
            if ($client->discounted)
            {
                $discount_arr = json_decode($client->discounted, true);
                foreach ($discount_arr as $key => $value)
                {
                    $new_discount_array[] = $value;
                }
                $new_discount_array[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['user_id' => $user, 'discounted' => json_encode($new_discount_array) ];
                Estate::where(['uuid' => $user, 'estate_name' => $type])->update($data);
            }
            else
            {
                $user_discount[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['uuid' => $user, 'discounted' => json_encode($user_discount) ];
                Estate::where(['uuid' => $user, 'estate_name' => $type])->update($data);
            }

        }
        return true;
    }

    private function updateEstateHistory($request, $discount)
    {

        $discount = EstateDiscountHistory::create(['uuid' => $discount->uuid, 'name' => $request->input('entity') , 'estate_name' => $request->input('estate_name') , 'notify' => $request->input('notify') , 'rate' => $request->input('rate') , 'duration_start' => $request->input('start_date') , 'duration_end' => $request->input('end_date') , 'users' => json_encode($parameterArray['users']) , 'created_by' => Auth::user()->email, 'status' => 'activate']);

    }

    private function updateServiceDiscount($request, $discount)
    {       
        $discount_arr = [];
        $service_discount = [];
        $new_discount_array = [];

        foreach ($request->services as $service)
        {
            $client = Service::where(['id' =>  $service])->first();
            if ($client->discounted)
            {
                $discount_arr = json_decode($client->discounted, true);
                foreach ($discount_arr as $key => $value)
                {
                    $new_discount_array[] = $value;
                }
                $new_discount_array[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['id' =>  $service, 'discounted' => json_encode($new_discount_array) ];
                Service::where(['id' => $service])->update($data);
            }
            else
            {
                $service_discount[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['id' =>  $service, 'discounted' => json_encode($service_discount) ];
                Service::where(['id' =>  $service])->update($data);
            }

        }
        return true;
    }


    private function updateAllServiceDiscount($request, $discount)
    {       
        $discount_arr = [];
        $service_discount = [];
        $new_discount_array = [];
        $all_services = Service::select('id')->whereIn('category_id', $request->category)
        ->orderBy('name', 'ASC')
        ->get();
   

        foreach ($all_services as $service)
        {
            $client = Service::where(['id' =>  $service->id])->first();
            if ($client->discounted)
            {
                $discount_arr = json_decode($client->discounted, true);
                foreach ($discount_arr as $key => $value)
                {
                    $new_discount_array[] = $value;
                }
                $new_discount_array[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['id' =>  $service->id, 'discounted' => json_encode($new_discount_array) ];
                Service::where(['id' => $service->id])->update($data);
            }
            else
            {
                $service_discount[] = ['id' => $discount->id, 'rate' => $request->input('rate') ];
                $data = ['id' =>  $service->id, 'discounted' => json_encode($service_discount) ];
                Service::where(['id' =>  $service->id])->update($data);
            }

        }
        return true;
    }
}

