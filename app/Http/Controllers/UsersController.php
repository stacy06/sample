<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\User;
use Auth;

class UsersController extends Controller
{
    public function __construct()
    {
        //除了用户信息展示、注册和保存功能，用户相关的其他的路由功能都需要用户登陆后才能访问
        $this->middleware('auth',[
            'except'=>['create','store','index','show']
        ]);
        //只有未登录用户才能访问注册页面，已登录用户则不能访问
        $this->middleware('guest',[
            'only'=>['create']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name'=> 'required|max:50',
            'email'=>'required|email|unique:users|max:255',
            'password'=>'required'
        ]);

        $user = User::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>bcrypt($request->password),
        ]);
        Auth::login($user);
        session()->flash('success','恭喜您注册成功，您将在这里开启一段新的旅程~');
        //return redirect()->route('users.show',[$user]);
        return redirect()->route('users.show',$user);
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update',$user);  //验证是否是同一个用户，是否有权限更改
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name'=>'required|max:50',
            'password'=>'nullable|confirmed|min:6'
        ]);

        $this->authorize('update',$user);  //验证是否是同一个用户，是否有权限更改

        $data=[];
        $data['name']=$request->name;
        if($request->password){
            $data['password']=bcrypt($request->password);
        }
        $user->update($data);
        session()->flash('success','用户信息更新成功');
        //return redirect()->route('users.show',$user->id);
        return redirect()->route('users.show',$user);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index',compact('users'));
    }

    public function destroy(User $user)
    {
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success','成功删除用户！');
        return back();
    }
}
