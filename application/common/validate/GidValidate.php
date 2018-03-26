<?php


namespace app\common\validate;

class GidValidate extends BaseValidate
{
    protected $rule = [
        'gid' => 'require|number'
    ];

    protected $message = [
        'gid' => 'gid参数必须|gid必须是整形'
    ];
}