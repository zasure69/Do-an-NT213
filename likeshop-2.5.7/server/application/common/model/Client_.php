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


class Client_
{
    const mnp = 1;//小程序
    const oa = 2;//公众号
    const ios = 3;
    const android = 4;
    const pc = 5;
    const h5 = 6;//h5(非微信环境h5)

    function getName($value)
    {
        switch ($value) {
            case self::mnp:
                $name = '小程序';
                break;
            case self::h5:
                $name = 'h5';
                break;
            case self::ios:
                $name = '苹果';
                break;
            case self::android:
                $name = '安卓';
                break;
            case self::oa:
                $name = '公众号';
                break;
        }
        return $name;
    }

    public static function getClient($type = true)
    {
        $desc = [
            self::pc      => 'pc商城',
            self::h5      => 'h5商城',
            self::oa      => '公众号商城',
            self::mnp     => '小程序商城',
            self::ios     => '苹果APP商城',
            self::android => '安卓APP商城',
        ];
        if ($type === true) {
            return $desc;
        }
        return $desc[$type] ?? '未知';
    }
}