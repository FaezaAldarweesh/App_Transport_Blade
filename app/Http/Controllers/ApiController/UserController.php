<?php

namespace App\Http\Controllers\ApiController;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResources;
use App\Http\Traits\ApiResponseTrait;
use App\Http\Resources\ChildResources;
use App\Http\Resources\StudentResources;
use App\Services\ApiServices\UserService;
use App\Http\Controllers\ApiController\Controller;
use App\Http\Requests\User_Rqeuests\Update_Supervisor_Request;

class UserController extends Controller
{
    //trait customize the methods for successful , failed , authentecation responses.
    use ApiResponseTrait;
    protected $userservices;
    /**
     * construct to inject User Services 
     * @param UserService $userservices
     */
    public function __construct(UserService $userservices)
    {
        $this->userservices = $userservices;
    }
    //===========================================================================================================================
    /**
     * method to show user alraedy exist
     * @param  $user_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function view_info()
    {
        $user = User::find(Auth::id());
        return $this->success_Response(new UserResources($user), "تمت عملية عرض المستخدم بنجاح", 200);
    }
    //===========================================================================================================================
    /**
     * method to update user alraedy exist
     * @param  Update_Supervisor_Request $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function update_info(Update_Supervisor_Request $request)
    {
        $user = $this->userservices->update_info($request->validated()); 
       return $this->success_Response(new UserResources($user), "تمت عملية التعديل على المستخدم بنجاح", 200);
    }
    //===========================================================================================================================
     /**
     * method return all children that belong to the same parent
     * @return /Illuminate\Http\JsonResponse
     */
    public function all_children()
    {
        $students = $this->userservices->all_children(); 
       return $this->success_Response( ChildResources::collection($students), "تمت عملية جلب كل الأطفال بنجاح", 200);
    }
    //===========================================================================================================================
}
