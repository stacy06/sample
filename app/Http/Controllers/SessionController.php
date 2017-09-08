<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\Http\Requests;
use Auth;

class SessionController extends Controller
{
    public function __construct()
    {
        //默认不设置的情况下是所有用户都能访问所有方法，进入到任何页面
        //只有未登录用户才能访问create方法进入登录页面，已登录用户不能访问
        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email'=>'required|email|max:255',
            'password'=>'required'
        ]);
        $credentials = [
            'email'=>$request->email,
            'password'=>$request->password
        ];
        if(Auth::attempt($credentials, $request->has('remember'))){// 判断该用户存在于数据库，且邮箱和密码相符合
            //登陆成功
            session()->flash('success','欢迎回来!');
            //intended方法会把路由定向到上一次请求的页面，如果没有则进入用户信息显示页面
            return redirect()->intended(route('users.show',[Auth::user()]));
        }else{
            //登陆失败
            session()->flash('danger','很抱歉您的邮箱和密码不匹配');
            return redirect()->back();
        }
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash("success","您已成功退出");
        return redirect()->route('login');
    }
}
