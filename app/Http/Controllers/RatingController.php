<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Review;
use App\Models\Rating;

class RatingController extends Controller
{
    public function store(Request $request){
        $rules = [
            'review' => 'required|max:255',
            'star' => 'required|numeric',
            'cse_id' => 'required|numeric',
            'star1' => 'required|numeric'
          ];

          $messages = [
             'review.required' => 'Review field can not be empty',
             'star.required' => 'Star field can not be empty',
             'cse_id.required' => 'Star field can not be empty',
             'star1.required' => 'Star1 field can not be empty',
          ];

          (array) $valid = $this->validate($request, $rules, $messages);

          if(!empty($valid['review'])){
              Rating::create([
                  'user_id' => $request->user->id,
                  'ratee_id' => $valid['cse_id'],
                  'role_name' > 'cse',
                  'star' => $valid['star']
              ]);

              Review::create([
                'user_id' => $request->user->id,
                'service_id' => $valid['cse_id'],
                'review' => $valid['review'],
            ]);

            return back()->withSuccess('Thank you for rating the service');
          }

    }
}
