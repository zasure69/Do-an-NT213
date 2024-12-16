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
use app\common\server\ConfigServer;
use think\Db;
use think\Validate;

class Recharge extends Validate{
    protected $rule = [
        'id'        => 'checkRecharge',
        'money'     => 'checkRecharge',
        'pay_way'   => 'require',
    ];
    protected $message = [
        'pay_way.require'   => '请选择支付方式',
    ];
    protected function checkRecharge($value,$rule,$data){
        $open_racharge = ConfigServer::get('recharge','open_racharge',0);
        if(!$open_racharge){
            return '充值功能已关闭，无法充值';
        }

        if(empty($value) && $data['money']){
            return '请输入充值金额';
        }

        if(isset($data['id'])){
            $remplate = Db::name('recharge_template')
                        ->where(['id'=>$value,'del'=>0])
                        ->find();
            if(empty($remplate)){
                return '该充值模板不存在';
            }

        }else{
            $min_money = ConfigServer::get('recharge', 'min_money',0);

            if($data['money'] < $min_money){
                return '最低充值金额为'.$min_money;
            }

        }

        return true;
    }
}