<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Status;

class StatusesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        //表单验证
        $this->validate($request,[
            'content'=>'required|max:140'
        ]);
        //微博创建
        Auth::user()->statuses()->create([
            'content'=>$request->content
        ]);
        //返回响应路由，返回原来页面
        return back();
    }

    public function destroy(Status $status)
    {
        $this->authorize('destroy', $status);
        $status->delete();
        session()->flash('success','您已成功删除一条微博');
        return back();
    }
}
