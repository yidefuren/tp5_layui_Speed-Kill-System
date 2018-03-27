<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function show($status, $message, $data = [], $httpCode = 200)
{

    $data = [
        'code' => $status,
        'message' => $message,
        'data' => $data,
    ];

    return json($data, $httpCode);
}

function show_msg($code = 1, $msg = '', $data = [])
{
    return exit(toJson(['code' => $code, 'msg' => $msg, 'data' => $data]));
}


/**************************************************************
 *
 *  使用特定function对数组中所有元素做处理
 * @param  string &$array 要处理的字符串
 * @param  string $function 要执行的函数
 * @return boolean $apply_to_keys_also     是否也应用到key上
 * @access public
 *************************************************************/
function arrayRecursive(&$array, $function, $apply_to_keys_also = false)
{
    static $recursive_counter = 0;
    if (++$recursive_counter > 1000) {
        die('possible deep recursion attack');
    }
    foreach ($array as $key => $value) {
        if (is_array($value)) {
            arrayRecursive($array[$key], $function, $apply_to_keys_also);
        } else {
            $array[$key] = $function($value);
        }
        if ($apply_to_keys_also && is_string($key)) {
            $new_key = $function($key);
            if ($new_key != $key) {
                $array[$new_key] = $array[$key];
                unset($array[$key]);
            }
        }
    }
    $recursive_counter--;
}

function toJson($array)
{
    arrayRecursive($array, 'urlencode', true);
    $json = json_encode($array);
    return urldecode($json);
}


function jiequ($str, $length = 15)
{
    if (empty($str)) return "";
    // 中文 2 个字节，英文 1 个字节
    return mb_strimwidth(trim(htmlspecialchars_decode($str)), 0, $length, '...', 'utf-8');
}


function ipToStar($ip)
{
    if (empty($ip))
        return "";
    return preg_replace('/(\d+)\.(\d+)\.(\d+)\.(\d+)/is', "$1.$2.*.*", $ip);
}