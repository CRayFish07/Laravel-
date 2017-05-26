<?php

namespace App\Http\Controllers\Service;

use App\Entity\Member;
use App\Models\M3result;
use Illuminate\Http\Request;
use App\Tools\ValidataCode;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tools\SMS\SendTemplateSMS;
use App\Entity\Tmp_phone;
use App\Entity\Tmp_email;

class ValidataCodeController extends Controller
{
    public function create(Request $request){
        $validatacode = new ValidataCode();
        $request->session()->put('valicode',$validatacode->getCode());
        return $validatacode->doimg();
    }

    public function  sendSMS(Request $request){
        $m3result = new M3result();
        $phone = $request->input('phone', '');
        if($phone=="")
        {
            $m3result->status=1;
            $m3result->message="号码为空";
            return $m3result->toJson();
        }
        $charset = '0123456789';//随机因子
        $_len = strlen($charset)-1;
        $code="";
        for ($i = 0;$i < 4 ;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $sms = new SendTemplateSMS;
        $sms->sendTemplateSMS($phone,array($code,'60'),'1');

        $tmp_phone = Tmp_phone::where('phone',$phone)->first();
        if ($tmp_phone==null){
            $tmp_phone = new Tmp_phone;
        }
        $tmp_phone->phone = $phone;
        $tmp_phone->code = $code;
        $tmp_phone->deadline = date("Y-m-d:H-i-s",time()+60*60);
        $tmp_phone->save();
        $m3result->status=0;
        $m3result->message="ok";
        return $m3result->toJson();

    }

    public function validate_email(Request $request){
        $id = $request->input("mid","");
        $code = $request->input("code","");

        $tmp_email = Tmp_email::where("member_id",$id)->first();
        if ($tmp_email==null){
            return "验证异常";
        }
        else{
            if ($code==$tmp_email->code)
            {
                if (time()>strtotime($tmp_email->deadline)){
                    return "验证码超时";
                }
                else{
                    $member = Member::find($id);
                    $member->active=1;
                    $member->save();
                    return "验证成功";
                }
            }
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
