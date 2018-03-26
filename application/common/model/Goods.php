<?php

namespace app\common\model;



class Goods extends Base
{
    protected $createTime = 'create_at';
    protected $autoWriteTimestamp = 'datetime';


    // 根据条件获取数据
    public function getGoodsByCondition($param = [], $whereData = [])
    {
        $order = ['id' => 'desc'];
        $form = ($param['page'] - 1) * $param['size'];
        $result = $this->where($whereData)->limit($form, $param['size'])->order($order)->select();
        return $result;
    }

    // 获取条件总数
    public function getGoodsCountByCondition($whereData = [])
    {
        $count = $this->where($whereData)->count();
        return $count;
    }


    public function getGoodByCondition($id, $whereData = [])
    {
        $result = $this->where($whereData)->find($id);
        return $result;
    }
}