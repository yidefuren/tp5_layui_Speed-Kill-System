<?php

namespace app\admin\controller;

use app\common\model\Orders as orderModel;
use app\common\validate\OrdersValidate;

class Orders extends Base
{
    public function index()
    {
        $whereData = [];
        $whereData['page'] = input('page', 1);
        $whereData['size'] = input('size', 10);

        $orders = model('orders')->getOrdersByCondition($whereData);
        $total = model('orders')->getOrdersCountByCondition();

        $pageTotal = ceil($total / $whereData['size']);

        $curr = $whereData['page'];

        return view('index', compact('orders', 'total', 'pageTotal', 'curr'));
    }

    public function add()
    {
        $id = input('id', 0);
        $order = orderModel::find($id);
        return view('add', compact('order'));
    }


    public function store()
    {
        $validate = new OrdersValidate();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
        $id = input('post.id', '0');
        if ($id) {
            $data['id'] = $id;
            $res = orderModel::update($data);
        } else {
            $res = '';
        }
        return $res ? show_msg(0, '操作成功', '') : show_msg(1, '操作失败', '');
    }
}