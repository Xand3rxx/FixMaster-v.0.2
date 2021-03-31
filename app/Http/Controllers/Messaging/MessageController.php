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
use Illuminate\Support\Carbon;
use App\Traits\Loggable;
use Mail;
use Route;
use Auth;

class MessageController extends Controller
{
    use Loggable;
  
    public function getInbox(Request $request)
    {
        $emails = DB::table('messages')
            ->join('accounts', 'messages.sender', '=', 'accounts.user_id')
            ->orderBy('messages.created_at', 'DESC')
            ->select('messages.*', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->where('messages.recipient',  $request->input('userid'))
            ->get();
       
            if(!empty($emails)){
                return response()->json(["data" => $emails], 200);
             }
             return response()->json(["message" => "Inbox is empty!"], 404);
     
    }

    public function getOutBox(Request $request)
    {
      
        $emails = DB::table('messages')
            ->join('accounts', 'messages.recipient', '=', 'accounts.user_id')
            ->orderBy('messages.created_at', 'DESC')
            ->select('messages.*', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->where('messages.sender', $request->input('userid'))
            ->get();
        
            if(!empty($emails)){
                return response()->json(["data" => $emails], 200);
             }
             return response()->json(["message" => "Inbox is empty!"], 404);
     
    }

    public function getMessage(Request $request)
    {
       $message_id = $request->input('message_id');
        $email = DB::table('messages')
            ->join('accounts', 'messages.recipient', '=', 'accounts.user_id')
            ->where('messages.uuid', $message_id)
            ->select('messages.*', 'accounts.first_name',  'accounts.last_name', 'accounts.middle_name')
            ->first();
        
        $message = Message::find($email->id);  
        $message->mail_status = 'read';
        $message->save();
            if(!empty($email)){
                return response()->json(["data" => $email], 200);
             }
             return response()->json(["message" => "Message is empty!"], 404);
     
    }

    public function saveEmail(Request $request)
    {
        $subject = $request->input('subject');
        $recipients = $request->input('recipients');
        $sender =  $request->input('sender');
        $mail_content = $request->input('mail_content');
        $mail_objects = [];
        $userIds = [];
        $receivers = [];

        foreach($recipients as $recipient){
            array_push($receivers, $recipient['value']);
        }

        $ids = DB::table('user_types')
        ->whereIn('role_id', $receivers )
        ->select('user_id')
        ->get();
       
        foreach($ids as $id){
            array_push($userIds, $id);
        }
       

      
        foreach($userIds as $id){
            $mail_objects[] = [
                'title'=>$subject, 
                'content'=>$mail_content, 
                'recipient'=>$id->user_id, 
                'sender'=>$sender,
                'uuid'=>Str::uuid()->toString(),
                'created_at'        => Carbon::now(),
                'updated_at'        => Carbon::now(),
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
