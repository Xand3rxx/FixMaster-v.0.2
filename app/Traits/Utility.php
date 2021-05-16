<?php

namespace App\Traits;

use App\Models\User;
use App\Models\Client;
use App\Models\Cse;
use App\Models\Account;
use App\Models\Referral;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailNotify;
use App\Mail\WarrantyNotify;
use App\Traits\GenerateUniqueIdentity as Generator;
use Session;
use Auth;
use DB;

trait Utility
{
  use Generator;

  public function entityArray()
  {
    $objects = [];
    $names = ['Client', 'Service', 'Estate'];
    for ($i = 0; $i < Count($names); $i++) {
      $objects[] = (object)["id" => $i + 1, "name" => $names[$i],];
    }

    return $objects;
  }

  public function filterEntity($request)
  {
    $user = '';
    if ($request->entity != 'service') {
      $user = array_filter($request->users);
    }
    if ($request->entity == 'service') {
      if (isset($request->services)) {
        $user = array_filter($request->services);
      }
      if (isset($request->category) && !isset($request->services)) {
        $user = array_filter($request->category);
      }
    }
    return $user;
  }

  public function updateVerifiedUsers($user, $user_type = '')
  {

    if ($user->email_verified_at == NULL) {
       return false;
    }

    $type = $user_type != '' ? $user_type : $user
      ->type->url;
    $created_by = $user_type != '' ? Auth::user()->email : $user->email;
    $mail = '';

    //updates firsttime  on users table to if user is not firsttime login
    switch ($type) {
      case 'client':


        $referral = '';
        $client = Client::select('firsttime')->where('account_id', $user->id)
          ->first();

          if ($user->email_verified_at != NULL && $client->firsttime == 1) {
            return false;
           }

        if ($user->email_verified_at != NULL && $client->firsttime == 0) {

          $code = $this->generate('referrals', 'ClI-', 'referral_code'); // Create a Unique referral code
          $ifReferrals = Referral::select('id')->where('user_id', $user->id)
            ->first();

          //check if user already has referral code
          if ($ifReferrals) {
            Referral::where('user_id', $user->id)
              ->update(['referral_code' => $code, 'created_by' => $created_by]);
            $referral = $ifReferrals->id;
          } else {
            $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $code, 'created_by' => $created_by]);
            $referral = $_referral->id;
          }

          $account = Account::where('user_id', $user->id)
            ->first();

          if ($account) {

            Client::where('account_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1,]);
            $data = (object)['firstname' => $account->first_name, 'code' => $code, 'email' => $user->email, 'type' => 'client'];
            $this->sendRefferalMail($data, $user_type, $type);
          }
        }

        if ($user_type != '' && $user->email_verified_at == NULL) {

          $code = $this->generate('referrals', 'ClI-', 'referral_code'); // Create a Unique referral code
          $ifReferrals = Referral::select('id')->where('user_id', $user->id)
            ->first();

          //check if user already has referral code
          if ($ifReferrals) {
            Referral::where('user_id', $user->id)
              ->update(['referral_code' => $code, 'created_by' => $created_by]);
            $referral = $ifReferrals->id;
          } else {
            $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $code, 'created_by' => $created_by]);
            $referral = $_referral->id;
          }

          $client = Client::where('account_id', $user->id)
            ->update(['referral_id' => $referral,]);
          $account = Account::where('user_id', $user->id)
            ->first();

          if ($account) {
            Client::where('account_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1,]);

            User::where('email', $user->email)
              ->update(['email_verified_at' => date("Y-m-d H:i:s"),]);
            $data = (object)['firstname' => $account->first_name, 'code' => $code, 'email' => $user->email, 'type' => 'client'];
            $mail = $this->sendRefferalMail($data, $user_type, $type);
            return $mail;
          }
        }


        break;
      case 'cse':
        $referral = '';

        $cse = Cse::select('firsttime')->where('account_id', $user->id)
          ->first();
          if ($user->email_verified_at != NULL && $cse->firsttime == 1) {
            return false;
           }

        if ($user->email_verified_at != NULL && $cse->firsttime == 0) {
          $unique_id = Cse::where('user_id', $user->id)
            ->first();
          if ($unique_id) {
            $ifReferrals = Referral::select('id')->where('user_id', $user->id)
              ->first();

            //check if user already has referral code
            if ($ifReferrals) {
              Referral::where('user_id', $user->id)
                ->update(['referral_code' => $unique_id->unique_id, 'created_by' => $created_by]);
              $referral = $ifReferrals->id;
            } else {
              $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $unique_id->unique_id, 'created_by' => $created_by]);
              $referral = $_referral->id;
            }
          }

          $client = Client::where('account_id', $user->id)
            ->update(['referral_id' => $referral,]);
          $account = Account::where('user_id', $user->id)
            ->first();
          if ($account) {
            Cse::where('user_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1]);
            $data = (object)['firstname' => $account->first_name, 'code' => $unique_id->unique_id, 'email' => $user->email, 'type' => 'cse'];
            $this->sendRefferalMail($data, $user_type, $type);
          }
        }

        if ($user_type != '' && $user->email_verified_at == NULL) {
          $unique_id = Cse::where('user_id', $user->id)->first();
          if ($unique_id) {
            $ifReferrals = Referral::select('id')->where('user_id', $user->id)->first();
            //check if user already has referral code
            if ($ifReferrals) {
              Referral::where('user_id', $user->id)->update([
                'referral_code' => $unique_id->unique_id,
                'created_by' => $created_by
              ]);
              $referral = $ifReferrals->id;
            } else {
              $_referral = Referral::create(['user_id' => $user->id, 'referral_code' => $unique_id->unique_id, 'created_by' => $created_by]);
              $referral = $_referral->id;
            }
          }
          Cse::where('user_id', $user->id)->update([
            'referral_id' =>  $referral,
          ]);
          $client = Client::where('account_id', $user->id)->update([
            'referral_id' => $referral,
          ]);
          $account = Account::where('user_id', $user->id)->first();
          if ($account) {
            User::where('email', $user->email)
              ->update(['email_verified_at' => date("Y-m-d H:i:s"),]);

            Cse::where('user_id', $user->id)
              ->update(['referral_id' => $referral, 'firsttime' => 1]);
            $data = (object)[
              'firstname' => $account->first_name,
              'code' => $unique_id->unique_id,
              'email' => $user->email,
              'type' => 'cse'
            ];
            $mail = $this->sendRefferalMail($data, $user_type, $type);
            return $mail;
          }
        }

        break;
      default:
        # code...
        break;
    }
    if ($mail == '1') {
      return $mail;
    }
  }

  public function sendRefferalMail($user, $user_type, $type)
  {
    $name = ucfirst($user->firstname);
    Mail::to($user->email)->send(new MailNotify($user));
    if ($user_type == '' && $type == 'client') {
      Session::flash('success', "Welcome $name, your refferal link has been sent to your mail");
    }
    if ($user_type == '' && $type == 'cse') {
      Session::flash('success', "Welcome $name, your refferal code has been sent to your mail");
    } else {
      return '1';
    }
  }

  public function authenticateRefferralLink($link)
  {
    $check = Referral::where(['referral_code' => $link, 'status' => 'activate'])->first();
    if ($check == null) {
      return false;
    }
    return $check;
  }

  public function cse_referral()
  {
    $results = $ref = [];
    $cse = Cse::select('accounts.first_name', 'accounts.last_name', 'cses.account_id', 'unique_id')->join('accounts', 'accounts.user_id', '=', 'cses.account_id')
      ->orderBy('accounts.first_name', 'ASC')
      ->get();
    $referral = Referral::select('user_id')->get()
      ->toArray();
    foreach ($referral as $value) {
      $ref[] = $value['user_id'];
    }
    foreach ($cse as $value) {
      if (!in_array($value->account_id, $ref)) {
        $results[] = $value;
      }
    }

    return $results;
  }

  public function client_referral()
  {
    $results = $ref = [];
    $clients = Client::select('accounts.first_name', 'accounts.last_name', 'clients.account_id')->join('accounts', 'accounts.user_id', '=', 'clients.account_id')
      ->orderBy('accounts.first_name', 'ASC')
      ->get();
    $referral = Referral::select('user_id')->get()
      ->toArray();
    foreach ($referral as $value) {
      $ref[] = $value['user_id'];
    }
    foreach ($clients as $value) {
      if (!in_array($value->account_id, $ref)) {
        $results[] = $value;
      }
    }

    return $results;
  }

  /* Return distinct year from a particular table's created at
  *  string  $tableName
  *  return array
  */
  public function getDistinctYears($tableName){
        //Array to
        $yearList = array();

        //Get a collection of `created_at` from $tableName
        $years = DB::table($tableName)->orderBy('created_at', 'ASC')->pluck('created_at');

        $years = json_decode($years);

        if(!empty($years)){
            foreach($years as $year){
                $date = new \DateTime($year);

                $yearNumber = $date->format('y');

                $yearName = $date->format('Y');

                array_push($yearList, $yearName);
            }
        }

        return array_unique($yearList);
  }


  public function sendWarrantyInitiationMail($user, $type)
  {
    $name = ucfirst($user->name);
    Mail::to($user->email)->send(new WarrantyNotify($user));
  }

}
