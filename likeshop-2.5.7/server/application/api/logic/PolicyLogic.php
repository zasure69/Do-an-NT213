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

namespace app\api\logic;

use app\common\server\UrlServer;
use app\common\server\ConfigServer;

class PolicyLogic
{
    public static function service()
    {
        $service = ConfigServer::get('policy', 'service', '');
        $preg = '/<img.*?src="((?!(https|http)).*?)".*?\/?>/i';
        $local_url = UrlServer::getFileUrl();
        $res = preg_replace($preg, '<img src="' . $local_url . '${1}" />', $service);
        return $res;
    }

    public static function privacy()
    {
        $privacy = ConfigServer::get('policy', 'privacy', '');
        $preg = '/<img.*?src="((?!(https|http)).*?)".*?\/?>/i';
        $local_url = UrlServer::getFileUrl();
        $res = preg_replace($preg, '<img src="' . $local_url . '${1}" />', $privacy);
        return $res;
    }

    public static function afterSale()
    {
        $after_sale = ConfigServer::get('policy', 'after_sale', '');
        $preg = '/<img.*?src="((?!(https|http)).*?)".*?\/?>/i';
        $local_url = UrlServer::getFileUrl();
        $res = preg_replace($preg, '<img src="' . $local_url . '${1}" />', $after_sale);
        return $res;
    }
}