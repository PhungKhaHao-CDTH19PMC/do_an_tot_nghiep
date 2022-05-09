<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialAccount;
use Socialite;
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

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }
    public function createUser($getInfo, $provider)
    {
        $Account = User::where('email', $getInfo['email'])->first();

        if (empty($Account)) {
            $time = time();
          //  $random = Str::random(6);
        //    Storage::disk('avt')->put($time . $random . ".png", file_get_contents($getInfo->avatar));

            $user = new User();
            $user->fullname = $getInfo->name;
            $user->username =  preg_replace('/\s+/', '',$getInfo->name);
            $user->phone = "";
            $user->email = $getInfo->email;
          //  $user->avatar = $time . $random . ".png";
            // $user->birthday = "1900-01-01";
            $user->password = "";
           $user->citizen_identification = "";
           $user->role_id = 1 ;
           $user->department_id = 1 ;
            $user->remember_token = "";
            // $user->active = 1;
            // $user->status = 1;
            $user->save();
            if ($provider == "github") {
                $infouser = $getInfo->user;
                $opts = [
                    'http' => [
                        'method' => 'GET',
                        'header' => [
                            'User-Agent: PHP',
                        ],
                    ],
                ];

                $context = stream_context_create($opts);
                $json = file_get_contents($infouser["repos_url"], false, $context);
                $decode = json_decode($json);
            }
            return $user;
        }

        return $Account;
    }
    public function callback(Request $request, $provider)
    {
        $getInfo = Socialite::driver($provider)->stateless()->user();
        $user = $this->createUser($getInfo, $provider);
        auth()->login($user);
        return redirect()->to('/');
    }
    public function forgotPassword()
    {
         return view('modules.forgot-password.forgot-password');
       //  return Socialite::driver($provider)->redirect();
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
            $now = Carbon::now();
            $expired_time = $now->add(10, 'minute'); //thời gian hết hạn của otp
            user::where('id', $user->id)->update([ 'expired_time' => $expired_time->toDateTimeString()]);
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
        $now = Carbon::now()->toDateTimeString();

        $user=User::where('email',$data['email'])->first();  
        
        if($user!=null) 
        {
            if( $user->expired_time < $now)
            {
                return redirect('login')->with('error','Thời gian đã hết hạn');
            }
            $id=$user->id;
            $reset=user::find($id);
            $reset->password=Hash::make($data['password']);
            $reset->save();
            return redirect('login')->with('status','Mật khẩu cập nhật thành công');
        }else{
            return redirect('login')->with('error','Mã token đã hết hạn!!!');
        }
    }
}
