<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\SignUp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function index()
    {
        $users=User::whereUserType(2)->get();
        return response()->json([
            "status"      =>'Success',
            "data"        =>$users,
        ]);
    }


///////////////////////.......Login Api Section........./////////////////////

    public function login(Request $request)
    {

        $credentials= $request->validate([
            'email' => 'required|exists:Users,email',
            'password'      =>'required|min:7',
        ]);
        try {

            $user= User::whereEmail($request->email)->first();

            if($user && Hash::check($request->password,$user->password) && $request->user_type== 1){
                $token = $user->createToken("name")->plainTextToken;
                return response()->json([
                    "status"      =>'Login Successfully',
                    "token"       =>$token,
                    "data"        =>$user,
                ]);
            }else{
                return response()->json([
                    "status"     => 'Login failed',
                ]);
            }
        } catch (\Exception $e) {
            return  $e->getMessage() . "on line" . $e->getLine();

        }
    }
///////////////////////.......SignUp Api Section........./////////////////////

    public function signUp(Request $request)
    {
        $request->validate([
            'first_name'     => 'required',
            'last_name'     => 'required',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|min:7',
            'device_name'   => 'required',
        ]);
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $profile_image= $file->move('uploads/profile_image/' , $filename);

        }
        if($request['id'] == ""){
            $user= User::create([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'profile_image' =>$profile_image,
                'password' => Hash::make($request['password']),
                'status'   =>1,
                'user_type'=>2,
            ]);

            Auth::login($user);
            $token = $request->user()->createToken($request->device_name)->plainTextToken;
            return  response()->json([
                "status"     =>'success',
                "token"      =>$token,
                "user"   =>$user->first(),
            ]);
        }else{
            return  response()->json([
                "status" =>'failed',
            ]);
        }

    }
///////////////////////.......forget Api........./////////////////////

            public function forget(Request $request){
            $request->validate([
                'email' => 'required|exists:Users,email',
            ]);
            $user= User::whereEmail($request->email);
            if($user->first()) {
                $code = rand(1001, 99999);
                $user->update(['code'=> $code]);
                Mail::to($user->first()->email)->send(new SignUp($code));
                return  response()->json([
                    "status" =>'success',
                    "mail_OTP" =>$code,
                ]);
            }else{
                return  response()->json([
                    "status" =>'failed',
                ]);
            }
        }
    ///////////////////////.......forget Api Section........./////////////////////
    public function reset(Request $request){
        $request->validate([
            'code' => 'required|exists:Users,code',
            'password'=> 'required|min:7',
        ]);
        $user= User::whereCode($request['code']);
        if($request['code']){
            $code=rand(1001,99999);
            $user->update(['password'=>\Hash::make($request['password']),'code'=>$code]);
            return  response()->json([
                "status" =>'success',
            ]);
        }else{
            return  response()->json([
                "status" =>'failed',
            ]);
        }
    }
///////////////////////.......userUpdate Api Section........./////////////////////
    public function update(Request $request)
    {
        $request->validate([
            'first_name'     => 'required',
            'last_name'     => 'required',
            'email'         => 'required',
            'password'      => 'required|min:7',
            'device_name'   => 'required',
        ]);
        $user=Auth::user();
        try {
            if ($request->hasFile('profile_image')) {
                $file = $request->file('profile_image');
                $extention = $file->getClientOriginalExtension();
                $filename = time() . '.' . $extention;
                $profile_image= $file->move('uploads/update/profile_image/' , $filename);

            }
            if(!empty($request->email) && $request->email !== $user->email) {
                $email_count =  User::whereEmail($request->email)->count();
                if($email_count !== 0){
                    return response()->json([
                        "status" => 'error',
                        "message" => 'duplicate entry'
                    ]);
                }
            }

            $user->update([
                'first_name' => $request['first_name'],
                'last_name' => $request['last_name'],
                'email' => $request['email'],
                'profile_image' => $profile_image,
                'password' => Hash::make($request['password']),
                'status'   =>0,
                'user_type'=> 2,
            ]);


                return  response()->json([
                    "status" =>'success',
                    "user"   => Auth::user()->first(),
                ]);

        } catch (\Exception $e) {
            return  $e->getMessage() . "on line" . $e->getLine();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
