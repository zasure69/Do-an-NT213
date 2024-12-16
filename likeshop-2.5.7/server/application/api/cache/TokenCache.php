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


namespace app\api\cache;


use app\common\cache\CacheBase;
use think\Db;
use think\facade\Config;

class TokenCache extends CacheBase
{

    public function setTag()
    {
        return 'token';
    }

    /**
     * 子类实现查出数据
     * @return mixed
     */
    public function setData()
    {
        //刷新token过期时间
        $time = time();
        $expire_time = $time + Config::get('project.token_expire_time');
        Db::name('session')
            ->where(['token' => $this->extend['token']])
            ->update(['update_time' => $time, 'expire_time' => $expire_time]);

        //返回用户信息
        $user_info = Db::name('user u')
            ->join('session s', 'u.id=s.user_id')
            ->where(['s.token' => $this->extend['token']])
            ->field('u.*,s.token,s.client')
            ->find();
        return $user_info;
    }
}