<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Lecturer;
use App\Module;

use Auth;
use Hash;
use DB;
use Session;

class LecturerController extends Controller {


	public function displayLogin()
	{
		return view('lecturer.login');
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
            return redirect('lecturer/login');
        }


        //Check for inputs with users table
        if( auth()->guard('lecturer')->attempt(['lectureremail' => $data['email'], 'password' => $data['password']]))
        {
            //return auth()->guard('lecturer')->user();
            Session::forget('error_message');

            return redirect('lecturer/index');
        }
        else
        {
            Session::set('error_message', "Invalid Login");
            return redirect('lecturer/login');
            
        }
	}

    public function index()
    {
        $lecturerId = auth()->guard('lecturer')->user()->lecturerid;

        // $grades = DB::table('grades')
        //         ->where('studentid',$studentId)->paginate(5);


        $modules = DB::table('module')
            ->where('module.lecturerid', $lecturerId)->paginate(5);    


        return view('lecturer.index')->with([
            'modules' => $modules
            ]);  
    }


    public function logout(Request $request)
    {
        auth()->guard('lecturer')->logout();
        $request->session()->flush();
        return redirect('lecturer/login');
    }

    public function showManageGrade(Request $request, $id){

            $moduleid = $id;

            $module = Module::findorFail($id);


            $grades = DB::table('module')
            ->join('grades', 'grades.moduleid', '=', 'module.id')
            ->join('students','students.studentid', '=', 'grades.studentid')
            ->select('module.*','grades.*','students.*')
            ->where('grades.moduleid', $moduleid)->paginate(5);    

           
        return view('lecturer.managegrade')->with([
            'grades' => $grades,
            'module' => $module
            ]); 
    }

}