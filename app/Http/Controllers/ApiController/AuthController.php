<?php

namespace App\Http\Controllers\ApiController;

use App\Services\ApiServices\AuthService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\registerResource;
use App\Http\Requests\Auth_Requests\loginRequest;

class AuthController extends Controller
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    protected $authservices;
    /**
     * construct to inject auth services
     * @param AuthService $authservices
     */
    public function __construct(AuthService $authservices)
    {
        $this->authservices = $authservices;
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    //===========================================================================================================================
    /**
     * function to login users
     * @param loginRequest $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function login(loginRequest $request)
    {
        $result = $this->authservices->login($request->validated());
        // In case error messages are returned from the services section
        if ($result instanceof \Illuminate\Http\JsonResponse) {
            return $result;
        }
        return $this->api_Response($result['user'],$result['token'],"تمت عملية تسجيل الدخول بنجاح",200);
    }
//===========================================================================================================================
    /**
     * function to logout users
     * @return /Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        $this->authservices->logout();
        return $this->api_Response(null,null,"تمت عملية تسجيل الخروج بنجاح",200);
    }
//===========================================================================================================================
    /**
     * function to refresh token
     * @return /Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $result = $this->authservices->refresh();
        return $this->api_Response(new registerResource($result['user']),$result['token'],"refresh has been successfully",201);
    }
//===========================================================================================================================
}
