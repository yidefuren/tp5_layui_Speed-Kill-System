<?php

namespace app\index\controller;

use app\common\validate\GidValidate;
use think\Db;

class Index extends Base
{
    public function index()
    {
        $data = [];
        $where = [];
        $data['page'] = input('page', 1);
        $data['size'] = input('size', 10);

        $where['counts'] = ['counts', '>=', 1];
        $goods = model('goods')->getGoodsByCondition($data, $where);
        // 获取数据总数
        $total = model('goods')->getGoodsCountByCondition();
        // 总页数
        $pageTotal = ceil($total / $data['size']);

        $curr = $data['page'];

        return view('index', compact('goods', 'pageTotal', 'curr'));
    }

    public function index2()
    {
        $data = [];
        $where = [];
        $data['page'] = input('page', 1);
        $data['size'] = input('size', 10);

        $where['redis_counts'] = ['redis_counts', '>=', 1];
        $goods = model('goods')->getGoodsByCondition($data, $where);
        // 获取数据总数
        $total = model('goods')->getGoodsCountByCondition($where);


        // 总页数
        $pageTotal = ceil($total / $data['size']);

        $curr = $data['page'];

        return view('index2', compact('goods', 'pageTotal', 'curr'));
    }


}
