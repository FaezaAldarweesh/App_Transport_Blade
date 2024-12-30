<?php

namespace App\Http\Controllers\BladeController;

use App\Models\User;
use App\Models\Supervisor;
use App\Http\Controllers\Controller;
use App\Services\BladeServices\SupervisorService;
use App\Http\Requests\Supervisor_Rqeuests\Store_Supervisor_Request;
use App\Http\Requests\Supervisor_Rqeuests\Update_Supervisor_Request;

class SupervisorController extends Controller
{
    protected $supervisorservices;
    /**
     * construct to inject supervisor Services 
     * @param SupervisorService $supervisorservices
     */
    public function __construct(SupervisorService $supervisorservices)
    {
        $this->supervisorservices = $supervisorservices;
        $this->middleware(['role:Admin', 'permission:supervisors|supervisor management'])->only('index');
        $this->middleware(['role:Admin', 'permission:show supervisor trip'])->only('show');
        $this->middleware(['role:Admin', 'permission:add supervisor'])->only(['store', 'create']);
        $this->middleware(['role:Admin', 'permission:update supervisor'])->only(['edit', 'update']);
        $this->middleware(['role:Admin', 'permission:destroy supervisor'])->only('destroy');
        $this->middleware(['role:Admin', 'permission:trashed supervisor management'])->only('all_trashed_bus');
        $this->middleware(['role:Admin', 'permission:restore supervisor'])->only('restore');
        $this->middleware(['role:Admin', 'permission:forceDelete supervisor'])->only('forceDelete');
    }
    //===========================================================================================================================
    /**
     * method to view all supervisors 
     * @return /view
     * UserResources to customize the return responses.
     */
    public function index()
    {  
        $supervisors = $this->supervisorservices->get_all_Supervisors();
        return view('supervisors.view', compact('supervisors'));

    }
    //===========================================================================================================================
    /**
     * method header to supervisor create page 
     */
    public function create(){
        return view('supervisors.create');
    }
    //===========================================================================================================================
    /**
     * method to store a new supervisor
     * @param   Store_Supervisor_Request $request
     * @return /view
     */
    public function store(Store_Supervisor_Request $request)
    {
        $supervisor = $this->supervisorservices->create_Supervisor($request->validated());
        session()->flash('success', 'تمت عملية إضافة المشرف بنجاح');
        return redirect()->route('supervisor.index');
    }
    //===========================================================================================================================
    /**
    * method header user to edit page
    */
    public function edit($supervisor_id){
        $supervisor = Supervisor::find($supervisor_id);
        return view('supervisors.update' , compact('supervisor'));
    }
    //===========================================================================================================================
    /**
     * method to update supervisor alraedy exist
     * @param  Update_Supervisor_Request $request
     * @param  $supervisor_id
     * @return /view
     */
    public function update(Update_Supervisor_Request $request, $supervisor_id)
    {
        $supervisor = $this->supervisorservices->update_Supervisor($request->validated(), $supervisor_id);
        session()->flash('success', 'تمت عملية التعديل على المشرف بنجاح');
        return redirect()->route('supervisor.index');
    }
    //===========================================================================================================================
    /**
     * method to soft delete supervisor alraedy exist
     * @param  $supervisor_id
     * @return /view
     */
    public function destroy($supervisor_id)
    {
        $supervisor = $this->supervisorservices->delete_supervisor($supervisor_id);
        session()->flash('success', 'تمت عملية إضافة المشرف للأرشيف بنجاح');
        return redirect()->route('supervisor.index');
    }
    //========================================================================================================================
    /**
     * method to return all soft deleted supervisors
     * @return /view 
     */
    public function all_trashed_supervisor()
    {
        $supervisors = $this->supervisorservices->all_trashed_supervisor();
        return view('supervisors.trashed', compact('supervisors'));
    }
    //========================================================================================================================
    /**
     * method to restore soft deleted supervisor alraedy exist
     * @param   $supervisor_id
     * @return /view
     */
    public function restore($supervisor_id)
    {
        $delete = $this->supervisorservices->restore_supervisor($supervisor_id);
        session()->flash('success', 'تمت عملية استعادة المشرف بنجاح');
        return redirect()->route('all_trashed_supervisor');
    }
    //========================================================================================================================
    /**
     * method to force delete on supervisor that soft deleted before
     * @param   $supervisor_id
     * @return /view
     */
    public function forceDelete($supervisor_id)
    {
        $delete = $this->supervisorservices->forceDelete_supervisor($supervisor_id);
        session()->flash('success', 'تمت عملية حذف المشرف بنجاح');
        return redirect()->route('all_trashed_supervisor');
    }
        
    //========================================================================================================================
    public function show($supervisor_id)
    {
        $supervisor_trip = $this->supervisorservices->view_supervisor($supervisor_id);
        return view('supervisors.show', compact('supervisor_trip'));
    }
    //===========================================================================================================================
}
