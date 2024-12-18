<?php
namespace App\Services;

use Exceptoin;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;



class EmployeeService{
    public function show_main_page(){

        return view('employee');
    }

    public function create_employee($data){

        // $incomingdata = $request -> validate([
        //     'name' => ['required','regex:/^[a-zA-Z\s]+$/'],
        //     'email' => ['required','email',Rule::unique('employees','email'),'email:rfc,dns'],
        //     'em_job' => ['required','regex:/^[a-zA-Z\s]+$/'],
        //     'age' => ['required'],
        //     'salary' =>['string', 'regex:/^\d+(\.\d{1,2})?$/'],
        //     'phone' => ['required','string','regex:/^09\d{8}$/']
        // ]);
        //Employee::create($incomingdata);
        $new_employee = new Employee();
        // $new_employee -> name = $request -> name;
        // $new_employee -> email = $request -> email;
        // $new_employee -> em_job = $request -> em_job;
        // $new_employee -> age = $request -> age;
        // $new_employee -> salary = $request -> salary;
        // $new_employee -> phone = $request -> phone;
        $new_employee -> name = $data['name'];
        $new_employee -> em_job = $data['em_job'];
        $new_employee -> phone = $data['phone'];
        // $new_employee -> email = $data['email'];
        // $new_employee -> age = $data['age'];
        // $new_employee -> salary = $data['salary'];
        $new_employee ->save(); 
        return redirect() -> back();
    }

    public function show_all_employees(){

        $employees = Employee::all();
        return view('AllEmployee',compact('employees'));
    }
    
    public function edit_employee($id){
        $data = Employee::find($id);
        return view('UpdateEmployee', compact('data'));
    }

    public function update_employee($data, $id){

        $employee = Employee::find($id);
        // $employee -> name = $request -> name;
        // $employee -> email = $request -> email;
        // $employee -> em_job = $request -> em_job;
        // $employee -> age = $request -> age;
        // $employee -> salary = $request -> salary;
        // $employee -> phone = $request -> phone;
        $employee -> name = $data['name'];
        $employee -> em_job = $data['em_job'];
        $employee -> phone = $data['phone'];
        // $employee -> email = $data['email'];
        // $employee -> age = $data['age'];
        // $employee -> salary = $data['salary'];
        $employee -> save();
        return redirect() ->back();
    }

    public function delete_employee($id){
        $data = Employee::find($id);
        $data -> delete();
        if($data){
            return redirect() -> back() -> with('employee deleted succsessfully');
        }
        else{
            return redirect() -> back() -> with('employee not found');
        }
    }
    public function trush(){
        
        return Employee::onlyTrashed()->get();
        
    }
    public function restor_employee($id){
        $employee = Employee::onlyTrashed() -> findOrFail($id);
        $employee -> restore();
        return $employee;
    }
    public function force_delete_employee($id){
        $employee = Employee::onlyTrashed() -> findOrFail($id);
        $employee -> forceDelete();
    }
}