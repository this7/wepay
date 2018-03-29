<?php
/**
 * @Author: isglory
 * @E-mail: admin@ubphp.com
 * @Date:   2016-08-26 15:05:16
 * @Last Modified by:   qinuoyun
 * @Last Modified time: 2018-03-29 17:21:34
 * Copyright (c) 2014-2016, UBPHP All Rights Reserved.
 */
namespace this7\wepay;

class wepay {

    public function demo() {
        echo 1111;
    }
    /**
     * 小程序支付
     * @param  string  $openId 用户ID
     * @param  string  $title  订单标题
     * @param  integer $price  订单价格
     * @param  string  $attach 订单简述
     * @param  string  $tag    订单标记
     * @return [type]          [description]
     */
    public function WxPayOrder($openId = '', $title = '', $price = 1, $attach = '', $tag = '') {
        $input = new WxPayUnifiedOrder();
        #商品或支付单简要描述
        $input->SetBody($title);
        #设置附加数据
        $input->SetAttach($attach);
        #订单金额
        $input->SetTotal_fee($price);
        #设置商品标记，代金券或立减优惠功能的参数，说明详见代金券或立减优惠
        $input->SetGoods_tag($tag);
        #用户OpenID
        $input->SetOpenid($openId);
        $input->SetOut_trade_no(C("wepay", "MCHID") . date("YmdHis"));
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url("http://www.weixin.qq.com/wxpay/pay.php");
        $input->SetTrade_type("JSAPI");
        $order = WxPayApi::unifiedOrder($input);
        return $order;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function toUrlParams($values) {
        $buff = "";
        foreach ($values as $k => $v) {
            if ($k != "sign" && $v != "" && !is_array($v)) {
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function makeSign($values) {
        //签名步骤一：按字典序排序参数
        $string = $this->toUrlParams($values);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=" . C("wepay", "KEY");
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

}