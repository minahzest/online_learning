<?php

namespace App\Http\Controllers;

use App\StudentCourse;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class StudentController extends Controller
{
    public function index(){
        $data['users'] = User::all();
        return view('admin.managestudent')->with($data);
    }

    public function add_update_user(Request $request){
        
        if ($request->user_id == 0) {
            $validator = FacadesValidator::make($request->all(),[
                'user_id' => 'required',
                'f_name' => 'required|string|max:255',
                'l_name' => 'required|string|max:255',
                'phone' => 'required',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
            ]);
        }else{
            $validator = FacadesValidator::make($request->all(),[
                'user_id' => 'required',
                'f_name' => 'required|string|max:255',
                'l_name' => 'required|string|max:255',
                'phone' => 'required',
                'password' => 'required|string|min:8',
            ]);
        }

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => 'Please Check your Fields', 'errors' => $validator->errors()]);
        }else{

            if ($request->user_id == 0) {
                $user = User::create([
                    'f_name' => $request->f_name,
                    'l_name' => $request->l_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => bcrypt($request->password),
                ]);
                if ($user) {
                    return response()->json(['status' => 'success', 'data' => 'Student Created Successfully']);
                    
                }else{
                    return response()->json(['status' => 'error', 'data' => 'Something Went Wrong!']);
        
                }
            }else{
                $check = User::where('id', '=' , $request->user_id)->get();
                if (count($check)) {
                    $data['user_id'] = $request->user_id;
                    User::findOrFail($data['user_id'])->update([
                        'f_name' => $request->f_name,
                        'l_name' => $request->l_name,
                        'phone' => $request->phone,
                    ]);
                    return response()->json(['status' => 'success', 'data' => 'Student Updated Successfully']);
                    
                }else{
                    return response()->json(['status' => 'error', 'data' => 'Student Not Found']);
        
                }
            }
        }
    }

    public function delete_user(Request $request){
        $check = User::where('id', '=' , $request->user_id)->get();
        if (count($check)) {
            $validate = StudentCourse::where('user_id', '=' , $request->user_id)->get();
            if (count($validate)) {
                return response()->json(['status' => 'error', 'data' => 'Student is following Course!']);
            }else{
                $data['user_id'] = $request->user_id;  
                User::findOrFail($data['user_id'])->delete($data['user_id']);
                return response()->json(['status' => 'success', 'data' => 'Student Deleted Successfully']);
            }
            
        }else{
            return response()->json(['status' => 'error', 'data' => 'Something Went Wrong!']);

        }
    }
}
