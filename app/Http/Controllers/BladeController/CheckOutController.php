<?php

namespace App\Http\Controllers\BladeController;

use App\Models\Trip;
use App\Models\ChekOut;
use App\Models\Student;
use App\Models\Checkout;
use App\Models\StudentTrip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\BladeServices\CheckOutService;
use App\Http\Requests\Checkout_Request\Store_Checkout_Request;
use App\Http\Requests\Checkout_Request\Update_Checkout_Request;

class CheckOutController extends Controller
{
    protected $checkoutservice;
    
    public function __construct(CheckOutService $checkoutservice)
    {
        $this->checkoutservice = $checkoutservice;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $checkouts = $this->checkoutservice->get_all_checkouts();
        // return view('checkout.view', compact('checkouts'));
        // $trip = $this->checkoutservice->get_all_checkouts();
        // return view('checkout.view',compact('trip'));
        $checkouts = $this->checkoutservice->get_all_checkouts();
        return view('checkout.show',compact('checkouts'));
    }
    /**
     *create function
     */
    // public function create()
    // {
    //     // $exesting_id = StudentTrip::where('trip_id', $trip_id)
    //     //                 ->pluck('student_id');
    //     // $trip = Trip::findOrFail($trip_id);
    //     // $student = Student::where('student_id',$exesting_id);
    //     $user = Auth::user();

    //     if($user->role == 'supervisor'){
    //         $trip = $user->trips()->pluck('trip_id');
    //         $student = StudentTrip::where('trip_id',$trip)->get();
    //     }else{
    //         $trip = Trip::all();
    //     }
    //     // $student = Student::all();
    //     return view('checkout.create',compact('trip','student'));
    // }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Store_Checkout_Request $request)
    {
        $checkout = $this->checkoutservice->create_checkout($request->validated());
        session()->flash('success', 'تمت عملية إنشاء تفقد الطالب بنجاح');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show($trip_id)
    {
        $trip = $this->checkoutservice->view_checkout($trip_id);
        $student = Student::all();
        return view('checkout.view',compact('trip','student'));
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Update_Checkout_Request $request, $checkout_id)
    {
        $checkout = $this->checkoutservice->update_checkout($request->validated(), $checkout_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($checkout_id)
    {
        $checkout = $this->checkoutservice->delete_checkout($checkout_id);
    }
}
