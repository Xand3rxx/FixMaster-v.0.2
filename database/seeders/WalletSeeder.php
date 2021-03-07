<?php

namespace Database\Seeders;

use App\Models\WalletTransaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $walletRefund = new WalletTransaction();
        $walletRefund->user_id = 25;
        $walletRefund->wallet_id= 362212;
        $walletRefund->service_request_id= 1;
        $walletRefund->payment_type= 1; //1 is wallet, 2 is others means of payment
        $walletRefund->payment_gateway= 1; //1 is Paystack, 2 is others
        $walletRefund->reference_no= Str::random(6);
        $walletRefund->amount = '3000';
        $walletRefund->firstname = 'Patrick';
        $walletRefund->lastname = 'Smith';
        $walletRefund->email = 'pato@gmail.com';
        $walletRefund->phone = '07089782341';
        $walletRefund->opening_balance = '2000';
        $walletRefund->closing_balance = '1';
        $walletRefund->status = 'Cancel';
        $walletRefund->save();

        $walletRefund = new WalletTransaction();
        $walletRefund->user_id = 35;
        $walletRefund->wallet_id= 343212;
        $walletRefund->service_request_id= 2;
        $walletRefund->payment_type= 1; //1 is wallet, 2 is others means of payment
        $walletRefund->payment_gateway= 1; //1 is Paystack, 2 is others
        $walletRefund->reference_no= Str::random(6);
        $walletRefund->amount = '4000';
        $walletRefund->firstname = 'Chris';
        $walletRefund->lastname = 'John';
        $walletRefund->email = 'oponku@gmail.com';
        $walletRefund->phone = '07085682341';
        $walletRefund->opening_balance = '4000';
        $walletRefund->closing_balance = '2';
        $walletRefund->status = '3';
        $walletRefund->save();

        $walletRefund = new WalletTransaction();
        $walletRefund->user_id = 25;
        $walletRefund->wallet_id= 356412;
        $walletRefund->service_request_id= 3;
        $walletRefund->payment_type= 1; //1 is wallet, 2 is others means of payment
        $walletRefund->payment_gateway= 1; //1 is Paystack, 2 is others
        $walletRefund->reference_no= Str::random(6);
        $walletRefund->amount = '6000';
        $walletRefund->firstname = 'Steve';
        $walletRefund->lastname = 'Bolanle';
        $walletRefund->email = 'steveb@gmail.com';
        $walletRefund->phone = '0708978001';
        $walletRefund->opening_balance = '8000';
        $walletRefund->closing_balance = '3';
        $walletRefund->status = '3';
        $walletRefund->save();

        $walletRefund = new WalletTransaction();
        $walletRefund->user_id = 25;
        $walletRefund->wallet_id= 356412;
        $walletRefund->service_request_id= 3;
        $walletRefund->payment_type= 1; //1 is wallet, 2 is others means of payment
        $walletRefund->payment_gateway= 1; //1 is Paystack, 2 is others
        $walletRefund->reference_no= Str::random(6);
        $walletRefund->amount = '6000';
        $walletRefund->firstname = 'Steve';
        $walletRefund->lastname = 'Bolanle';
        $walletRefund->email = 'steveb@gmail.com';
        $walletRefund->phone = '0708978001';
        $walletRefund->opening_balance = '8000';
        $walletRefund->closing_balance = '3';
        $walletRefund->status = '1';
        $walletRefund->save();

    }
}
