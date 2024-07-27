<?php

namespace App\Http\Controllers;

use App\Course;
use App\StudentCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        // if (Auth::check() && Auth::user()->isAdmin()) {
        //     return redirect('/admin/dashboard');
        // }
        return view('home');

    }
    public function view_course(){
        $data['courses'] = Course::all();
        $data['student_courses'] = StudentCourse::join('courses', 'student_courses.course_id', '=', 'courses.id')
        ->where('student_courses.user_id', '=', Auth()->user()->id)
        ->select('courses.*', 'student_courses.id as assign_id')
        ->get();
        return view('course')->with($data);
    }

    public function assign_course(Request $request){
        // Process the request data
        $data = $request->all();
        $check = StudentCourse::where('course_id', '=' , $request->course_id)->where('user_id', '=' , Auth()->user()->id)->get();
        // Return a response
        if (count($check)) {
            return response()->json(['status' => 'error', 'data' => 'Course Already Assigned']);
            
        }else{
            $data['user_id'] = Auth()->user()->id;
            $data['course_id'] = $request->course_id;
            StudentCourse::create($data);
            return response()->json(['status' => 'success', 'data' => 'Course Successfully Assigned']);

        }
    }

    public function my_course(){
        $data['courses'] = Course::all();
        $data['student_courses'] = StudentCourse::join('courses', 'student_courses.course_id', '=', 'courses.id')
        ->where('student_courses.user_id', '=', Auth()->user()->id)
        ->select('courses.*', 'student_courses.id as assign_id')
        ->get();
        return view('myCourse')->with($data);
    }
}
