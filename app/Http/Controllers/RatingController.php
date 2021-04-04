<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        //dd($request->all());
        (array) $valid = $this->validateRatingsRequest($request);
    //return $request->clientStar."<br>".$request->getClient."<br>".$request->star."<br>".$request->usersIdentity."<br>".$request->serviceRequestId;
        return self::store($valid, $request->user()->id);
    }

    public function handleServiceRatings(Request $request)
    {
        ServiceRequest::where('id', $request->serviceRequestId)->first()->update(['has_cse_rated' => 'Skipped']);
        //return back()->withSuccess('Thank you for rating the request');

        return response()->json("Yea, It is updated");

    }

    protected static function store(array $valid, int $user_id){

          //if(!empty($valid['review'])){
        foreach ($valid['users_id'] as $key => $user) {
            Rating::create([
                'user_id' => $user_id,
                'ratee_id' => $user,
                'service_request_id' => $valid['serviceRequestId'],
                'star' => $valid['users_star'][$key],
            ]);
        }

            //   Review::create([
            //     'user_id' => $request->user->id,
            //     'service_id' => $valid['cse_id'],
            //     'review' => $valid['review'],
            // ]);
          ServiceRequest::where('id', $valid['serviceRequestId'])->first()->update(['has_cse_rated' => 'Yes']);
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
           // 'review' => 'required|max:255',
            'client_star' => 'required|numeric|between:1,5',
            'client_id' => 'required|numeric',
            'users_id' => 'required|array',
            'users_id.*' => 'required|numeric',
            'users_star' => 'required|array',
            'users_star.*' => 'required|numeric|between:1,5',
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
