<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Student;

use Auth;
use Hash;
use DB;
use Session;

class StudentController extends Controller {


	public function displayLogin()
	{
		return view('student.login');
	}
	
	public function login(Request $request)
	{

		$data = $request->only(['email', 'password']);
        $validator = validator($request->all(),[
        'email' => 'required|min:3|max:100',
        'password' => 'required|min:3|max:100',

        ]);

        //Validate inputs
        if ($validator -> fails())
        {
            Session::set('error_message', "Invalid Login");
            return redirect('student/login');
        }


        //Check for inputs with users table
        if( auth()->guard('student')->attempt(['studentemail' => $data['email'], 'password' => $data['password']]))
        {
            //return auth()->guard('student')->user();
            Session::forget('error_message');

            return redirect('student/index');
        }
        else
        {
            Session::set('error_message', "Invalid Login");
            return redirect('student/login');
            
        }
	}

    public function index()
    {
        $studentId = auth()->guard('student')->user()->studentid;

        $grades = DB::table('grades')
                ->where('studentid',$studentId)->paginate(5);

        return view('student.index')->with([
            'grades' => $grades
            ]);      
    }



    public function logout(Request $request)
    {
        auth()->guard('student')->logout();
        $request->session()->flush();
        return redirect('student/login');
    }

    // public function viewGrade(){
    //     $studentId = auth()->guard('student')->user()->studentid;

    //     $grades = DB::table('grades')
    //             ->where('studentid',$studentId)
    //             ->paginate(5);

    // }
}