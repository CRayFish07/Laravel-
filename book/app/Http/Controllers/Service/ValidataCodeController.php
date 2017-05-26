<?php

namespace App\Http\Controllers\Service;

use App\Models\M3result;
use Illuminate\Http\Request;
use App\Tools\ValidataCode;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tools\SMS\SendTemplateSMS;
use App\Entity\Tmp_phone;


class ValidataCodeController extends Controller
{
    public function create($value=""){
        $validatacode = new ValidataCode();
        return $validatacode->doimg();
    }

    public function  sendSMS(Request $request){
        $m3result = new M3result();
        $phone = $request->input("phone",'');
        $phone='15697323025';
        if ($phone=='');
        {
//            $m3result->status=1;
//            $m3result->message="号码为空";
//            return $m3result->toJson();
        }
        $charset = '0123456789';//随机因子
        $_len = strlen($charset)-1;
        $code="";
        for ($i = 0;$i < 4 ;++$i) {
            $code .= $charset[mt_rand(0, $_len)];
        }
        $sms = new SendTemplateSMS;
//        $sms->sendTemplateSMS($phone,array($code,'60'),'1');

        $tmp_phone = new Tmp_phone();
        $tmp_phone->phone = $phone;
        $tmp_phone->code = $code;
        $tmp_phone->deadline = date("Y-m-d:H-i-s",time()+60*60);
        $tmp_phone->save();
        $m3result->status=0;
        $m3result->message="ok";
        return $m3result->toJson();

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
