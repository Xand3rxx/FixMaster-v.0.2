<?php

namespace App\Http\Controllers\Admin\Prospective;

use App\Models\Applicant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CSEController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.prospective.cse.index')->with([
            'users' => Applicant::where('user_type', Applicant::USER_TYPES[0])->get(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, string $uuid)
    {
        return view('admin.prospective.cse.show', [
            'user' => Applicant::where('uuid', $uuid)->firstOrFail()
        ]);
    }

    /**
     * Handling of CSE Application Decision
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function decision(Request $request)
    {
        (array)$decision = $request->validate([
            'decision' => 'required|string|in:approve,decline',
            'user' => 'required|uuid|exists:applicants,uuid'
        ]);
        return $this->handleDecision($decision)
            ? redirect()->route('admin.prospective.cse.index', app()->getLocale())->with('success', 'Application Decision Recorded')
            : back()->with('error', 'Error Occured Updating Application Decision');
    }

    /**
     * Handling of CSE Application Decision
     *
     * @param  string  $decision
     * @return bool
     */
    protected function handleDecision(array $decision)
    {
        switch ($decision['decision']) {
            case 'approve':
                # code...
                return Applicant::where('uuid', $decision['user'])->update(['status' =>  Applicant::STATUSES[1]]);
                break;

            case 'decline':
                # code...
                return Applicant::where('uuid', $decision['user'])->update(['status' =>  Applicant::STATUSES[2]]);
                break;

            default:
                return false;
                break;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  string $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
