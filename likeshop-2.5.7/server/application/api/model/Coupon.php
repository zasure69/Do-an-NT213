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

namespace app\api\model;

use think\Db;
use think\Model;

class Coupon extends Model
{
    public function couponGoods()
    {
        return $this->hasMany('couponGoods', 'coupon_id', 'id');
    }


    //通过(coupon_list)获取优惠券信息
    public static function getCouponByClId($coupon_id)
    {
        $result = Db::name('coupon c')
            ->join('coupon_list cl', 'c.id = cl.coupon_id')
            ->where(['cl.id ' => $coupon_id, 'c.del' => 0, 'cl.del' => 0, 'cl.status' => 0])
            ->field('c.*')
            ->find();

        return $result;
    }
}