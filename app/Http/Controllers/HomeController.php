<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\SocialAccount;
use Socialite;
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
}
