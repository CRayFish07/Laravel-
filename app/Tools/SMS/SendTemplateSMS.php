<?php
namespace App\Tools\SMS;

use App\Models\M3result;
class SendTemplateSMS{
    //主帐号,对应开官网发者主账号下的 ACCOUNT SID
private $accountSid= '8a216da85c09e9ba015c1a48cf5f08be';

//主帐号令牌,对应官网开发者主账号下的 AUTH TOKEN
    private $accountToken= '32588133269148229f0f1940bcd2e3fd';

//应用Id，在官网应用列表中点击应用，对应应用详情中的APP ID
//在开发调试的时候，可以使用官网自动为您分配的测试Demo的APP ID
    private $appId='8a216da85c09e9ba015c1a48cf9f08c2';

//请求地址
//沙盒环境（用于应用开发调试）：sandboxapp.cloopen.com
//生产环境（用户应用上线使用）：app.cloopen.com
    private $serverIP='sandboxapp.cloopen.com';


//请求端口，生产环境和沙盒环境一致
    private $serverPort='8883';

//REST版本号，在官网文档REST介绍中获得。
    private $softVersion='2013-12-26';


    /**
     * 发送模板短信
     * @param to 手机号码集合,用英文逗号分开
     * @param datas 内容数据 格式为数组 例如：array('Marry','Alon')，如不需替换请填 null
     * @param $tempId 模板Id,测试应用和未上线应用使用测试模板请填写1，正式应用上线后填写已申请审核通过的模板ID
     */
    public function sendTemplateSMS($to,$datas,$tempId)
    {
        $m3_result = new M3Result;

        // 初始化REST SDK
        $rest = new CCPRestSDK($this->serverIP,$this->serverPort,$this->softVersion);
        $rest->setAccount($this->accountSid,$this->accountToken);
        $rest->setAppId($this->appId);

        // 发送模板短信
        //  echo "Sending TemplateSMS to $to <br/>";
        $result = $rest->sendTemplateSMS($to,$datas,$tempId);
        if($result == NULL ) {
            $m3_result->status = 3;
            $m3_result->message = 'result error!';
        }
        if($result->statusCode != 0) {
            $m3_result->status = $result->statusCode;
            $m3_result->message = $result->statusMsg;
        }else{
            $m3_result->status = 0;
            $m3_result->message = '发送成功';
        }

        return $m3_result;
    }

}


//Demo调用 
		//**************************************举例说明***********************************************************************
		//*假设您用测试Demo的APP ID，则需使用默认模板ID 1，发送手机号是13800000000，传入参数为6532和5，则调用方式为           *
		//*result = sendTemplateSMS("13800000000" ,array('6532','5'),"1");																		  *
		//*则13800000000手机号收到的短信内容是：【云通讯】您使用的是云通讯短信模板，您的验证码是6532，请于5分钟内正确输入     *
		//*********************************************************************************************************************
//sendTemplateSMS("15697323025",array('2341','60'),"1");//手机号码，替换内容数组，模板ID
?>
