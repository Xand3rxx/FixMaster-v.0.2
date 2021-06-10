<?php

namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\EnumHelper;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Log;


class Template extends Controller
{ 
    public function getMessageModules()
    {
        $enumHelper = new EnumHelper();
         return $enumHelper->getPossibleEnumValues('feature', 'message_templates');

    }

    public function getAllTemplates()
    {
        return MessageTemplate::select('id', 'uuid','title',  'feature')->paginate(10);
    }

    public function getTemplate($uuid)
    {
         $template = MessageTemplate::where('uuid', $uuid)->first();
        if(!empty($template)){
           return response()->json(["data" => $template], 200);
        }
        return response()->json(["message" => "Template not found!"], 404);

    }

    public function saveMessageTemplate(Request $request)
    {
        try{
            $feature = $request->input('feature');
            $title = $request->input('title');
            $content = $request->input('content');
            $sms = $request->input('sms');
            $template = MessageTemplate::select('*')
                        ->where('feature', $feature)
                        ->first();
            if(!empty($template)){
                return response()->json(["message" => "There is already a template for this feature!"], 400);
            }

            MessageTemplate::create(['title'=>$title, 'content'=>$content, 'sms'=>$sms, 'feature'=>$feature]);
            return response()->json([
            "message" => "Template created successfully!", "data"=>$template
        ], 201);
        }catch(Throwable $e){
          return response()->json([
        "message" => "Internal server error!"
    ], 500);
        }

    }

    public function updateMessageTemplate(Request $request)
    {
        try{
        $feature = $request->input('feature');
        $title = $request->input('title');
        $content = $request->input('content');
        $sms = $request->input('sms');

        $template = MessageTemplate::updateOrCreate(
            ['feature'=> $feature],
            ['title' => $title, 'content' => $content, 'sms' => $sms]
        );
        return response()->json([
        "message" => "Template updated successfully!", "data"=>$template
        ], 201);
        }catch(Throwable $e){
          return response()->json([
        "message" => "Internal server error!"
    ], 500);
        }
    }

    public function deleteMessageTemplate($uuid)
    {
        $template = MessageTemplate::where('uuid', $uuid)->first();
        if(!empty($template)){
           $template->delete();
           return response()->json(["message" => "Template deleted successfully!", "data"=>[]], 200);
        }
        return response()->json(["message" => "Template not found!"], 404);

    }


    public function see()
    {
   
      
            // $mail_data_client = collect([
            //   'email' =>  'woorad7@gmail.com',
            //   'template_feature' => 'ADMIN_CUSTOMER_PAYMENT_SUCCESSFUL_NOTIFICATION',
            //    'url' => 'fixh'
           
            // ]);
        //     $mail2 = $this->mailAction($mail_data_client);
        //  dd($mail2);
     
   
            return view('emails.message',['mail_message' => '<p>
            Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of 
</p>']);
        

    }
}
