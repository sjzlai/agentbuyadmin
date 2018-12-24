@extends('home.layout.home')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('home/public/css/amazeui-c24a1a723c.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/public/css/reset-2be4611e36.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/public/css/animate-ebbc4d2531.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/public/css/base.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/public/css/icomoon-d0baa465fd.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/public/css/sprite.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('home/sign/css/login-2.css')}}">
@endsection
@section('content')
<section id="verifing">
    <div class="submission text-center">
        <div class="reg_title">
            <h3>新用户注册</h3>
        </div>
        <div class="process">
            <ul class="progressbar">
                <li class="active">注册信息</li>
                <li class="active">审核信息</li>
                <li class="active">审核进度</li>
            </ul>
        </div>
        <div class="content">
            <div>
                <img src="{{asset('home/images/checking.png')}}" alt="">
            </div>
            <p>正在审核</p>
            <p>我们会在2个工作日内将审核结果以短信方式通知您，请注意查收！</p>
            <p><span class="recordgoal">5</span>(s)后自动跳转至<a href="">登录页面</a></p>
        </div>
    </div>
</section>
@endsection
@section('script')
<script src="{{asset('home/public/js/lib/jquery-1.12.3.js')}}"></script>
<script src="{{asset('home/public/js/lib/amazeui.js')}}"></script>
<script src="{{asset('home/public/js/lib/amazeui.min.js')}}"></script>
<script src="{{asset('home/public/js/common/common.js')}}"></script>
<script src="{{asset('home/sign/js/login-2.js')}}"></script>
@endsection