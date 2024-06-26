<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;

class employeeController extends Controller
{
    public function index(){

        $employess = Employee::orderBy("id","desc")->get();
        return view('employee.list',["employees"=>$employess]);
    }
    public function create(){
        return view('employee.create');
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'sometimes|image|mimes:gif,png,jpeg,jpg'
        ]);
    
        if($validator->fails()){
            // send error message
            return redirect()->route('employees.create')->withErrors($validator)->withInput();
        } else {
            // data send to database
            $employee = new Employee();
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();

            // image upload here
            if($request->image){
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().".".$ext;
                $request->image->move(public_path()."/upload/employees/",$newFileName);
                $employee->image = $newFileName;
                $employee->save();
            }

            $request->session()->flash('success','Employee added successfully');

            return redirect()->route('employees.index');
        }
    }
    public function edit($id){

        $employee = Employee::find($id);

        if(!$employee){
            abort('404');
        }
        return view('employee.edit',['employee' => $employee]);
    }

    public function update($id,Request $request){
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'image' => 'sometimes|image|mimes:gif,png,jpeg,jpg'
        ]);
    
        if($validator->fails()){
            // send error message
            return redirect()->route('employees.edit',$id)->withErrors($validator)->withInput();
        } else {
            // data send to database
            $employee = Employee::find($id);
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->address = $request->address;
            $employee->save();

            // image update here
            if($request->image){

                $oldImage = $employee->image;
                $ext = $request->image->getClientOriginalExtension();
                $newFileName = time().".".$ext;
                $request->image->move(public_path()."/upload/employees/",$newFileName);
                $employee->image = $newFileName;
                $employee->save();

                File::delete(public_path()."/upload/employees/".$oldImage);
            }

            $request->session()->flash('success','Employee update successfully');

            return redirect()->route('employees.index');
        }

    }
    public function destroy($id, Request $request){
        $employee = Employee::findOrFail($id);
        File::delete(public_path()."/upload/employees/".$employee->image);
        $employee->delete();

        $request->session()->flash('delete','Employee deleted successfully');

        return redirect()->route('employees.index');
    }
    
}
