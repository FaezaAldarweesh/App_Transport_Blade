<?php

namespace App\Http\Controllers\BladeController;

use App\Models\Employee;
use App\Http\Controllers\Controller;
use App\Http\Requests\Employee_Request\Employee_Request;
use Illuminate\Support\Facades\Request;
use App\Services\BladeServices\EmployeeService;

class EmployeeController extends Controller
{
    protected $employeesevices;
    /**
     * construct to inject bus Services 
     * @param BusService $busservices
     */
    public function __construct(EmployeeService $employeesevices)
    {
        $this->employeesevices = $employeesevices;
    }
    //===========================================================================================================================
    /**
     * method to view all buses
     * @return /view
     */
    public function index()
    {  
        $employees = $this->employeesevices->get_all_employee();
        return view('employees.view', compact('employees'));
    }
    //===========================================================================================================================
    /**
     * method header to driver create page 
     */
    public function create(){
        return view('employees.create');
    }
    //===========================================================================================================================
    /**
     * method to store a new bus
     * @param   Store_Bus_Request $request
     * @return /view
     */
    public function store(Employee_Request $request)
    {
        $buses = $this->employeesevices->create_employee($request->validated());
        session()->flash('success', 'تمت عملية إضافة الموظف بنجاح');
        return redirect()->route('employee.index');
    }
    
    //===========================================================================================================================
    /**
    * method header bus to edit page
    */
    public function edit($employee_id){
        $employee = Employee::findOrFail($employee_id);
        return view('employees.update' , compact('employee'));
    }
    //===========================================================================================================================
    /**
     * method to update bus alraedy exist
     * @param  Update_Bus_Request $request
     * @param  $bus_id
     * @return /view
     */
    public function update(Employee_Request $request, $employee_id)
    {
        $employee = $this->employeesevices->update_employee($request->validated(), $employee_id);
        session()->flash('success', 'تمت عملية التعديل على الموظف بنجاح');
        return redirect()->route('employee.index');
    }
    //===========================================================================================================================
    /**
     * method to soft delete bus alraedy exist
     * @param  $bus_id
     * @return /view
     */
    public function destroy($employee_id)
    {
        $employee = $this->employeesevices->delete_employee($employee_id);
        session()->flash('success', 'تمت عملية إضافة الموظف للأرشيف بنجاح');
        return redirect()->route('employee.index');
    }
    //========================================================================================================================
    /**
     * method to return all soft deleted bus
     * @return /view
     */
    public function all_trashed_employee()
    {
        $employee = $this->employeesevices->all_trashed_employee();
        return view('employees.trush', compact('employee'));
    }
    //========================================================================================================================
    /**
     * method to restore soft deleted bus alraedy exist
     * @param   $bus_id
     * @return /view
     */
    public function restore($employee_id)
    {
        $restore = $this->employeesevices->restore_employee($employee_id);
        session()->flash('success', 'تمت عملية استعادة الموظف بنجاح');
        return redirect()->route('all_trashed_employee');
    }
    //========================================================================================================================
    /**
     * method to force delete on bus that soft deleted before
     * @param   $bus_id
     * @return /view
     */
    public function forceDelete($employee_id)
    {
        $delete = $this->employeesevices->forceDelete_employee($employee_id);
        session()->flash('success', 'تمت عملية حذف الموظف بنجاح');
        return redirect()->route('all_trashed_employee');
    }
        
    //========================================================================================================================
}
