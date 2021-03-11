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

class DiscountEditController extends Controller
{
    use Utility;
    use Loggable;
    //
   


    public function edit($language, $discount)
    {
        $status = Discount::select('*')->where('uuid', $discount)->first();
        $data = ['status' => $status];
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
        return response()->view('admin.discount.edit', $data);
    }



    public function categoryEdit(Request $request)
    {
        if ($request->ajax())
        {
            $category = [];
            parse_str($request->data['form'], $fields);
            $entity = $fields['entity'];
            $replace_value = 'user_id';
            $edit_category = json_decode($fields['edit_category'][0]);  
    
            $category = Category::select('id', 'uuid','name')->orderBy('name', 'ASC')
                ->get();
            $optionValue = '';
            $optionValue .= "<option value='all' class='select-all'>All Service Category </option>";
            foreach ($category as $row)
            {
                $selected = in_array($row->id, $edit_category)? 'selected': '';
                $optionValue .= "<option value='$row->id'  $selected >$row->name</option>";
            }

            $data = array(
                'category' => $optionValue
            );
        }
        return response()->json($data);

    }


    public function categoryServicesEdit(Request $request)
    {
        if ($request->ajax())
        {
            // dd($request->data);
            // $data = json_decode($request->form);
            parse_str($request->form, $fields);
            // dd($fields);
            $services = json_decode($fields['edit_services'][0]);
            $category =  json_decode($fields['edit_category'][0]);
            // $category = explode(" ",  $category);
            $service = []; 
            if (in_array("all", $category))
            {
                $service = Service::select('id', 'name')->orderBy('name', 'ASC')
                    ->get();
            }
            else
            {
                $service = Service::select('id', 'name')->whereIn('category_id', $category)
                    ->orderBy('name', 'ASC')
                    ->get();
            }
            $optionValue = '';
            $optionValue .= "<option value='all-services' class='select-all'>All services </option>";
            foreach ($service as $row)
            {
                $selected = in_array($row->id, $services)? 'selected': '';
                $optionValue .= "<option value='$row->id' $selected >$row->name</option>";
            }
            $data = array(
                'service' => $optionValue
            );
        }

        return response()->json($data);
    }


    public function discountUsersEdit(Request $request)
    {
        if ($request->ajax())
        {
            $wh = $d = [];
            $groupby = '';
            $replace_amount = 'middle_name';
            $replace_user = 'user_id';
            parse_str($request->data['form'], $fields);
            $entity = $fields['entity'];
            $replace_value = 'user_id';
            $edit_users = json_decode($fields['edit_users'][0]);   
         
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
                        $selected = in_array($row->user_id, $edit_users)? 'selected': '';
                        $optionValue .= "<option value='$row->user_id' $selected >$name</option>";
                  
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
                        $selected = in_array($row->uuid, $edit_users)? 'selected': '';
                        $optionValue .= "<option value='$row->uuid' $selected >$name</option>";
                    }

                    $data = array(
                        'options' => $optionValue
                    );

                break;
                default:
                    # code...
                    $data=[]; 
                break;
            }
            return response()->json($data);

        }
    }

    public function editDiscount(Request $request)
    {

        $this->validateRequestEdit($request);

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
        
         $discount = Discount::where('uuid', $request->discount_id)->update([
        'name' => $request->input('discount_name') ,
          'entity' => $request->input('entity') , 
          'notify' => $request->input('notify') ,
           'rate' => $request->input('rate') ,
            'duration_start' => $request->input('start_date') , 
            'duration_end' => $request->input('end_date') , 
            'description' => $request->input('description') ,
            'parameter' => json_encode($parameterArray) ,
            'created_by' => Auth::user()->email,

            ]);

            if ($discount)
            {
    
                switch ($entity)
                {
                    case 'user':
                        $update = $this->updateUsersDiscount($request,  $discount);
                    break;
                    case 'estate':
                        if (empty($request->estate_name))
                        {
                          
                            $update = $this->updateEstateTypeUsersDiscount($request, $discount ,$estate_name='');
                        }
                        else
                        {
                           
                            $update = $this->updateEstateTypeUsersDiscount($request,   $discount, $request->estate_name);
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
                $message = Auth::user()->email . ' Updated discount' . $request->input('discount_name');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.discount_list', app()
                    ->getLocale())
                    ->with('success', 'Discount updated successfully');
    
            }
            else
            {
                $type = 'Errors';
                $severity = 'Error';
                $actionUrl = Route::currentRouteAction();
                $message = 'An Error Occured while ' . Auth::user()->email . ' was trying to update ' . $request->input('discount_name');
                $this->log($type, $severity, $actionUrl, $message);
                return redirect()->route('admin.discount_list', app()
                    ->getLocale())
                    ->with('error', 'An error occurred');
    
            }
    
        }
 



    private function validateRequestEdit($request)
    {
        if($request->entity == 'service'){
           
            return request()->validate(['discount_name' => 'required|max:250', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'category' =>  'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);
        }else{
            return request()->validate(['discount_name' => 'required|max:250', 'entity' => 'required', 'rate' => 'required', 'start_date' => 'required', 'users' => 'required|array|min:1', 'end_date' => 'required', 'description' => 'max:250']);

        }
    }




    private function updateUsersDiscount($request, $discounts)
    {
        $allusers = [];
        $old_users = [];
        $clients = ClientDiscount::select('*')->where('discount_id', $request->discount_id)->get();
       //get previous client discount users

        foreach ($clients as $client){
            $allusers[]= $client->user_id;
            if(!in_array($client->user_id, $request->users)){
                $old_users [] = $client->user_id;
            }
           
        }
      //filter old client discount users to update the new client discount users
   
        foreach ($request->users as $user)
        {   
         
            if(in_array($user, $allusers))   {
                $discount = ClientDiscount::where(['user_id'=>$user,'discount_id'=>$request->discount_id])->update([
                    'discount_name' => $request->input('discount_name') ,
                    'entity' => $request->input('entity') , 
                    'notify' => $request->input('notify') ,
                    'rate' => $request->input('rate') ,
                    'status' => 'activate'
                ]);
            } else{
                $discount = ClientDiscount::create([
                    'discount_id' => $request->discount_id,
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
      
        }

        foreach ($old_users as $user)
        { 
            $discount = ClientDiscount::where(['user_id'=> $user, 'discount_id'=>$request->discount_id])->delete();
        }

        return true;
    }


    
 

    private function updateEstateTypeUsersDiscount($request, $discounts, $type)
    {
        $allusers = [];
        $old_users = [];
        $clients = ClientDiscount::select('*')->where('discount_id', $request->discount_id)->get();
     
       //get previous client discount users
        foreach ($clients as $user)
        { 
            $discount = ClientDiscount::where([ 'discount_id'=>$request->discount_id])->delete();
        }
        foreach ($request->users as $user)
        {   
           $discount = ClientDiscount::create([
                    'discount_id' => $request->discount_id,
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
            
       return $discount;
    }



    private function updateEstateHistory($request, $discounts)
    {
    
        $discount = EstateDiscountHistory::where(['discount_id'=>$request->discount_id])->update([
        'discount_id' => $request->discount_id,
        'name' => $request->input('discount_name'),
        'estate_name' => $request->input('estate_name')? $request->input('estate_name') : 'all user',
        'notify' => $request->input('notify') ,
        'rate' => $request->input('rate') ,
        'duration_start' => $request->input('start_date') ,
        'duration_end' => $request->input('end_date') , 
        'created_by' => Auth::user()->email, 
       
         ]);

    }




    private function updateServiceDiscount($request, $discounts)
    {     
        $allservices = [];
        $old_services = [];
       
        $services = ServiceDiscount::select('*')->where('discount_id', $request->discount_id)->get();
       //get previous service discount users

        foreach ($services as $service){
            $allservices[]=  $service->uuid;
            if(!in_array($service->uuid, $request->services)){
                $old_users [] = $service->uuid; // to delete services not inside updated request
            }          
        }
     
     //get update request service uuid
        $all_services = Service::select('uuid')->whereIn('id', $request->services)->get(); 
     //loop new service request
        foreach ($all_services as $service)
        {                     
        
        if(in_array($service,  $allservices))   {
            $discount = ServiceDiscount::where(['service_id'=>$service,'discount_id'=>$request->discount_id])->update([
            'discount_name' => $request->input('discount_name') ,
            'entity' => $request->input('entity') , 
            'notify' => $request->input('notify') ,
            'rate' => $request->input('rate') ,
            'status' => 'activate',
            'service_id'=> $service->uuid
            ]);
        } else{
            $service = ServiceDiscount::create([
            'discount_id' => $request->discount_id,
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

    }
    foreach ($old_services as $service)
    { 
        $discount = ServiceDiscount::where(['service_id'=> $service, 'discount_id'=>$request->discount_id])->delete();
    } 
        return true;
    }

    private function updateAllServiceDiscount($request, $discounts)
    {       
        $allservices = [];
        $old_services = [];
   
        $prev_services = ServiceDiscount::select('service_id')->where('discount_id', $request->discount_id)->get();
        $all_categories = Category::select('*')->whereIn('id',  $request->category)->get()->toArray();
        $all_services = Service::select('uuid')->whereIn('category_id', $request->category)->get();
        //get previous service discounts 
    
        foreach ($prev_services as $service){
            $allservices[]=  $service->service_id;
            //check if old service has updated category uuid 
            if(!in_array($service->uuid,  $all_categories)){
                $old_services  [] = $service->service_id;
            }
           
        }
      
        //loop new service request
        foreach ($all_services as $service)
        {                     
        
        if(in_array($service,  $allservices))   {
            $discount = ServiceDiscount::where(['service_id'=>$service,'discount_id'=>$request->discount_id])->update([
            'discount_name' => $request->input('discount_name') ,
            'entity' => $request->input('entity') , 
            'notify' => $request->input('notify') ,
            'rate' => $request->input('rate') ,
            'status' => 'activate',
            'service_id'=> $service->uuid
            ]);
        } else{
            $service = ServiceDiscount::create([
            'discount_id' => $request->discount_id,
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
  
    }
    foreach ($old_services as $service)
    { 
        $discount = ServiceDiscount::where(['service_id'=> $service, 'discount_id'=>$request->discount_id])->delete();
    } 
        return true;
    }


 

}

