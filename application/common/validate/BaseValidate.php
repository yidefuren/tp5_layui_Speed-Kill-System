<?php

namespace app\common\validate;


use app\lib\exception\ParameterException;
use think\Exception;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function goCheck()
    {
        $params = \request()->param();
        if (!$this->check($params)) {

//            $exception = new ParameterException([
//                'msg' => is_array($this->error) ? implode(';', $this->error):$this->error
//            ]);
//            throw $exception;
            $msg = is_array($this->error) ? implode(';', $this->error) : $this->error;
//            $data = [
//                'msg' => is_array($this->error) ? implode(';', $this->error):$this->error
//            ];
//            throw new Exception($this->error);
            show_msg(1, $this->error, []);
        } else {

            return true;
        }
    }


    /**
     * @param array $arrays 通常传入request.post变量数组
     * @return array 按照规则key过滤后的变量数组
     * @throws ParameterException
     */
    public function getDataByRule($arrays)
    {
        if (array_key_exists('user_id', $arrays) | array_key_exists('uid', $arrays)) {
            // 不允许包含user_id或者uid，防止恶意覆盖user_id外键
            throw new ParameterException([
                'msg' => '参数中包含有非法的参数名user_id或者uid'
            ]);
        }
        $newArray = [];
        foreach ($this->rule as $key => $value) {
            $newArray[$key] = $arrays[$key];
        }
        return $newArray;
    }
}