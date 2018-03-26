<?php

namespace app\lib\exception;


class BaseException extends \think\Exception{
    public $code = 400;
    public $msg = 'invalid parameters';
    public $errorCode = 999;//通用错误
    //
    function __construct($params = [])
    {
        if(!is_array($params)){
            return;
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('errorCode',$params)){
            $this->errorCode = $params['errorCode'];
        }
    }
}