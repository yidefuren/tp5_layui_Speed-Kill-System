<?php


namespace app\common\model;


class Orders extends Base
{
    public static function buildOrderNo()
    {
        return date('ymd') . substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
    }


    public static function createOrder($gid, $type = 1)
    {
        $orderData = [];
        $orderData['order_id'] = Orders::buildOrderNo();
        $orderData['gid'] = $gid;
        $orderData['ip'] = request()->ip();
        $orderData['create_at'] = date('Y-m-d H:i:s');
        $orderData['temp'] = $type === 1 ? 'mysql' : 'redis';
        $res = Orders::insert($orderData);
        return !$res ? false : true;
    }

    public function getOrdersByCondition($param = [], $whereData = [])
    {
        $order = ['id' => 'desc'];
        $form = ($param['page'] - 1) * $param['size'];
        $result = $this->where($whereData)->limit($form, $param['size'])->order($order)->select();
        return $result;
    }


    public function getOrdersCountByCondition($whereData = [])
    {
        $count = $this->where($whereData)->count();
        return $count;
    }


    public function getOrderByCondition($id, $whereData = [])
    {
        $result = $this->where($whereData)->find($id);
        return $result;
    }


    public function goods()
    {
        return $this->belongsTo('goods', 'gid');
    }
}