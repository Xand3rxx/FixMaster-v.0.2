<?php 

namespace App\PaymentServices;
use GuzzleHttp\Client;

class Paystack {
    public function __construct() {
        return "construct function was initialized.";
    }

    
    public function reQuery(Request $request, $transactionReference)
    {
           
          //dd($user->email);
          /*$url= 'https://api.paystack.co/transaction/verify/'. $transactionReference;
          
          $client = new Client();
           
          $response = $client->request('GET', $url, [
            'headers' => [
             'Content-Type' => 'application/json',
              'Authorization' => 'Bearer sk_test_b612f25bd992c4d84760e312175c7515336b77fc',
            ],
            'body' => json_encode([
                'customer' => '233########',
                'plan' => 'PLN_###########',
          ])
     ]);
           dd($response->getBody());
           dd($response->getBody()->getContents());
         
        }*/
$reference = $_GET['reference'];

  if($refeference == "")
  {
  header("Location:javascript:history.go(-1)");
  }
    $curl = curl_init();
  
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.paystack.co/transaction/verify/. $reference",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
      "Authorization: Bearer sk_test_b612f25bd992c4d84760e312175c7515336b77fc",
      "Cache-Control: no-cache",
    ),
  ));
  
  $response = curl_exec($curl);
  $err = curl_error($curl);
  curl_close($curl);
  
  if ($err) {
    echo "cURL Error #:" . $err;
  } else {
    //echo $response;
    $result = json_decode($response);
  }
  if($result->data->status == 'success')
  {
    $status = $result->data->status;
    $reference = $result->data->reference;
    $amount = $result->data->amount;
    $transaction_date = $result->data->transaction_date;
    $firstname = $result->data->customer->first_name;
    $lastname = $result->data->customer->last_name;
    $fullname = $firstname.' '.$lastname;
    $email = $result->data->customer->email;
    date_default_timezone_set('Africa/Lagos');
    $datetime = date('m/d/Y h:i:s', time());
    //dd($response->getBody()->getContents());
  }
  else{
    header("Location:javascript:history.go(-1)");
  }

}

}
