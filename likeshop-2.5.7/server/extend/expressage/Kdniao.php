<?php

namespace expressage;
use app\common\server\ConfigServer;
use Requests;

class Kdniao extends Expressage
{


    public function logistics($code, $number)
    {
        $request_daata = "{'OrderCode':'','ShipperCode':'$code','LogisticCode':'$number'}";

        $datas = array(
            'EBusinessID' => $this->app,
            'RequestType' => '1002',
            'RequestData' => urlencode($request_daata),
            'DataType' => '2',
        );

        //快递鸟请求接口类型
        $request_type = ConfigServer::get('kdniao', 'type', 'free');
        $search_url = 'https://api.kdniao.com/Ebusiness/EbusinessOrderHandle.aspx';
        //为付费类型时调整请求指令
        if ($request_type == 'pay') {
            $datas['RequestType'] = '8001';
        }

        $datas['DataSign'] = self::encrypt($request_daata, $this->key);

        $result = Requests::post($search_url,[], $datas);
        $result = json_decode($result->body,true);

        if(isset($result['Traces'])){
            $this->logistics_info = $result['Traces'];
            $this->logistics_info;
        }
        $this->error = json_encode($result, JSON_UNESCAPED_UNICODE);
        return false;
    }

}