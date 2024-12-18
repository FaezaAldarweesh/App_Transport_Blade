<?php

namespace App\Http\Controllers;

use App\Http\Requests\Employee_Request;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Services\EmployeeService;

class employeeController extends Controller
{
    protected $employeeservices;
    public function __construct(EmployeeService $employeeservices){
        $this -> employeeservices = $employeeservices;
    }

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function index(){
        return $this -> employeeservices -> show_main_page();
    }

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function store(Employee_Request $request){
        return $this -> employeeservices -> create_employee($request);
    }

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function show(){
        return $this -> employeeservices -> show_all_employees();
    }
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function edit($id){
        return $this -> employeeservices -> edit_employee($id);
    }
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function update(Employee_Request $request, $id){
        return $this -> employeeservices -> update_employee($request, $id);
    }
    
//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

    public function destroy($id){
        return $this -> employeeservices -> delete_employee($id);
     }

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

     public function trush(){
        $employee =  $this -> employeeservices -> trush();
        return view('employee_trush',compact('employee'));
        
     }

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

     public function restor($id){
        $employee_restor = $this -> employeeservices -> restor_employee($id);
        return redirect() -> route('employee.trush');
     }

//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>

     public function force_delete($id){
        $deleted_employee = $this -> employeeservices -> force_delete_employee($id);
        return redirect() -> route('employee.trush');
     }
}

