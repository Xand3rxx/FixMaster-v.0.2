<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use App\Models\PaymentDisbursed;

class PaymentDisbursedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payments_disbursed')->delete();

        PaymentDisbursed::create(
            [
                'user_id'               =>  1,
                'recipient_id'          =>  4,
                'service_request_id'    =>  1,
                'payment_mode_id'          =>  1,
                'payment_reference'     =>  '239482347372',
                'amount'                =>  1500,
                'payment_date'          =>  '2020-12-31',
                'comment'               =>  'No comment',
                'created_at'            =>  '2021-01-06 19:53:37',
                'updated_at'            =>  NULL
            ]);

            PaymentDisbursed::create(
            [
                'user_id'               =>  1,
                'recipient_id'          =>  5,
                'service_request_id'    =>  2,
                'payment_mode_id'          =>  3,
                'payment_reference'     =>  '898582347097',
                'amount'                =>  1500,
                'payment_date'          =>  '2021-01-09',
                'comment'               =>  'Payment for additional supervison',
                'created_at'            =>  '2021-01-06 19:53:37',
                'updated_at'            =>  NULL
            ]);

        PaymentDisbursed::create(
            [
                'user_id'               =>  1,
                'recipient_id'          =>  4,
                'service_request_id'    =>  3,
                'payment_mode_id'          =>  2,
                'payment_reference'     =>  '239482347372',
                'amount'                =>  8000,
                'payment_date'          =>  '2021-02-31',
                'comment'               =>  'No comment',
                'created_at'            =>  '2021-01-06 19:53:37',
                'updated_at'            =>  NULL
            ]);

        //     PaymentDisbursed::create(
        //         [
        //             'user_id'               =>  1,
        //             'recipient_id'          =>  4,
        //             'service_request_id'    =>  3,
        //             'payment_mode_id'          =>  2,
        //             'payment_reference'     =>  '239482347372',
        //             'amount'                =>  1900,
        //             'payment_date'          =>  '2021-01-17',
        //             'comment'               =>  'No comment',
        //             'created_at'            =>  '2021-01-06 19:53:37',
        //             'updated_at'            =>  NULL
        //         ]);

        //         PaymentDisbursed::create(
        //             [
        //                 'user_id'               =>  1,
        //                 'recipient_id'          =>  4,
        //                 'service_request_id'    =>  3,
        //                 'payment_mode_id'          =>  2,
        //                 'payment_reference'     =>  '239482347372',
        //                 'amount'                =>  40000,
        //                 'payment_date'          =>  '2021-02-24',
        //                 'comment'               =>  'No comment',
        //                 'created_at'            =>  '2021-01-06 19:53:37',
        //                 'updated_at'            =>  NULL
        //             ]);

        //             PaymentDisbursed::create(
        //                 [
        //                     'user_id'               =>  1,
        //                     'recipient_id'          =>  4,
        //                     'service_request_id'    =>  2,
        //                     'payment_mode_id'          =>  2,
        //                     'payment_reference'     =>  '239482347372',
        //                     'amount'                =>  20500,
        //                     'payment_date'          =>  '2021-02-10',
        //                     'comment'               =>  'No comment',
        //                     'created_at'            =>  '2021-01-06 19:53:37',
        //                     'updated_at'            =>  NULL
        //                 ]);

        //                 PaymentDisbursed::create(
        //                     [
        //                         'user_id'               =>  1,
        //                         'recipient_id'          =>  4,
        //                         'service_request_id'    =>  2,
        //                         'payment_mode_id'          =>  2,
        //                         'payment_reference'     =>  '239482347372',
        //                         'amount'                =>  6500,
        //                         'payment_date'          =>  '2021-03-10',
        //                         'comment'               =>  'No comment',
        //                         'created_at'            =>  '2021-01-06 19:53:37',
        //                         'updated_at'            =>  NULL
        //                     ]);

        //                     PaymentDisbursed::create(
        //                         [
        //                             'user_id'               =>  1,
        //                             'recipient_id'          =>  4,
        //                             'service_request_id'    =>  1,
        //                             'payment_mode_id'          =>  2,
        //                             'payment_reference'     =>  '239482347372',
        //                             'amount'                =>  9500,
        //                             'payment_date'          =>  '2021-03-01',
        //                             'comment'               =>  'No comment',
        //                             'created_at'            =>  '2021-01-06 19:53:37',
        //                             'updated_at'            =>  NULL
        //                         ]);

        //                         PaymentDisbursed::create(
        //                             [
        //                                 'user_id'               =>  1,
        //                                 'recipient_id'          =>  4,
        //                                 'service_request_id'    =>  2,
        //                                 'payment_mode_id'          =>  2,
        //                                 'payment_reference'     =>  '239482347372',
        //                                 'amount'                =>  2500,
        //                                 'payment_date'          =>  '2021-01-31',
        //                                 'comment'               =>  'No comment',
        //                                 'created_at'            =>  '2021-01-06 19:53:37',
        //                                 'updated_at'            =>  NULL
        //                             ]);

        //                             PaymentDisbursed::create(
        //                                 [
        //                                     'user_id'               =>  1,
        //                                     'recipient_id'          =>  4,
        //                                     'service_request_id'    =>  3,
        //                                     'payment_mode_id'          =>  2,
        //                                     'payment_reference'     =>  '239482347372',
        //                                     'amount'                =>  9000,
        //                                     'payment_date'          =>  '2021-02-16',
        //                                     'comment'               =>  'No comment',
        //                                     'created_at'            =>  '2021-01-06 19:53:37',
        //                                     'updated_at'            =>  NULL
        //                                 ]);
   }
}
