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
use think\Model;

class AccountLog extends Model{
    /*******************************
     ** 余额变动：100~199
     ** 积分变动：200~299
     ** 成长值变动：300~399
     ** 佣金变动: 400~499
     *******************************/
    const admin_add_money       = 100;
    const admin_reduce_money    = 101;
    const recharge_money        = 102;
    const balance_pay_order     = 103;
    const cancel_order_refund   = 104;
    const after_sale_refund     = 105;
    const withdraw_to_balance   = 106;
    const user_transfer_inc_balance = 107;
    const user_transfer_dec_balance = 108;

    const admin_add_integral           = 200;
    const admin_reduce_integral        = 201;
    const sign_in_integral             = 202;
    const recharge_give_integral       = 203;
    const order_add_integral           = 204;
    const register_add_integral        = 205;
    const invite_add_integral          = 206;
    const order_deduction_integral     = 207;
    const cancel_order_refund_integral = 208;
    const luck_draw_integral           = 209;
    const deduct_order_first_integral  = 210;
    const order_goods_give_integral    = 211;

    const admin_add_growth      = 300;
    const admin_reduce_growth   = 301;
    const sign_give_growth      = 302;
    const recharge_give_growth  = 303;
    const order_give_growth     = 304;//下单赠送成长值

    const withdraw_dec_earnings     = 400;//提现扣减佣金
    const withdraw_back_earnings    = 401;//提现被拒绝返回佣金
    const distribution_inc_earnings = 402;//分销订单结算增加佣金

    const money_change = [      //余额变动类型
        self::admin_add_money,self::admin_reduce_money,self::recharge_money,self::balance_pay_order,self::cancel_order_refund,self::after_sale_refund
        , self::withdraw_to_balance,self::user_transfer_inc_balance, self::user_transfer_dec_balance
    ];
    const integral_change = [   //积分变动类型
        self::admin_add_integral,self::admin_reduce_integral,self::sign_in_integral,self::recharge_give_integral,self::order_add_integral,self::invite_add_integral
        , self::order_deduction_integral,self::register_add_integral,self::cancel_order_refund_integral,self::luck_draw_integral,self::deduct_order_first_integral
        , self::order_goods_give_integral
    ];
    const growth_change = [     //成长值变动类型
        self::admin_add_growth,self::admin_reduce_growth,self::recharge_give_growth,self::sign_give_growth, self::order_give_growth
    ];

    const earnings_change = [   //佣金变动
        self::withdraw_dec_earnings, self::withdraw_back_earnings, self::distribution_inc_earnings
    ];

    public static function getAcccountDesc($from = true){
        $desc = [
            self::admin_add_money               => '系统增加余额',
            self::admin_reduce_money            => '系统扣减余额',
            self::recharge_money                => '用户充值余额',
            self::admin_add_integral            => '系统增加积分',
            self::admin_reduce_integral         => '系统扣减积分',
            self::sign_in_integral              => '每日签到赠送积分',
            self::recharge_give_integral        => '充值赠送积分',
            self::order_add_integral            => '下单赠送积分',
            self::order_deduction_integral      => '下单积分抵扣',
            self::register_add_integral         => '注册赠送积分',
            self::invite_add_integral           => '邀请会员赠送积分',
            self::admin_add_growth              => '系统增加成长值',
            self::admin_reduce_growth           => '系统扣减成长值',
            self::sign_give_growth              => '每日签到赠送成长值',
            self::recharge_give_growth          => '充值赠送成长值',
            self::balance_pay_order             => '下单扣减余额',
            self::cancel_order_refund           => '取消订单退回余额',
            self::after_sale_refund             => '售后退回余额',
            self::withdraw_to_balance           => '佣金提现',
            self::withdraw_dec_earnings         => '提现扣减佣金',
            self::withdraw_back_earnings        => '拒绝提现返还佣金',
            self::distribution_inc_earnings     => '订单结算获得佣金',
            self::cancel_order_refund_integral  => '取消订单退回积分',
            self::deduct_order_first_integral   => '扣除首单积分',
            self::luck_draw_integral            => '积分抽奖中奖',
            self::order_goods_give_integral     => '购买商品赠送积分',
            self::user_transfer_inc_balance     => '会员转账(收入方)',
            self::user_transfer_dec_balance     => '会员转账(支出方)',
            self::order_give_growth             => '下单赠送成长值',
        ];
        if($from === true){
            return $desc;
        }
        return $desc[$from] ?? '';
    }
    //返回变动类型
    public static function getChangeType($from){
        $type = '';
        if(in_array($from,self::money_change)){
            $type = 'money';
        }
        if(in_array($from,self::integral_change)){
            $type = 'integral';
        }
        if(in_array($from,self::growth_change)){
            $type = 'growth';
        }
        if(in_array($from,self::earnings_change)){
            $type = 'earnings';
        }
        return $type;
    }

    public static function getRemarkDesc($from,$source_sn,$remark =''){
        return $remark;
    }


    public static function getChangeAmountAttr($value,$data){
        $amount = $value;
        if(!in_array($data['source_type'],self::money_change)){
            $amount = intval($value);
        }
        if($data['change_type'] == 1){
            return '+'.$amount;
        }
        return '-'.$amount;
    }

    public static function getSourceTypeAttr($value,$data){
        return self::getAcccountDesc($value);

    }

    public static function getcreateTimeAttr($value,$data){
        if($value){
            return date('Y-m-d H:i:s',$value);
        }
        return '';
    }

}