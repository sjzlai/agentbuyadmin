<?php

namespace App\Http\Controllers\Home;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    //登陆视图
    public function login()
    {
        
	return view('home.login.login');
    }

    //验证码
    public function code()
    {
        imgCode();
    }

    //登陆操作
    public function store(Request $request)
    {
        $user = $request->except('_token');
        //dd($user);
        if (strtoupper($user['code']) != strtoupper(session('code')))
            return back()->withErrors('验证码错误');
        if ($user['username'] == '' || $user['pwd'] == '') {
            return back()->withErrors('账号或密码错误');
            exit();
        }
        //exit(md5(md5('12345678')));
        //exit(bcrypt('12345678'));
//        $userinfo = DB::table('company_info')->get();


        $userinfo = DB::table('admin')
            ->where(['company_name'=> $user['username'], 'password'=>md5(md5($user['pwd']))])
            ->first();
       if (empty($userinfo)){
           return back()->withErrors('账号或密码错误');
           exit();
       }
        if($userinfo->check_status ===1 ){
            return view('home.sign.sign-three',['user'=>$userinfo]);
            exit();
        }elseif($userinfo->check_status === 3){
            return view('home.sign.sign-three',['user' =>$userinfo]);
            exit();
        }
        if (!$userinfo) {
            return back()->withErrors( '账号或密码错误');
        } else {
            Session::put('user.id',$userinfo->admin_id);
            Session::put('user.name',$userinfo->company_name);
            //if ($userinfo->check_status == 0){return  view('home.sign.sign-one',['adminId'=>$userinfo->admin_id]);}
            if ($userinfo->check_status == 1){ return  view('home.sign.sign-two');}
            return Redirect::to('/index');
        }
    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        Session()->flush();
        return Redirect::to('/');
    }

}
