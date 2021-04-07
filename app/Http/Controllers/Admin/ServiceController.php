<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use App\Traits\ImageUpload;
use Illuminate\Support\Str;
use Auth;
use Route;
use Image;

use App\Models\Category;
use App\Models\Service;

class ServiceController extends Controller
{
    use Loggable, ImageUpload;

    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:web');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Return all services,including inactive ones
        $services = Service::Servicies()->get();

        //Return all active categories
        $categories = Category::ActiveCategories()->get();

        $data = [
            'services'      =>  $services,
            'categories'    =>  $categories,
        ];

        return view('admin.service.index', $data)->with('i');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate user input fields
        $this->validateRequest();

        //Image storage directory
        $imageDirectory = public_path('assets/service-images').'/';

        //Validate if an image file was selected
        $imageName = $this->verifyAndStoreImage($request, $imageDirectory, $width = 350, $height = 259);

        //Create record for a new service
        $createService = Service::create([
           'user_id'        =>  Auth::id(),
           'category_id'    =>  $request->category_id,
           'name'           =>  ucwords($request->name),
           'service_charge' =>  $request->service_charge,
           'description'    =>  $request->description,
           'image'          =>  $imageName,
           'updated_at'     =>  null,
        ]);

       if($createService){

           //Record crurrenlty logged in user activity
           $type = 'Others';
           $severity = 'Informational';
           $actionUrl = Route::currentRouteAction();
           $message = Auth::user()->email.' created '.ucwords($request->input('name')).' service.';
           $this->log($type, $severity, $actionUrl, $message);

           return redirect()->route('admin.services.index', app()->getLocale())->with('success', ucwords($request->name).' service was successfully created.');

       }else{

            if(\File::exists($imageDirectory.$imageName)){

                \File::delete($imageDirectory.$imageName);
            }

           //Record Unauthorized user activity
           $type = 'Errors';
           $severity = 'Error';
           $actionUrl = Route::currentRouteAction();
           $message = 'An error occurred while '.Auth::user()->email.' was trying to create service.';
           $this->log($type, $severity, $actionUrl, $message);

           return back()->with('error', 'An error occurred while trying to create service.');
       }

       return back()->withInput();
    }

    /**
     * Validate user input fields
     */
    private function validateRequest(){
        return request()->validate([
            'name'              =>   'required|unique:services,name',
            'category_id'       =>   'required',
            'service_charge'    =>   'required|numeric',
            'image'             =>   'required|mimes:jpg,png,jpeg,gif,svg|max:1014',
            'description'       =>   'required',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        $service = Service::findOrFail($uuid);

        $data = [
            'category'    =>  $service,
        ];

        return view('admin.service._show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($language, $uuid)
    {
        $service = Service::findOrFail($uuid);

        $categories = Category::ActiveCategories()->get();

        $data = [
            'categories'    =>  $categories,
            'category'      =>  $service,
        ];

        return view('admin.service._edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($language, Request $request, $uuid)
    {
        //Validate user input fields
        $request->validate([
            'name'              =>   'required',
            'category_id'       =>   'required',
            'service_charge'    =>   'required|numeric',
            'description'       =>   'required',
        ]);

        //Image storage directory
        $imageDirectory = public_path('assets/service-images').'/';

        //Get old service image name
        $oldImageName = $request->old_post_image;

         //Validate if an image file was selected
         if($request->hasFile('image')){
            //Validate and update image with ImageUpload Trait
            $imageName = $this->verifyAndStoreImage($request, $imageDirectory, $width = 350, $height = 259);

            //Delete old service image if new image name is given
            if(!empty($imageName) && ($imageName != $oldImageName)){
                if(\File::exists($imageDirectory.$oldImageName)){

                    \File::delete($imageDirectory.$oldImageName);
                }
            }

        }else{
            $imageName = $oldImageName;
        }

         $updateCategory = Service::where('uuid', $uuid)->update([
            'category_id'   =>  $request->input('category_id'),
            'name'          =>  ucwords($request->input('name')),
           'service_charge' =>  $request->service_charge,
            'description'   =>  $request->input('description'),
            'image'         =>  $imageName,
        ]);

        if($updateCategory){

            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' updated '.ucwords($request->input('name')).' service';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.services.index', app()->getLocale())->with('success', ucwords($request->input('name')).' service was successfully updated.');

        }else{
            //Record Unauthorized user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to update service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to update '.ucwords($request->input('name')).' service.');
        }

        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($language, $uuid)
    {
        //Verify if uuid exists
        $service = Service::findOrFail($uuid);

        $deleteService = $service->delete();

        if($deleteService){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$service->name.' service';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', $service->name. ' service has been deleted.');

        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$service->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete '.$service->name);
        }
    }

    public function deactivate($language, $uuid)
    {
        //Get service record
        $service = Service::findOrFail($uuid);

        //Update service status to 0, indicating inactive
        $deactivateService = Service::where('uuid', $uuid)->update([
            'status'    => 0
        ]);

        if($deactivateService){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deactivated '.$service->name.' service';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.services.index', app()->getLocale())->with('success', $service->name.' service has been deactivated.');

        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to deactivate '.$service->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to deactivate service.');
        }

    }

    public function reinstate($language, $uuid)
    {
        //Get service record
        $service = Service::findOrFail($uuid);

        //Update service status to 1, indicating active
        $reinstateService = Service::where('uuid', $uuid)->update([
            'status'    => 1
        ]);

        if($reinstateService){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' reinstated '.$service->name.' service';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.services.index', app()->getLocale())->with('success', $service->name.' service has been reinstated.');

        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to reinstate '.$service->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to reinstate service.');
        }
    }
}
