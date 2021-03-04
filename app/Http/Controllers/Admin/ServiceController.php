<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use App\Traits\Loggable;
use Illuminate\Support\Str;
use Auth;
use Route;

use App\Models\Category;
use App\Models\Service;

class ServiceController extends Controller
{
    use Loggable;
    
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
        $services = Service::orderBy('name', 'ASC')->get();

        $data = [
            'services'  =>  $services,
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
        //
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
    public function update(Request $request, $id)
    {
        //
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
        $category = Category::findOrFail($uuid);

        //Get number of services assigned to a Category
        $assignedServices = $category->services()->count();

        //If services count is greater than 0, reassign to Uncategorized Category
        if((int)$assignedServices > 0){

            //Get ID for each service assgined to a Category
            foreach($category->services as $service){
                Service::where('id', $service->id)->update([
                    'category_id'    => 1
                ]);
            }

            //Delete Category
            $deleteCategory = Category::where('uuid', $uuid)->delete();

        }else{

            //Delete Category if assigned services count is zero
            $deleteCategory = Category::where('uuid', $uuid)->delete();
        }

        if($deleteCategory){
            
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deleted '.$category->name.' category';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('success', $category->name. ' category has been deleted and services have been moved to Uncategorized Category.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to delete '.$category->name.' category.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to delete '.$category->name);
        } 
    }

    public function deactivate($language, $uuid)
    {
        //Get category record
        $category = Category::findOrFail($uuid);

        //Update category record with softDelete
        $deactivateCategory = Category::where('uuid', $uuid)->update([
            'deleted_at'    => \Carbon\Carbon::now()
        ]);

        if($deactivateCategory){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' deactivated '.$category->name.' category';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.categories.index', app()->getLocale())->with('success', 'Category has been deactivated.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to deactivate '.$category->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to deactivate category.');
        } 
        
    }

    public function reinstate($language, $uuid)
    {
        //Get category record
        $category = Category::findOrFail($uuid);

        //Update category record with softDelete
        $reinstateCategory = Category::where('uuid', $uuid)->update([
            'deleted_at'    => null
        ]);

        if($reinstateCategory){
            //Record crurrenlty logged in user activity
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' reinstated '.$category->name.' category';
            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->route('admin.categories.index', app()->getLocale())->with('success', 'Category has been reinstated.');
            
        }else{
            //Record crurrenlty logged in user activity
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An error occurred while '.Auth::user()->email.' was trying to reinstate '.$category->name.' service.';
            $this->log($type, $severity, $actionUrl, $message);

            return back()->with('error', 'An error occurred while trying to reinstate category.');
        } 
    }
}
