<?php
// +----------------------------------------------------------------------
// | likeshop100%开源免费商用商城系统
// +----------------------------------------------------------------------
// | 欢迎阅读学习系统程序代码，建议反馈是我们前进的动力
// | 开源版本可自由商用，可去除界面版权logo
// | 商业版本务必购买商业授权，以免引起法律纠纷
// | 禁止对系统程序代码以任何目的，任何形式的再发布
// | gitee下载：https://gitee.com/likeshop_gitee
// | github下载：https://github.com/likeshop-github
// | 访问官网：https://www.likeshop.cn
// | 访问社区：https://home.likeshop.cn
// | 访问手册：http://doc.likeshop.cn
// | 微信公众号：likeshop技术社区
// | likeshop团队 版权所有 拥有最终解释权
// +----------------------------------------------------------------------
// | author: likeshopTeam
// +----------------------------------------------------------------------

namespace app\common\model;

use think\Db;
use think\Model;

class Goods extends Model
{
    /**
     * User: 意象信息科技 mjf
     * Desc: 获取以规格id为键的商品信息
     * @param string $field
     * @return array
     */
    public static function getColumnGoods($field = '*')
    {
        $info = Db::name('goods_item i')
            ->join('goods g', 'g.id = i.goods_id')
            ->column($field, 'i.id');

        return $info;
    }

    /**
     * User: 意象信息科技 mjf
     * Desc: 通过规格id获取商品信息
     * @param $item_id
     * @param string $field
     * @return array|\PDOStatement|string|Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getOneByItem($item_id, $field = '*')
    {
       $info = Db::name('goods_item i')
            ->field($field)
            ->join('goods g', 'g.id = i.goods_id')
            ->where('i.id', $item_id)
            ->find();

       return $info;
    }

}