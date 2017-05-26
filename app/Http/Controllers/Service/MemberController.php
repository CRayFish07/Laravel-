<?php

namespace App\Http\Controllers\Service;

use App\Models\M3Email;
use Illuminate\Http\Request;
use App\Tools\ValidataCode;
use App\Http\Controllers\Controller;
use App\Models\M3result;
use App\Entity\Tmp_phone;
use App\Entity\Member;
use App\Entity\Tmp_email;
use App\Tools\UUID;
use Mail;

class MemberController extends Controller
{

    public function register(Request $request){
        $email = $request->input("email","");
        $phone = $request->input("phone","");
        $password = $request->input("password","");
        $confirm = $request->input("confirm","");
        $phone_code = $request->input("phone_code","");
        $validate_code = $request->input("validate_code","");

        $m3_result = new M3Result;

        if($email == '' && $phone == '') {
            $m3_result->status = 1;
            $m3_result->message = '手机号或邮箱不能为空';
            return $m3_result->toJson();
        }
        if($password == '' || strlen($password) < 6) {
            $m3_result->status = 2;
            $m3_result->message = '密码不少于6位';
            return $m3_result->toJson();
        }
        if($confirm == '' || strlen($confirm) < 6) {
            $m3_result->status = 3;
            $m3_result->message = '确认密码不少于6位';
            return $m3_result->toJson();
        }
        if($password != $confirm) {
            $m3_result->status = 4;
            $m3_result->message = '两次密码不相同';
            return $m3_result->toJson();
        }

        if ($phone!="") {
            $tmp_phone = Tmp_phone::where('phone', $phone)->first();
            if ($tmp_phone->code == $phone_code) {
                if (time() > strtotime($tmp_phone->deadline)) {
                    $m3_result->status = 5;
                    $m3_result->message = "验证码过期";
                    return $m3_result->toJson();
                }

                $member = new Member();
                $member->phone = $phone;
                $member->password = md5($password);
                $member->save();

                $m3_result->status = 0;
                $m3_result->message = "注册成功";
                return $m3_result->toJson();

            } else {
                $m3_result->status = 6;
                $m3_result->message = "验证码不符合";
                return $m3_result->toJson();
            }
        }
        else{
            $scode = $request->session()->get("valicode",'');
            if ($scode != $validate_code){
                $m3_result->status = 8;
                $m3_result->message = "验证码不符合";
                return $m3_result->toJson();
            }
            $member = new Member();
            $member->email = $email;
            $member->password = md5($password);
            $member->save();

            $uuid = UUID::create();
            $m3_email = new M3Email();
            $m3_email->to=$email;
            $m3_email->cc='819465103@qq.com';
            $m3_email->subject="微小的书店";
            $m3_email->content="请于24小时登录邮箱并验证,http://book.com/service/validate_email"."?mid=".$member->id."&code=".$uuid;
            Mail::send('email', ['m3_email' => $m3_email], function ($m) use ($m3_email) {
                $m->to($m3_email->to, "尊敬的用户")->subject($m3_email->subject)->cc($m3_email->cc);
            });
            $tmp_email = Tmp_email::where('member_id',$member->id)->first();
            if ($tmp_email==null){
                $tmp_email = new Tmp_email();
            }
            $tmp_email->member_id = $member->id;
            $tmp_email->code = $uuid;
            $tmp_email->deadline= date("Y-m-d:H-i-s",time()+24*60*60);
            $tmp_email->save();

            $m3_result->status = 0;
            $m3_result->message = "注册成功";
            return $m3_result->toJson();

        }

    }

    public function login(Request $request){
        $username = $request->input('username','');
        $password = $request->input('password','');
        $validatecode = $request->input('valicode','');
        $m3resul = new M3result();
        //验证
        if ($validatecode==$request->session()->get('valicode',''))
        {
            if (strpos($username,'@')==true){
                $member = Member::where('email',$username)->first();
            }
            else{
                $member = Member::where('phone',$username)->first();
            }
            if ($member==null){
                $m3resul->status=3;
                $m3resul->message="不存在的帐号";
                return $m3resul->toJson();
            }
            if ($member->password==md5($password)){
                $request->session()->put("member",$member);
                $m3resul->status=0;
                $m3resul->message="登录成功";
                return $m3resul->toJson();
            }
            else{
                $m3resul->status=2;
                $m3resul->message="密码不对";
                return $m3resul->toJson();
            }
        }
        else{
            $m3resul->status=1;
            $m3resul->message="验证码错误";
            return $m3resul->toJson();
        }


    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
