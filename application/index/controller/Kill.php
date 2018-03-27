<?php


namespace app\index\controller;

use app\common\model\Orders;
use app\common\validate\GidValidate;
use app\lib\QRedis;
use think\Db;
use think\Exception;

class Kill extends Base
{
    public function kill()
    {
        $gid = input('gid', 0);
        (new GidValidate())->goCheck();

        $this->mysql_check_order($gid);
    }

    public function redis_kill()
    {
        $gid = input('gid', 0);
        (new GidValidate())->goCheck();

        $this->redis_check_order($gid);
    }

    //  基于mysql验证库存
    private function mysql_check_order($gid)
    {
        Db::startTrans();
        try {
            $goodInfo = Db::name('goods')->where('id', $gid)->lock(true)->find();
            if ($goodInfo['counts'] <= 0) {
//                return json(['msg' => '库存不足'], 400);
                show_msg('1', '库存不足', '');
            }
            Db::name('goods')->where('id', $gid)->setDec('counts');

            $res = Orders::createOrder($gid);
            if (!$res) {
//                return json(['msg' => '创建订单失败'], 400);
                show_msg('1', '创建订单失败', '');
            }
            Db::commit();
//            return json(['msg' => '购买成功'], 200);
            show_msg('0', '购买成功', '');
        } catch (\Exception $e) {
            Db::rollback();
        }
    }

    // 基于redis队列验证库存
    private function redis_check_order($gid)
    {
        $where['redis_counts'] = ['redis_counts', '>=', 1];
        $goodInfo = model('goods')->getGoodByCondition($gid, $where);
        if (!$goodInfo) {
            show_msg('1', '商品不存在', '');
        }

        $redis = new QRedis();
        $key = "goods_list_" . $goodInfo['id'];

        $len = $redis->getHandle()->llen($key);

        // 会出现超卖
        if ($len > $goodInfo['redis_counts']) {
            show_msg('1', '已经抢光了', '');
        }
        // lpop是移除并返回列表的第一个元素，模拟抢购
        $count = $redis->getHandle()->lpop($key);

        if (!$count) {
            show_msg('1', '已经抢光了', '');
        }
        $res = Orders::createOrder($gid, 2);
        if (!$res) {
            show_msg('1', '创建订单失败', '');
        }
        // 减少库存
        Db::name('goods')->where('id', $gid)->setDec('redis_counts');
        show_msg('0', '购买成功', '');
    }

}