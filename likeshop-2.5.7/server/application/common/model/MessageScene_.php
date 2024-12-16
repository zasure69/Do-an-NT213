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

/**
 * 微信/公众号的消息模板场景
 * Class MessageScene_
 * @package app\common\model
 */
class MessageScene_
{
    const BUY_SUCCESS           = 1; //购买成功通知
    const DELIVER_GOODS_SUCCESS = 2; //商品发货通知
    const REFUND_SUCCESS        = 3; //退款成功通知

    function getName($value)
    {
        $name = '';
        switch ($value) {
            case self::BUY_SUCCESS:
                $name = '购买成功通知';
                break;
            case self::DELIVER_GOODS_SUCCESS:
                $name = '商品发货通知';
                break;
            case self::REFUND_SUCCESS:
                $name = '退款成功通知';
                break;
        }
        return $name;
    }
}