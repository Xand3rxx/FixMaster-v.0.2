<?php

namespace App\Http\Controllers\Admin\User\Administrator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SummaryController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  string  $language
     * @return \Illuminate\Http\Response
     */
    public function show($language, \App\Models\User $user)
    {
        // dd($user, 'hee');
        return view('admin.users.administrator.summary.show', ['user' => $user]);
    }
}
