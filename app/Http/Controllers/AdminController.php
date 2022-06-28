<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{

    public function index()
    {
        return view('login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:7',

        ]);

        try {
            if (Auth::attempt(['username' => $request['email'], 'password' => $request['password']],)) {
                Session::flash('success', 'Login Successfully');
                return redirect('dashboard');
            } elseif (Auth::attempt(['email' => $request['email'], 'password' => $request['password']], )) {

                Session::flash('success', 'Login Successfully');
                return redirect('dashboard');
            } else {
                Session::flash('error', 'Login Failed');
                return redirect('login');
            }
        } catch (\Exception $e) {
            return $e->getMessage() . "on line" . $e->getLine();

        }
    }



    public function dashboard()
    {
        return view('Admin.Dashboard');
    }

    public function logout(Request $request){
            Auth::logout();
        Session::flash('success','Logout Successfully');
        return redirect('/');
    }

    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        //
    }
}
