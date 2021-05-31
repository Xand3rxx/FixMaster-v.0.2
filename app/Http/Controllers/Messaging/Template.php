<?php

namespace App\Http\Controllers\Messaging;

use Throwable;
use App\Helpers\EnumHelper;
use Illuminate\Http\Request;
use App\Models\MessageTemplate;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;


class Template extends Controller
{
    public function getMessageModules()
    {
        $enumHelper = new EnumHelper();
        return $enumHelper->getPossibleEnumValues ('feature', 'message_templates');

    }

    public function getAllTemplates()
    {
        return MessageTemplate::select('id', 'uuid','title', 'type', 'feature')->paginate(10);
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
            $type = $request->input('message_type');
            $template = MessageTemplate::select('*')
                        ->where('feature', $feature)
                        ->where('type', $type)
                        ->first();
            if(!empty($template)){
                return response()->json(["message" => "There is already a template for this feature!"], 400);
            }

            MessageTemplate::create(['title'=>$title, 'content'=>$content, 'type'=>$type, 'feature'=>$feature]);
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
        $type = $request->input('message_type');

        $template = MessageTemplate::updateOrCreate(
            ['feature'=> $feature, 'type'=> $type],
            ['title' => $title, 'content' => $content]
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
}
