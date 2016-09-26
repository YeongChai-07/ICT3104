<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;

use Auth;
use Hash;
use DB;
use Session;

class UserController extends Controller {


	public function displayLogin()
	{
		$users = User::all();
		return view('user.login')->with([
            'users' => $users
            ]);
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
            return redirect('user/login');
        }


        //Check for inputs with users table
        if( auth()->guard('web')->attempt(['email' => $data['email'], 'password' => $data['password']]))
        {
            //return auth()->guard('web')->user();
            Session::forget('error_message');

            return redirect('user/index');
        }
        else
        {
            Session::set('error_message', "Invalid Login");
            return redirect('user/login');
          
        }
	}
	
    public function index()
    {
        $adminId = auth()->guard('web')->user()->id;

        $students = DB::table('students')->paginate(5);
        return view('user.index')->with([
            'students' => $students
            ]);
    }

    public function showHod()
    {
        $adminId = auth()->guard('web')->user()->id;

        $hods = DB::table('hod')->paginate(5);
        return view('user.hod')->with([
            'hods' => $hods
            ]);
    }

    public function showLecturer()
    {
        $adminId = auth()->guard('web')->user()->id;

        $lecturers = DB::table('lecturer')->paginate(5);
        return view('user.lecturer')->with([
            'lecturers' => $lecturers
            ]);
    }


    public function logout(Request $request)
    {
        auth()->guard('web')->logout();
        $request->session()->flush();
        return redirect('user/login');
    }
}