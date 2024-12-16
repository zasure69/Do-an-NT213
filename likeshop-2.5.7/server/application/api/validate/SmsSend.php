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
namespace app\api\validate;

use app\api\logic\LoginLogic;
use app\api\model\User;
use app\common\model\NoticeSetting;
use think\{
    Db,
    Validate
};

class SmsSend extends Validate
{
    protected $rule = [
        'mobile' => 'require|checkSms',
        'key' => 'checkMobile',
    ];
    protected $message = [
        'mobile.require' => '请输入手机号码',
    ];

    protected function checkSms($value, $rule, $data)
    {
        $message_key = NoticeSetting::SMS_SCENE[$data['key']];
        $send_time = Db::name('sms_log')
            ->where(['message_key' => $message_key, 'mobile' => $value, 'is_verify' => 0])
            ->order('id desc')
            ->value('send_time');
        //一分钟内不能频繁发送
        if ($send_time && $send_time + 60 > time()) {
            return '验证码发送频繁，请稍后在发送';
        }
        return true;
    }

    protected function checkMobile($value, $rule, $data)
    {
        $user = User::get(['mobile' => $data['mobile'], 'del' => 0]);
        switch ($value) {
            case 'ZCYZ':    //注册验证
            case 'BDSJHM':  //绑定手机号码
                if ($user) return '该手机号码已存在';
                break;
            case 'YZMDL':   //验证码登录
                if (empty($user) || !$user) { //账号不存在, 给他注册
                    $post = request()->post();
                    $post['password'] = '';
                    LoginLogic::register($post);
                }
                break;
            case 'ZHMM':    //找回密码
            case 'BGSJHM':  //变更手机号码
            case 'ZHZFMM':  // 找回支付密码
                if (empty($user)) return '手机号码不存在';
                break;

        }
        return true;
    }

}