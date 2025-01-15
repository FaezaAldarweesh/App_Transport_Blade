<?php

namespace App\Http\Controllers\BladeController;

use App\Models\Bus;
use App\Models\Path;
use App\Models\Trip;
use App\Models\User;
use App\Models\Driver;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\BladeServices\TripService;
use App\Http\Requests\Trip_Request\Store_Trip_Request;
use App\Http\Requests\Trip_Request\Update_Trip_Request;

class TripController extends Controller
{
    protected $Tripservices;
    /**
     * construct to inject Trip Services 
     * @param TripService $Tripservices
     */
    public function __construct(TripService $Tripservices)
    {
        $this->Tripservices = $Tripservices;
        $this->middleware(['permission:trips|management'])->only('index');
        $this->middleware(['permission:show trip'])->only('show');
        $this->middleware(['role:Admin', 'permission:add trip'])->only(['store', 'create']);
        $this->middleware(['role:Admin', 'permission:update trip'])->only(['edit', 'update']);
        $this->middleware(['role:Admin', 'permission:destroy trip'])->only('destroy');
        $this->middleware(['role:Admin', 'permission:trashed trip management'])->only('all_trashed_bus');
        $this->middleware(['role:Admin', 'permission:restore trip'])->only('restore');
        $this->middleware(['role:Admin', 'permission:forceDelete trip'])->only('forceDelete');
        $this->middleware(['permission:update trip status'])->only(methods: 'update_trip_status');
        $this->middleware(['permission:absences / transfar'])->only('all_student_trip');
        $this->middleware(['permission:update student status'])->only('update_student_status');
        $this->middleware(['permission:update student status transport'])->only('update_student_status_transport');
    }
    //===========================================================================================================================
    /**
     * method to view all Trips
     * @return /view
     */
    public function index()
    {  
        $trips = $this->Tripservices->get_all_Trips();
        return view('trips.view', compact('trips'));
    }
    //===========================================================================================================================
    /**
     * method header to trip create page 
     */
    public function create(){
        $paths = Path::all();
        $buses = Bus::all();
        $drivers = Driver::all();
        $supervisors = User::where('role', '=', 'supervisor')->get();
        $students = Student::all();
        return view('trips.create', compact('paths','buses','drivers','supervisors','students'));
    }
    //===========================================================================================================================
    /**
     * method to store a new Trip
     * @param   Store_Trip_Request $request
     * @return /view
     */
    public function store(Store_Trip_Request $request)
    {
        $Trip = $this->Tripservices->create_Trip($request->validated());
        session()->flash('success', 'تمت عملية إضافة الرحلة بنجاح');
        return redirect()->route('trip.index');
    }
    //===========================================================================================================================
    /**
     * method to show Trip alraedy exist
     * @param  $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function show($Trip_id)
    {
        $trip = $this->Tripservices->view_Trip($Trip_id);
        $paths = Path::all();
        $buses = Bus::all();
        return view('trips.show', compact('trip','paths','buses'));
    }
    //===========================================================================================================================
    /**
    * method header trip to edit page
    */
    public function edit($trip_id){
        $trip = Trip::find($trip_id);
        $paths = Path::all();
        $buses = Bus::all();
        $drivers = Driver::all();
        $supervisors = User::where('role', '=', 'supervisor')->get();
        $students = Student::all();
        return view('trips.update' , compact('trip','paths','buses','drivers','supervisors','students'));
    }
    //===========================================================================================================================
    /**
     * method to update Trip alraedy exist
     * @param  Update_Trip_Request $request
     * @param  $Trip_id
     * @return /view
     */
    public function update(Update_Trip_Request $request, $Trip_id)
    {
        $Trip = $this->Tripservices->update_Trip($request->validated(), $Trip_id);
        session()->flash('success', 'تمت عملية التعديل على الرحلة بنجاح');
        return redirect()->route('trip.index');
    }
    //===========================================================================================================================
    /**
     * method to soft delete Trip alraedy exist
     * @param  $Trip_id
     * @return /view
     */
    public function destroy($Trip_id)
    {
        $Trip = $this->Tripservices->delete_Trip($Trip_id);
        session()->flash('success', 'تمت عملية إضافة الرحلة للأرشيف بنجاح');
        return redirect()->route('trip.index');
    }
    //========================================================================================================================
    /**
     * method to return all soft deleted Trips
     * @return /view
     */
    public function all_trashed_Trip()
    {
        $trips = $this->Tripservices->all_trashed_Trip();
        return view('trips.trashed', compact('trips'));
    }
    //========================================================================================================================
    /**
     * method to restore soft deleted Trip alraedy exist
     * @param   $Trip_id
     * @return /view
     */
    public function restore($Trip_id)
    {
        $delete = $this->Tripservices->restore_Trip($Trip_id);
        session()->flash('success', 'تمت عملية استعادة الرحلة بنجاح');
        return redirect()->route('all_trashed_trip');
    }
    //========================================================================================================================
    /**
     * method to force delete on Trip that soft deleted before
     * @param   $Trip_id
     * @return /view
     */
    public function forceDelete($Trip_id)
    {
        $delete = $this->Tripservices->forceDelete_Trip($Trip_id);
        session()->flash('success', 'تمت عملية حذف الرحلة بنجاح');
        return redirect()->route('all_trashed_trip');
    }
        
    //========================================================================================================================



    //========================================================================================================================
    /**
     * method to update on trip status
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function update_trip_status($trip_id)
    {
        $trip = $this->Tripservices->update_trip_status($trip_id);
        session()->flash('success', 'تمت عملية تعديل حالة الرحلة بنجاح');
        return redirect()->route('trip.index');

    }  
    //========================================================================================================================
        /**
     * method to update on trip status
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function all_student_trip($trip_id)
    {
        $Trip = $this->Tripservices->all_student_trip($trip_id);
        $trips = Trip::where('name','delivery')->get();
        return view('trips.students', compact('Trip','trips'));
    }  
    //========================================================================================================================
        /**
     * method to update on trip status
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function update_student_status($student_id,$trip_id)
    {
        $student = $this->Tripservices->update_student_status($student_id,$trip_id);
        session()->flash('success', 'تمت عملية تعديل حالة الطالب بنجاح');
        return redirect()->back();

    }  
    //========================================================================================================================
    /**
     * method to update on trip status
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function update_student_status_transport($transport_id)
    {
        $student = $this->Tripservices->update_student_status_transport($transport_id);
        session()->flash('success', 'تمت عملية نقل الطالب بنجاح');
        return redirect()->back();
    }
    
    //========================================================================================================================
       /**
     * method to update on trip status
     * @param   $Trip_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function update_student_time_arrive(Request $request,$student_id,$trip_id)
    {
        $student = $this->Tripservices->update_student_time_arrive( $request,$student_id,$trip_id);
        session()->flash('success', 'تمت عملية التعديل على موعد الوصول للطالب بنجاح');
        return redirect()->back();
    }
    
    //========================================================================================================================
}
