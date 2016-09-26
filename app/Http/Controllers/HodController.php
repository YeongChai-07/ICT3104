<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Hod;

use Auth;
use Hash;
use DB;
use Session;

class HodController extends Controller {


	public function displayLogin()
	{
		return view('hod.login');
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
            return redirect('hod/login');
        }


        //Check for inputs with users table
        if( auth()->guard('hod')->attempt(['hodemail' => $data['email'], 'password' => $data['password']]))
        {
            //return auth()->guard('hod')->user();
            Session::forget('error_message');

            return redirect('hod/index');
        }
        else
        {
            Session::set('error_message', "Invalid Login");
            return redirect('hod/login');
            
        }
	}

    public function index()
    {
        return view('hod.index');
    }


    public function logout(Request $request)
    {
        auth()->guard('hod')->logout();
        $request->session()->flush();
        return redirect('hod/login');
    }

}