<?php
namespace App\Helpers;
use Carbon\Carbon;
use App\Models\LoyaltyManagement;

class CustomHelpers
{
    static function displayTime($start, $end)
    {
        $date = Carbon::parse($start);
        $diff = $date->diffForHumans($end, true);
        return $diff;
    }

    
    function generateRandomNumber() {
        // $number = mt_rand(1000000000, 9999999999); // better than rand()

        // Available alpha caracters
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

        // generate a pin based on 2 * 7 digits + a random character
        $pin = mt_rand(1000000, 9999999)
            . mt_rand(1000000, 9999999)
            . $characters[rand(0, strlen($characters) - 1)];

        // shuffle the result
        $string = str_shuffle($pin);
        // dd($randomString);
    
        // call the same function if the barcode exists already
        if (checkIfStringExists($randomString)) {
            return generateRandomNumber();
        }
    
        // otherwise, it's valid and can be used
        return $string;
    }
    
    // function checkIfStringExists($randomString) {
    //     return User::whereRandomNumber($number)->exists();
    // }


    static function ifLoyaltyExist($user)
    {
        $loyaltyExist = LoyaltyManagement::select('client_id')->where('client_id', $user)->get();
        if(count($loyaltyExist) > 0){
            return 1;
        }else{
            return 0;
        }
       
    }


    
}
?>
