<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Review;
use App\Models\Rating;
use App\Models\ServiceRequest;

class RatingController extends Controller
{
    /**
     * Handle Ratings
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handleRatings(Request $request)
    {
        dd($request->all());
        (array) $valid = $this->validateRatingsRequest($request);
    //return $request->clientStar."<br>".$request->getClient."<br>".$request->star."<br>".$request->usersIdentity."<br>".$request->serviceRequestId;
        return self::store($request);
    }

    public function handleServiceRatings(Request $request)
    {
        ServiceRequest::where('id', $request->serviceRequestId)->first()->update(['has_cse_rated' => 'Skipped']);
        //return back()->withSuccess('Thank you for rating the request');

        return response()->json("Yea, It is updated");

    }

    protected static function store(Request $request){

          //if(!empty($valid['review'])){
        Rating::create([
                  'user_id' => Auth::id(),
                  'ratee_id' => $request->getClient,
                  'service_request_id' => $request->serviceRequestId,
                  'star' => $request->clientStar,
              ]);
            //   Review::create([
            //     'user_id' => $request->user->id,
            //     'service_id' => $valid['cse_id'],
            //     'review' => $valid['review'],
            // ]);
          ServiceRequest::where('id', $request->serviceRequestId)->first()->update(['has_cse_rated' => 'Yes']);
            return back()->withSuccess('Thank you for rating the request');
         // }

    }

    /**
     * Validate the ratings request
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateRatingsRequest(Request $request)
    {
        return $this->validate($request,[
            //'review' => 'required|max:255',
            //'star' => 'required|numeric',
            //'cse_id' => 'required|numeric',
            //'users' => 'required|numeric',
            'clientStar' => 'required|numeric',
            'client' => 'required',
            'serviceRequestId' => 'required|numeric'
        ], [
            //'review.required' => 'Review field can not be empty',
            //'star.required' => 'Star field can not be empty',
            //'cse_id.required' => 'Star field can not be empty',
            //'star1.required' => 'Star1 field can not be empty',
            //'clientStar.required' => ''
        ]);
    }

    public function getServiceRatings(Request $request){
        $resviceRatings = Rating::where('service_id', '!=', null)
        ->where('service_diagnosis_by', null)->get();
        return view('admin.ratings.service_rating', compact('resviceRatings'));
    }


}
