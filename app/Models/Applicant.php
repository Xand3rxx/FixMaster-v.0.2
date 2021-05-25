<?php

namespace App\Models;

use App\Http\Controllers\Messaging\MessageController;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Applicant extends Model
{
    use SoftDeletes;

    const USER_TYPES = ['cse', 'supplier', 'technician'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'form_data' => 'array',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Status is to be created
        static::creating(function ($applicant) {
            $applicant->uuid = (string) \Illuminate\Support\Str::uuid();
        });

        static::created(function ($applicant) {
            // $applicant this is the instance of the created applicant
            $messanger = new MessageController();
            // $mail_data = "<h1> Hello, " . $applicant->form_data['last_name_cse'] . " " . $applicant->form_data['first_name_cse'] . "</h1> <br> <p> Thank you for registering with us, we would review your application and respond as soon as possible. </p>";
            // $jsonResponse = $messanger->sendNewMessage('mail', 'Customer Service Executive Applicant Registration', 'dev@fix-master.com', $applicant->form_data['email_cse'], $mail_data);
            // This is when i need to send a mail to the applicant that his application is submitted successfully!
            $mail_data = collect([
                'lastname' => $applicant->form_data['last_name_cse'],
                'firstname' => $applicant->form_data['first_name_cse'],
                'email' => $applicant->form_data['email_cse'],
            ]);
            $response = $messanger->sendNewMessage('email', 'Customer Service Executive Applicant Registration', 'dev@fix-master.com', $applicant->form_data['email_cse'], $mail_data, 'CSE_ACCOUNT_CREATION_NOTIFICATION');
            // dd($response);
        });
    }
}
