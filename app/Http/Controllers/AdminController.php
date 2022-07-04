<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Yajra\DataTables\DataTables;

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
           if (Auth::attempt(['email' => $request['email'], 'password' => $request['password'] ,'user_type' => 1],)) {
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
   //////////......LogIn with Facebook...............////////////

    public function redirectToFacebook(){
        return Socialite::driver('facebook')->redirect();
    }
    public function handleFacebookCallback(){
      $user=Socialite::driver('facebook')->user();
        $social_media_id = $user->getId();
        $name = $user->getName();
         $nick_name = $user->getNickname();
        $email = $user->getEmail();
        $avator=$user->getAvatar();

       $user_data=([
            'first_name'=>$name,
           'last_name'=>$nick_name,
           'email'=> $email,
            'profile_image'=>$avator,
            'social_id'=>$social_media_id,
            'user_type'=>2,
           'password' => Hash::make(rand(1001,99999)),
        ]);

       $user=User::whereSocialId($social_media_id)->first();
       if(!$user){
           $new_users=User::create($user_data);
           Auth::login($new_users);
           Session::flash('success', 'Login Successfully');
           return redirect('dashboard');
       }else{
           Auth::login($user);
           Session::flash('success', 'Login Successfully');
           return redirect('dashboard');
       }

    }

//    //////////...... Facebook callback ...............////////////

    public function dashboard()
    {
        return view('Admin.Dashboard');
    }

    public function privacy(){
        return view('Privacy.index');
    }

    public function usersList(){
        $users = User::whereUserType(2)->get();
        return DataTables::of($users)
            ->editColumn('created_at',function ($row){
                return   Carbon::create($row->created_at)->format('Y-m-d');
            })
            ->addColumn('action',function ($users){
                $button='';
                if($users->status == "1"){
                    $button.='<a type="button" href="'. url("change_status/".$users->id) .'" class="btn btn-danger">Suspended</a>';
                }elseif($users->status == "0"){
                    $button.='<a type="button" href="'. url("change_status/".$users->id) .'" class="btn btn-success">Active</a>';
                }else{

                }
                return $button;
            })->addColumn('status',function ($users){
                return $users->status==='1'?"Active":"Suspended";
            })->rawColumns(['action'])->make(true);
    }
        public function changeStatus($id){
         $user= User::whereId($id)->first();
          if($user->status == 1){
              $user->update([
                  'status' => 0,
              ]);
              Session::flash('success','Status Change Successfully');
              return redirect('dashboard');
          }elseif (($user->status == 0))
              $user->update([
                  'status' => 1,
              ]);
            Session::flash('success','Status Change Successfully');
            return redirect('dashboard');
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
