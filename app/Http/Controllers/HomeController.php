<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

use App\Models\User;

class HomeController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('dashboard')->with('status','Đăng nhập thành công');
        }
        return back()->with('error','Đăng nhập thất bại');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('modules.forgot-password.forgot-password');
    }

    public function sendTokenForgotPassword(Request $request)
    {
        $data = $request->all();
        $now=Carbon::now('Asia/Ho_Chi_Minh')->format('d-m-Y H:i:s');
        $title_email="Lấy lại mật khẩu Elearning".' ' .$now;
        
        $token_random=Str::random(40);
        $user=User::where('email','=',$data['email'])->first();
        if($user==null) 
        {
            return redirect()->back()->with('error','Email chưa được đăng kí!!');
        }
        else{
            $id=$user->id;
            $token_random=Str::random(40);
            $user=user::find($id);
            $user->token=$token_random;
            $user->save();
            //send email notification
            $to_email=$user->email;//gui den email nay 
            $link_reset_password=url('/update-new-password?email='.$to_email.'&token='.$token_random);
            $data=array(
                "name"=>$title_email,
                "body"=>$link_reset_password,
                'email'=>$data['email'],
                "hoten"=>$user->ho_ten);//body email
            Mail::send('modules.forgot-password.email-forgot-password',['data'=>$data],function($message)use ($title_email,$data){
                $message->to($data['email'])->subject($title_email);
                $message->from($data['email'],"Elearning");
            });
            return redirect()->back()->with('status','Gửi thành công! Vui lòng kiểm tra email để đặt lại mật khẩu.');
        }
    }

    public function updateNewPassword()
    {
        return view('modules.forgot-password.reset-password');
    }

    public function resetNewPassword(Request $request)
    {
        $data = $request->all();
        $token_random=Str::random(40);
        
        $user=User::where('email',$data['email'])->where('token',$data['token'])->first();  
        
        if($user!=null) 
        {
            $id=$user->id;
            $reset=user::find($id);
            $reset->password=Hash::make($data['password']);
            $reset->token=$token_random;
            $reset->save();
            return redirect('login')->with('status','Mật khẩu cập nhật thành công');
        }else{
            return redirect('login')->with('error','Mã token đã hết hạn!!!');
        }
    }
}
