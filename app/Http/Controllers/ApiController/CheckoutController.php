<?php

namespace App\Http\Controllers\ApiController;

use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\CheckoutResources;
use App\Services\ApiServices\CheckoutService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Requests\Checkout_Request\Store_Checkout_Request;

class CheckoutController extends Controller
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    protected $checkoutservices;
    /**
     * construct to inject checkout Services
     * @param CheckoutService $checkoutservices
     */
    public function __construct(CheckoutService $checkoutservices)
    {
        $this->checkoutservices = $checkoutservices;
    }
    //===========================================================================================================================
    /**
     * method to view all checkouts to a specific trip
     * @return /Illuminate\Http\JsonResponse
     * checkoutResources to customize the return responses.
     */
    public function view($trip_id)
    {
        $checkout = $this->checkoutservices->view($trip_id);
        return $this->success_Response(CheckoutResources::collection($checkout), "تم عملية الوصول للتفقد بنجاح", 200);
    }
    //===========================================================================================================================
    /**
     * method to store a new checkout
     * @param   Store_Checkout_Request $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function store($trip_id,$student_id,$status)
    {
        $checkout = $this->checkoutservices->create_checkout($trip_id,$student_id,$status);
         // In case error messages are returned from the services section
         if ($checkout instanceof \Illuminate\Http\JsonResponse) {
            return $checkout;
        }
        return $this->success_Response(new CheckoutResources($checkout), "تمت عملية أخذ التفقد بنجاح", 201);
    }

    //===========================================================================================================================
}
