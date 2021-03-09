<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

trait ImageUpload
{
    /**
     * Does very basic image validity checking and stores it. Redirects back if an error occurs.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @param string directory
     * @return $this|false|string
     */
    public function verifyAndStoreImage(Request $request, string $imageDirectory) {
 
        if($request->hasFile('image')) {
 
            //Validate image
            if (!$request->file('image')->isValid()) {
 
                flash('Invalid Image!')->error()->important();
 
                return redirect()->back()->withInput();
            }

            //Get image file
            $image = $request->file('image');

            //Generate uuid as name appended to the image extension
            $imageName = (string) Str::uuid() .'.'.$image->getClientOriginalExtension();

            //Reduce image size and save to directory
            Image::make($image->getRealPath())->resize(350, 259)->save($imageDirectory.$imageName);

            //Return image name
            return $imageName;
 
        }
 
        return null;
 
    }
}