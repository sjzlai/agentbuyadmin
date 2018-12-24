<?php

namespace App\Http\Controllers\Home;

use App\Models\Admin;
use App\Models\ApplyInfo;
use App\Models\CompanyInfo;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Http\Common\SmsRest;

class SignController extends Controller
{
    /**
     * Notes:用户注册
     * Author:sjzlai
     */
    public function index()
    {
        return view('home.sign.sign-index');
    }

    public function store(Request $request)
    {
        if ($request->isMethod('post')) {
            $validator = $this->validateRegister($request->input());
            if ($validator->fails()) {
                return back()->withErrors('message',$validator)->withInput();
            }
             $user = new Admin();
             $user->company_name = $request->company_name;
             $user->password = md5(md5($request->password));
             $user->realname = $request->realname;
             $user->phone   = $request->phone;
             $user->created_at = time();
             $user->updated_at = time();
             $user->level = 0;
             //验证码
//             $classifyCode=$this->code();
             $code=$request->input('verifyCode');
             $classifyCode=session()->get('user.code');
             //判断用户名是否存在
           // $company = Admin::where('company_name','=',$request->company_name)->first();
            //dd($company);
//            if (!empty($company->company_name)){
//                if ($company->company_name = $user->company_name)
//                return back()->withErrors('error','公司名称已存在')->withInput();
//            }else{
             if ($code==$classifyCode){
                 $user->classify_code=$code;
                 if($user->save()){
//                 $Id = DB::getPdo()->lastInsertId();
                     $adminId=$user->admin_id;
//                 return redirect('/sign/register/'.$adminId)->with('success', '注册成功！');
                     return view('home.sign.sign-one',compact('adminId'));
                 }else{
                     return back()->withErrors( '注册失败！');
                 }
             }else{
                 return back()->withErrors('验证码错误！！');
             }
         }

         return view('home.sign.sign-index');

    }

    public function errorSign($adminId)
    {

        return view('home.sign.sign-one',compact('adminId'));
    }

    /**
     * Notes:账号验证
     * Author:sjzlai
     */
    protected function validateRegister(array $data)
    {
        return Validator::make($data, [
            'company_name' => 'required|alpha_num|max:255',
            'password' => 'required|min:8|confirmed',
            'password_confirmation' => 'required|min:8|'
        ], [
            'required' => ':attribute 为必填项',
            'min' => ':attribute 长度不符合要求',
            'confirmed' => '两次输入的密码不一致',
            'alpha_num' => ':attribute 必须为公司名称'
        ], [
            'company_name' => '用户名',
            'password' => '密码',
            'password_confirmation' => '确认密码'
        ]);
    }

    public function registerStore(Request $request)
    {
        $data = $request->except('_token','erlei','wangluo','yingye','faren');

        $adminId = $request->input('admin_id');
        $erlei = $request->file('erlei');
        $wangluo = $request->file('wangluo');
        $yingye = $request->file('yingye');
        $faren = $request->file('faren');
        $apply['second_record'] = pic($erlei,'uploads/erlei');
        $apply['network_sales_pic'] = pic($wangluo,'uploads/wangluo');
        $apply['business_license'] = pic($yingye,'uploads/yingye');
        $apply['corporate_identity_card_info'] = pic($faren,'uploads/faren');
        $apply['admin_id'] = $adminId;
        $apply['status'] = 1;
        $applyRes = ApplyInfo::insertGetId($apply);  //添加公司资质信息
        $admininfo = Admin::find($adminId); //更新用户信息审核状态,代理级别,推荐人
        $admininfo->level = $data['level'];
        $admininfo->referee = $data['referee'];
        $admininfo->check_status =0;
        $admininfo->save();
        //添加公司地址等信息

        $companyinfo = array(
            'company_address' =>$data ['company_area'],
            'province'  => $data['province'],
            'city'      => $data['city'],
            'status'    => 1,
            'user_id'   => $adminId,
            'agent_apply_info_id' => $applyRes
        );
        $company_info = CompanyInfo::create($companyinfo);
 //       dd($company_info);
        if ($company_info){
            //更改表admin用户check_status状态
            Admin::where('admin_id',$adminId)->update(['check_status'=>1]);
            return view('home.sign.sign-two');
        }else{
            return Redirect::to('/sign/register');
        }
    }
    /*
        public function registerStore(Request $request )
        {
            $data = $request->except('_token','erlei','wangluo','yingye','faren','admin_id');

            $adminId = $request->input('admin_id');
    //        dd($adminId);
            $erlei = $request->file('erlei');
            $wangluo = $request->file('wangluo');
            $yingye = $request->file('yingye');
            $faren = $request->file('faren');
            $apply['second_record'] = pic($erlei,'uploads/erlei');
            $apply['network_sales_pic'] = pic($wangluo,'uploads/wangluo');
            $apply['business_license'] = pic($yingye,'uploads/yingye');
            $apply['corporate_identity_card_info'] = pic($faren,'uploads/faren');
            $apply['admin_id'] = $adminId;
            $apply['status'] = 1;
            //查询表agentApplyInfo中是否有相应的数据,有则修改,无则添加
            //$oldApplyRes = ApplyInfo::where('admin_id','=',$adminId)->first();
            //dd($oldApplyRes);
    //        if ($oldApplyRes){
    //            $applyRes = ApplyInfo::where('admin_id','=',$adminId)->save($apply);  //更新公司资质
    //
    //            $admininfo = Admin::find($adminId); //更新用户信息审核状态,代理级别,推荐人
    //            $admininfo->level = $data['level'];
    //            $admininfo->referee = $data['referee'];
    //            $admininfo->check_status = 0;
    //            $admininfo->save();
    //
    //            //添加公司地址等信息
    //            $companyinfo = array(
    //                'company_address' =>$data ['company_area'],
    //                'province'  => $data['province'],
    //                'city'      => $data['city'],
    //                'status'    => 1,
    //                'agent_apply_info_id' => $applyRes
    //            );
    //            $company_info = CompanyInfo::where('user_id','=',$adminId)->save($companyinfo);
    //        }else {
    //        dd($apply);
                $applyRes = ApplyInfo::insertGetId($apply);  //添加公司资质信息

                $admininfo = Admin::find($adminId); //更新用户信息审核状态,代理级别,推荐人
                $admininfo->level = $data['level'];
                $admininfo->referee = $data['referee'];
                $admininfo->check_status = 0;
                $admininfo->save();
               // dd($admininfo);
                //添加公司地址等信息
            if ($admininfo){
                $companyinfo = array(
                    'company_address' =>$data ['company_area'],
                    'province'  => $data['province'],
                    'company_email' => $data['company_email'],
                    'city'      => $data['city'],
                    'status'    => 1,
                    'user_id'   => $adminId,
                    'agent_apply_info_id' => $applyRes
                );
                dd($companyinfo);
                $company_info = CompanyInfo::create($companyinfo);
    //        }
                // dd($company_info);
            if ($company_info){
                //更改表admin用户check_status状态
                Admin::where('admin_id',$adminId)->update(['check_status'=>1]);
    //            return Redirect('sign/register/SignAuditing')->send();
                return view('home.sign.sign-two');
            }else{
                return Redirect::to('/sign/register/');
            }
            }

        }*/
//
//    public function signTwo()
//    {
//        return view('home.sign.sign-two');
//    }

/*
 * 短信接口
 * */
    public function code()
    {
        $phone = $_POST['phone'];
        if ($phone){
            $smsPhone =new SmsRest();
            $randCode=$this->CodeRandom();
            $data = $smsPhone->sendTemplateSMS($phone,array($randCode,'15'),"383907");
            \Session::put('user.code',$randCode);
            return Response([
                'code' =>'1' ,
                'message' =>'message' ,
                'data' => $data
            ]);
        }
    }

    /**
     * Notes:随机码
     * Author:sjzlai
     */
    public function CodeRandom()
    {
        $ranString='';
        for ($i=0;$i<=3;$i++){
            $ranString.=rand(0,9);
        }
        return $ranString;
    }


}
