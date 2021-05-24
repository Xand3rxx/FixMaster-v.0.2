<?php

namespace App\Traits;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Config;


trait SendVerificationMail
{

    /**
     * Send Email Verification to User Account Instance
     *
     * @param  \App\Models\Account $account
     * 
     * @return void
     */
    protected function sendVerificationEmail(\App\Models\Account $account)
    {
        (string)$url = $this->url($account->user);

        $messanger = new \App\Http\Controllers\Messaging\MessageController();
        // $user this is the instance of the created applicant
        $mail_data = "<h1> Hello, " . $account['first_name'] . " " . $account['last_name'] . "</h1> <br> <p> Thank you for registering with us, Kind use this link " . $url . " to verify your account. </p>";
        return $messanger->sendNewMessage('mail', 'Verify Email Address', 'dev@fix-master.com', $account->user->email, $mail_data);
    }

    /**
     * Get the verification URL for the given user.
     *
     * @param  \App\Models\User $user
     * @return string
     */
    public function url(\App\Models\User $user)
    {
        return $this->verificationUrl($user);
    }

    /**
     * Get the verification URL for the given user.
     *
     * @param  \App\Models\User $user
     * @return string
     */
    protected function verificationUrl($user)
    {
        return URL::temporarySignedRoute(
            'verification.verify',
            Carbon::now()->addMinutes(Config::get('auth.verification.expire', 60)),
            [
                'id' => $user->uuid,
                'hash' => sha1($user->email),
                'locale' => app()->getLocale()
            ]
        );
    }
}
