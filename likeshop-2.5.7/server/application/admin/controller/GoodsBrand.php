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
use app\admin\logic\GoodsBrandLogic;
use app\common\model\Capital_;

class GoodsBrand extends AdminBase {
   
    /**
     * note 品牌列表
     */
    public function lists()
    {
        if ($this->request->isAjax())
        {
            $get = $this->request->get();
            $list = GoodsBrandLogic::lists($get);
            $this->_success('',$list);
        }
        return $this->fetch();
    }

    /**
     * note 添加品牌
     */
    public function add()
    {
        if ($this->request->isAjax()){
            $post = $this->request->post();
            $post['del'] = 0;
            $result = $this->validate($post,'app\admin\validate\GoodsBrand.add');
            if ($result === true){
                GoodsBrandLogic::add($post);
                $this->_success('添加成功！');
            }
            $this->_error($result);

        }

        $capital = Capital_::getData();
        $this->assign('capital',$capital);
        return $this->fetch();
    }

    /**
     * note 编辑品牌
     */
    public function edit($id)
    {
        if ($this->request->isAjax()){
            $post = $this->request->post();
            $post['del'] = 0;
            $result = $this->validate($post,'app\admin\validate\GoodsBrand.edit');
            if ($result === true){
                GoodsBrandLogic::edit($post,$id);
                $this->_success('修改成功');
            }
            $this->_error($result);
        }

        $info = GoodsBrandLogic::getGoodsBrand($id);
        $capital = Capital_::getData();
        $this->assign('info',$info);
        $this->assign('capital',$capital);
        return $this->fetch();
    }

    /**
     * note 删除品牌
     */
    public function del($delData)
    {
        if ($this->request->isAjax()) {
            $result = GoodsBrandLogic::del($delData);
            if ($result) {
                $this->_success('删除成功');
            }
            $this->_error('删除失败');
        }
    }

    /**
     * note 修改品牌的显示状态
     */
    public function switchStatus(){
        $post = $this->request->post();
        $result =GoodsBrandLogic::switchStatus($post);
        if ($result) {
            $this->_success('修改成功');
        }
        $this->_success('修改失败');
    }

}