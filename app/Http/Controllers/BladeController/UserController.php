<?php

namespace App\Http\Controllers\BladeController;

use App\Http\Controllers\Controller;
use App\Http\Requests\User_Rqeuests\Store_User_Request;
use App\Http\Requests\User_Rqeuests\Update_User_Request;
use App\Http\Resources\NotificationResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\UserReq;
use App\Models\Table;
use app\Models\User;
use Spatie\Permission\Models\Role;
use Hash;
use Illuminate\Support\Arr;
use DB;
use illuminate\Support\Facades\Log;
use App\Http\Requests\UserRequest;
use App\Http\Traits\UserManagementTrait;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use UserManagementTrait;

    public function __construct()
    {
        $this->middleware(['role:Admin', 'permission:users|user management'])->only('index');
        $this->middleware(['role:Admin', 'permission:show user'])->only('show');
        $this->middleware(['role:Admin', 'permission:add user'])->only(['store', 'create']);
        $this->middleware(['role:Admin', 'permission:update user'])->only(['edit', 'update']);
        $this->middleware(['role:Admin', 'permission:destroy user'])->only('destroy');
        // $this->middleware(['role:Admin', 'permission:trashed user management'])->only('all_trashed_user');
        // $this->middleware(['role:Admin', 'permission:restore user'])->only('restore');
        // $this->middleware(['role:Admin', 'permission:forceDelete user'])->only('forceDelete');
    }

//========================================================================================================================

    public function index()
    {
        try {
            $users = $this->getAllUsers();
            return view('users.view', compact('users'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

//========================================================================================================================

    public function create()
    {
        try {
            $roles = $this->getRoles();
            return view('users.create', compact('roles'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }

//========================================================================================================================

    public function store(Store_User_Request $request)
    {
        try {
            $validatedData = $request->validated();
            $this->createUser($validatedData);
            return redirect()->route('users.index')
                ->with('success', 'User created successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->withInput()->with('error', 'Unable to create user at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function edit(string $id)
    {
        try {
            $data = $this->getUserWithRoles($id);
            $user = $data['user'];
            $roles = $data['roles'];
            $userRole = $data['userRole'];
            return view('   users.update', compact('user', 'roles', 'userRole'));
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Unable to retrieve user or roles at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function update(Update_User_Request $request, string $id)
    {
        try {
            $validatedData = $request->validated();
            $this->updateUser($validatedData, $id);

            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', 'Unable to update user at this time. Please try again later.');
        }
    }

//========================================================================================================================

    public function destroy(string $id)
    {
        try {
            $this->deleteUser($id);
            return redirect()->route('users.view')->with('success', 'User deleted successfully');
        } catch (\Throwable $th) {
            Log::error($th);
            return redirect()->back()->with('error', $th->getMessage());
        }
    }
//========================================================================================================================

    public function show($user_id){
        $user = $this->view_user($user_id);
        return view('users.show', compact('user'));
    }
//========================================================================================================================
    /**
     * method to return all soft deleted usesr
     * @return /view
     */
    public function all_trushed_user()
    {
        $users = User::onlyTrashed()->get();
        return view('users.trush', compact('users'));
    }
    //========================================================================================================================
    /**
     * method to restore soft deleted users alraedy exist
     * @param   $student_id
     * @return /view
     */
    public function restore($user_id)
    {
        $restore = $this->restore_user($user_id);
        session()->flash('success', 'تمت عملية استعادة المستخدم بنجاح');
        return redirect()->route('all_trashed_user');
    }
    //========================================================================================================================
    /**
     * method to force delete on user that soft deleted before
     * @param   $student_id
     * @return /view
     */
    public function forceDelete($user_id)
    {
        $delete = $this->forceDelete_user($user_id);
        session()->flash('success', 'تمت عملية حذف المستخدم بنجاح');
        return redirect()->route('all_trashed_user');
    }

    //========================================================================================================================

    public function getNotificationForUser(){
        $notifications = auth()->user()->notifications()
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->latest()->get();
        return response()->json(NotificationResource::collection($notifications));
    }
}
