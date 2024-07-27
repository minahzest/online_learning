<?php

namespace App\Http\Controllers;

use App\Course;
use App\StudentCourse;
use Dotenv\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;

class CourseController extends Controller
{
    public function index(){
        $data['courses'] = Course::all();
        return view('admin.managecourse')->with($data);
    }

    public function add_update_course(Request $request){
        
        $validator = FacadesValidator::make($request->all(),[
            'course_id' => 'required',
            'course_name' => 'required',
            'course_code' => 'required',
            'course_description' => 'required'

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'data' => 'Please Check your Fields']);
        }else{

            if ($request->course_id == 0) {
                $user = Course::create([
                    'course_name' => $request->course_name,
                    'course_code' => $request->course_code,
                    'course_description' => $request->course_description,
                ]);
                if ($user) {
                    return response()->json(['status' => 'success', 'data' => 'Course Created Successfully']);
                    
                }else{
                    return response()->json(['status' => 'error', 'data' => 'Something Went Wrong!']);
        
                }
            }else{
                $check = Course::where('id', '=' , $request->course_id)->get();
                if (count($check)) {
                    $data['course_id'] = $request->course_id;
                    Course::findOrFail($data['course_id'])->update($request->all());
                    return response()->json(['status' => 'success', 'data' => 'Course Updated Successfully']);
                    
                }else{
                    return response()->json(['status' => 'error', 'data' => 'Course Not Found']);
        
                }
            }
        }
    }

    public function delete_course(Request $request){
        $check = Course::where('id', '=' , $request->course_id)->get();
        if (count($check)) {
            $validate = StudentCourse::where('course_id', '=' , $request->course_id)->get();
            if (count($validate)) {
                return response()->json(['status' => 'error', 'data' => 'Students Assigned to this Course!']);
            }else{
                $data['course_id'] = $request->course_id;  
                Course::findOrFail($data['course_id'])->delete($data['course_id']);
                return response()->json(['status' => 'success', 'data' => 'Course Deleted Successfully']);
            }
            
        }else{
            return response()->json(['status' => 'error', 'data' => 'Something Went Wrong!']);

        }
    }
}
