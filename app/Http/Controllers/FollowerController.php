<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;

class FollowerController extends Controller
{
    public function __construct()
    {
        //所有方法在访问时都需要是已登录鉴权的用户才可以，否则会转到登陆页面
        $this->middleware('auth');
    }

    //关注用户
    public function store(User $user)
    {
        if(Auth::user()->id === $user->id){
            return redirect('/');
        }
        if(!Auth::user()->isFollowing($user->id)){
            Auth::user()->follow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }

    //取消关注用户
    public function destroy(User $user)
    {
        if(Auth::user()->id === $user->id){
            return redirect('/');
        }
        if(Auth::user()->isFollowing($user->id)){
            Auth::user()->unfollow($user->id);
        }
        return redirect()->route('users.show', $user->id);
    }
}
