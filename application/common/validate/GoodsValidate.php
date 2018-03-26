<?php

namespace app\common\validate;

class GoodsValidate extends \app\common\validate\BaseValidate
{
    protected $rule = [
        'name' => 'require',
        'thumb' => 'require',
        'counts' => 'require|number',
        'redis_counts' => 'require|number',
        'price' => 'require'
    ];

    protected $message = [
        'name' => '商品名称必须填',
        'thumb' => '商品图片必传',
        'counts' => 'mysql库存必填|mysql库存必须是数字',
        'redis_counts' => 'redis库存必填|redis库存必须是数字',
        'price' => '商品价钱不能为空'
    ];
}