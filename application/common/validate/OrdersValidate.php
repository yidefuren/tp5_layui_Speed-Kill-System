<?php

namespace app\common\validate;


class OrdersValidate extends BaseValidate
{
    protected $rule = [
        'order_id' => 'require',
        'gid' => 'require',
        'ip' => 'require|ip',
    ];

    protected $message = [
        'order_id' => '订单id必须填',
        'gid' => '商品id必填',
        'counts' => 'ip必填|ip格式不合法',
    ];
}