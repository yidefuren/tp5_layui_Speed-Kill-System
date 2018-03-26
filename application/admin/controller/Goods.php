<?php

namespace app\admin\controller;


use app\admin\controller\Base;
use app\common\validate\GoodsValidate;
use app\common\model\Goods as goodsModel;
use app\lib\QRedis;
use think\Request;
use think\Response;

class Goods extends Base
{

    public function index()
    {
        $whereData = [];
        $whereData['page'] = input('page', 1);
        $whereData['size'] = input('size', 10);

        $goods = model('goods')->getGoodsByCondition($whereData);
        // 获取数据总数
        $total = model('goods')->getGoodsCountByCondition();
        // 总页数
        $pageTotal = ceil($total / $whereData['size']);

        $curr = $whereData['page'];

        return view('index', compact('goods', 'total', 'pageTotal', 'curr'));
    }

    public function add()
    {
        $id = input('get.id', '0');
        $good = goodsModel::find($id);
        return view('add', compact('good'));
    }

    public function edit()
    {
        return view('add');
    }

    public function store()
    {
        $validate = new GoodsValidate();
        $validate->goCheck();
        $data = $validate->getDataByRule(input('post.'));
        $id = input('post.id', '0');

        if ($id) {
            $good = goodsModel::find($id);
            if ($data['thumb'] != $good['thumb']) {
                $path = 'uploads/' . $good['thumb'];
                if (file_exists($path)) {
                    unlink($path);
                }
            }
            $data['id'] = $id;
            if ($data['redis_counts'] > 0) {
                $redis = new QRedis();
                $key = "goods_list_" . $good['id'];
                $redis->getHandle()->delete($key);
                $count = $data['redis_counts'];
                for ($i = 0; $i < $count; $i++) {
                    $redis->getHandle()->lpush($key, 1);
                }
            }
            $res = goodsModel::update($data);
        } else {
            $res = goodsModel::create($data);
        }
        return $res ? show_msg(0, '操作成功', '') : show_msg(1, '操作失败', '');
    }
}