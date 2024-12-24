<?php

namespace App\Http\Controllers\BladeController;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\BladeServices\UserService;
use App\Http\Requests\User_Rqeuests\Store_User_Request;
use App\Http\Requests\User_Rqeuests\Update_User_Request;
use App\Models\Student;

class UserController extends Controller
{
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
     * method to view all users with a filter on role
     * @param   Request $request
     * @return /Illuminate\Http\JsonResponse
     * UserResources to customize the return responses.
     */
    public function index(Request $request)
    {  
        $users = $this->userservices->get_all_Users($request->input('role'));
        return view('users.view', compact('users'));
    }
    //===========================================================================================================================
    /**
     * method header to driver create page 
     */
    public function create(){
        return view('users.create');
    }
    //===========================================================================================================================
    /**
     * method to store a new user
     * @param   Store_User_Request $request
     * @return /Illuminate\Http\JsonResponse
     */
    public function store(Store_User_Request $request)
    {
        $user = $this->userservices->create_User($request->validated());
        session()->flash('success', 'تمت عملية إضافة المستخدم بنجاح');
        return redirect()->route('user.index');
    }
    
    //===========================================================================================================================
    /**
    * method header bus to edit page
    */
    public function edit($user_id){
        $user = User::findOrFail($user_id);
        return view('users.update' , compact('user'));
    }

    //===========================================================================================================================

    public function show($user_id){
        $user = $this->userservices->view_user($user_id);
        // $students = Student::all();
        return view('users.show', compact('user'));
    }

    //===========================================================================================================================
    /**
     * method to update user alraedy exist
     * @param  Update_User_Request $request
     * @param  $user_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function update(Update_User_Request $request, User $user)
    {
        $user = $this->userservices->update_User($request->validated(), $user); 
        session()->flash('success', 'تمت عملية التعديل على المستخدم بنجاح');
        return redirect()->route('user.index');
    }
    //===========================================================================================================================
    /**
     * method to soft delete user alraedy exist
     * @param  $user_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $user = $this->userservices->delete_user($user);
        session()->flash('success', 'تمت عملية إضافة المستخدم للأرشيف بنجاح');
        return redirect()->route('user.index');
    }
    //========================================================================================================================
    /**
     * method to return all soft deleted users
     * @return /Illuminate\Http\JsonResponse if have an error
     */
    public function all_trushed_user()
    {
        $users = $this->userservices->all_trashed_user();
        return view('users.trush', compact('users'));
    }
    //========================================================================================================================
    /**
     * method to restore soft deleted user alraedy exist
     * @param   $user_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function restore($user_id)
    {
        $delete = $this->userservices->restore_user($user_id);
        session()->flash('success', 'تمت عملية استعادة المستخدم بنجاح');
        return redirect()->route('all_trashed_user');
    }
    //========================================================================================================================
    /**
     * method to force delete on user that soft deleted before
     * @param   $user_id
     * @return /Illuminate\Http\JsonResponse
     */
    public function forceDelete($user_id)
    {
        $delete = $this->userservices->forceDelete_user($user_id);
        session()->flash('success', 'تمت عملية حذف المستحدم بنجاح');
        return redirect()->route('all_trashed_user');
    }
        
    //========================================================================================================================
}
