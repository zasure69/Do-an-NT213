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
namespace app\api\controller;
use app\api\logic\CollectLogic;

class Collect extends ApiBase{
    /**
     * note 商品收藏列表
     * create_time 2020/10/29 10:17
     */
    public function getCollectGoods(){
        $collect = CollectLogic::getCollectGoods($this->user_id,$this->page_no,$this->page_size);
        $this->_success('获取成功',$collect);
    }
    /**
     * note 商品收藏操作
     * create_time 2020/10/29 10:17
     */
    public function handleCollectGoods(){
        $post = $this->request->post();
        $collect = CollectLogic::handleCollectGoods($post,$this->user_id);
        $this->_success('获取成功',$collect);
    }
}