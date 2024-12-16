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


namespace app\admin\controller;


use app\admin\logic\LoginLogic;
use app\admin\validate\Login;
use think\facade\Url;

class Account extends AdminBase
{

    public $like_not_need_login = ['login'];

    /**
     * 登录
     * @return mixed
     */
    public function login()
    {
        if ($this->request->isAjax()) {
            $post = input('post.');
            $result = $this->validate($post, 'app\admin\validate\Login');
            if ($result === true) {
                LoginLogic::login($post);
                $this->_success('登录成功');
            }
            $this->_error($result);
        }
        $this->assign('account', cookie('account'));

        //首页配置
        $this->assign('config', LoginLogic::config());
        return $this->fetch();
    }

    /**
     * 退出登录
     */
    public function logout()
    {
        LoginLogic::logout(session('admin_info.id'));
        $url = Url::build('account/login');
        $this->redirect($url);
    }
}