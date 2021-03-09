<?php


namespace App\Http\Controllers\Messaging;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\User;
use App\Models\UserType;
use App\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Traits\Loggable;
use Mail;
use Route;
use Auth;

class MessageController extends Controller
{
    use Loggable;
  
    public function mailList()
    {
       
        $emails = Message::select("*")
            ->orderBy('created_at', 'DESC')
            ->get();

            if(!empty($emails)){
                return response()->json(["data" => $emails], 200);
             }
             return response()->json(["message" => "Inbox is empty!"], 404);
     
    }

    public function saveEmail(Request $request)
    {
        $userRoles = $this->userRoles()->pluck('name');
        $subject = $request->input('subject');
        $recipients = $request->input('recipients');
        $sender =  $request->input('sender');
        $mail_content = $request->input('mail_content');
        $mail_objects = [];
        $userIds = [];
        foreach($recipients as $recipient){
            if (in_array($recipient['name'], (array) $userRoles)){
                $ids = DB::table('users')
                            ->join('user_types', 'users.id', '=', 'user_types.user_id')
                            ->where('user_types', $recipient['value'] )
                            ->select('users.id');
            
                foreach($ids as $id){
                    array_push($userIds, $id);
                }
            }else{
                array_push($userIds, $recipient['value']);
            }   
        }

        foreach($userIds as $id){
            $mail_objects[] = [
                'title'=>$subject, 
                'content'=>$mail_content, 
                'recipient'=>$id, 
                'sender'=>$sender,
                'uuid'=>Str::uuid()->toString()
            ];
        }
        Message::insert($mail_objects);
        return response()->json([
            "message" => "Messages sent successfully!"], 201);
    }

    public function sendEmail(Request $request)
    {
        
        $subject = $request->input('subject');
        $to = $request->input('recipient');
        $mail_data = $request->input('mail_data');

        $message = $this->replacePlaceHolders($mail_data, $template->content);
        Mail::send('emails.message', ['mail_message' => $message], function ($m) use ($to, $subject) {
            $m->from('admin@fixmaster.com', $subject);

            $m->to($to, $to)->subject($subject);
        });
    }

    private function replacePlaceHolders($variables, $messageTemp){
        foreach($variables as $key => $value){
            $messageTemp = str_replace('{'.$key.'}', $value, $messageTemp);
        }

        return $messageTemp;
    }

    public function userRoles(){
        return Role::all();
    }
    
}
