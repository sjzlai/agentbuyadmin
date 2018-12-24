@extends('home.layout.home')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{asset('/home/sign/css/index.css')}}">
@endsection
@section('content')
    <section id="new_register">
        <div class="submission text-center">
            <div class="reg_title">
                <h3>新用户注册</h3>
            </div>
            <div class="process">
                <ul class="progressbar">
                    <li class="active">注册信息</li>
                    <li>审核信息</li>
                    <li>审核进度</li>
                </ul>
            </div>
            <div class="content">
                <form action="{{url('/sign/store')}}" class="new_user" method="post"  data-am-validator>
                    {!! csrf_field() !!}
                    <div>
                        <label for="">&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul style="color:red;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{  $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label for="">用户名：</label><input type="text" name="company_name" placeholder="公司名称" required data-msg-required="*" minlength="3" data-msg-minlength="*" id="company_name">
                    </div>
                    <div>
                        <label for="">登录密码：</label><input  type="password" id="password"  name="password" placeholder="请输入密码 " minlength="8" maxlength="16"  pattern="^\w{8,16}$" required>
                        <span>密码由8-16位数字、字母、下划线组成</span>
                    </div>
                    <div>
                        <label for="">确认密码：</label><input id="sure_pass" type="password" name="password_confirmation"  data-equal-to="#password" placeholder="请输入密码" required>
                        <span>请保证两次输入密码一致</span>
                    </div>
                    <div>
                        <label for="">联系人：</label><input type="text" placeholder="请输入联系人" name="realname"  required data-msg-required="*" minlength="2" data-msg-minlength="*">
                    </div>
                    <div>
                        <label for="">电子邮箱：</label><input type="text" id="email" name="email" placeholder="请输入电子邮箱" pattern="^[a-z0-9]+([._\\-]*[a-z0-9])*@([a-z0-9]+[-a-z0-9]*[a-z0-9]+.){1,63}[a-z0-9]+$" required>
                    </div>
                    <div>
                        <label for="">联系电话：</label><input type="text" placeholder="请输入联系电话" class="phone" name="phone"   required data-msg-required="*" minlength="11" data-msg-minlength="*">
                    </div>
                    <div class="get_yzm">
                        <label for="">验证码：</label><input type="text" placeholder="请输入验证码" name="verifyCode" required data-msg-required="*" minlength="4" maxlength="4" data-msg-minlength="*">
                        <input type="button" value="获取验证码" style="width: 150px" id="sendVerifySmsButton" class="codePhone">
                    </div>
                    <div class="submit">
                        {{--<button >注册</button>--}}
                        <input type="submit" value="注册" id="submit">
                    </div>
                </form>  
            </div>
        </div>
    </section>
    @section('script')
    <script src="{{asset('/js/laravel-sms.js')}}"></script>
    <script src="{{asset('/home/sign/js/index.js')}}"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
    <script src="{{asset('/home/public/js/common/ajax.js')}}"></script>
    {{--<script src="{{asset('/home/personal/js/shopping_record.js')}}"></script>--}}
    <script>
        $(".codePhone").click(function(e){
        //清楚默认事件 因为界面有两个button所以被点击的时候都会触发
        e.preventDefault();
        $.ajax({
        url:'/sign/code',
        type:'POST',
        data:{ '_token':'{{csrf_token()}}',
        'phone':$(".phone").val(),
        },
        success:function(data){
        console.log(data);
        }
        });
        });
    </script>
    @endsection
{{--@section('script')--}}
    {{--$('#sendVerifySmsButton').sms({--}}
        {{--//laravel csrf token--}}
        {{--token       : "{{csrf_token()}}",--}}
        {{--//请求间隔时间--}}
        {{--interval    : 60,--}}
        {{--//请求参数--}}
        {{--requestData : {--}}
            {{--//手机号--}}
            {{--mobile : function () {--}}
                {{--return $('input[name=phone]').val();--}}
            {{--},--}}
            {{--//手机号的检测规则--}}
             {{--mobile_rule : 'mobile_required'--}}
        {{--}--}}
    {{--});--}}

{{--@endsection--}}

@endsection