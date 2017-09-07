@extends('layouts/default')
@section('title','用户信息页面')

@section('content')
{{$user->name}}--{{$user->email}}
@stop
