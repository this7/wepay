<?php
namespace this7\wepay;
use \Exception as Exception;

/**
 *
 * 微信支付API异常类
 * @author widyhu
 *
 */
class WxPayException extends Exception {
    public function errorMessage() {
        return $this->getMessage();
    }
}
