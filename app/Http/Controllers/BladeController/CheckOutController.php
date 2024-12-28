<?php

namespace App\Http\Controllers\BladeController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BladeServices\CheckOutService;
use App\Http\Requests\Checkout_Request\Store_Checkout_Request;
use App\Http\Requests\Checkout_Request\Update_Checkout_Request;
use App\Models\Checkout;

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
        $checkouts = $this->checkoutservice->get_all_checkouts();
        return view('checkout.index',compact('checkouts'));
    }
//===========================================================================================================================
    public function store(Request $request)
    {
        $checkout = $this->checkoutservice->create_checkout($request->all());
        session()->flash('success', 'تمت عملية إنشاء تفقد الطالب بنجاح');
        return redirect()->back();
    }
//===========================================================================================================================
    public function show($trip_id)
    {
        $trip = $this->checkoutservice->view_checkout($trip_id);
        return view('checkout.view',compact('trip'));
    }
//===========================================================================================================================
    public function show_checkout($trip_id)
    {
        $checkouts = $this->checkoutservice->show_checkout($trip_id);
        return view('checkout.show',compact('checkouts'));
    }
//===========================================================================================================================
/**
* method header bus to edit page
*/
public function edit($checkout_id){
    $checkout = Checkout::findOrFail($checkout_id);
    return view('checkout.update' , compact('checkout'));
}
//===========================================================================================================================
    /**
     * Update the specified resource in storage.
     */
    public function update(Update_Checkout_Request $request, $checkout_id)
    {
        $checkout = $this->checkoutservice->update_checkout($request->validated(), $checkout_id);
        session()->flash('success', 'تمت عملية التعديل على تفقد الطالب بنجاح');
        return redirect()->route('checkout.edit', $checkout_id);
    }
//===========================================================================================================================
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($checkout_id)
    {
        $checkout = $this->checkoutservice->delete_checkout($checkout_id);
        return redirect()->back();
    }
//===========================================================================================================================
}
