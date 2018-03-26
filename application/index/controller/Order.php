<?php

namespace app\index\controller;


class Order extends Base
{
    public function index()
    {

        $data = [];
        $data['page'] = input('page', 1);
        $data['size'] = input('size', 10);

        $orders = model('orders')->getOrdersByCondition($data);
        // 获取数据总数
        $total = model('orders')->getOrdersCountByCondition();
        // 总页数
        $pageTotal = ceil($total / $data['size']);

        $curr = $data['page'];

        return view('index', compact('orders', 'pageTotal', 'curr'));
    }
}