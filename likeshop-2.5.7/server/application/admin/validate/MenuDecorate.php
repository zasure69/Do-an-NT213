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
namespace app\admin\validate;
use app\common\model\Menu_;
use think\Validate;

class MenuDecorate extends Validate{

    protected $rule = [
        'id'        => 'require',
        'name'      => 'require|unique:MenuDecorate,name^del^decorate_type^client',
        'image'     => 'require',
        'link_type' => 'checkLinkType',
    ];

    protected $message = [
        'id.require'    => '缺少参数',
        'name.require'  => '请输入菜单名称',
        'name.unique'   => '菜单名称已存在',
        'image.require' => '请上传菜单图标',

    ];
    protected function sceneAdd()
    {
        $this->remove('id');
    }

    protected function sceneEdit()
    {

    }

    public function sceneDel()
    {
        $this->only(['id']);
    }

    protected function checkLinkType($value,$rule,$data){
      if($value == 1){
//            $menu = Menu_::getStoreMenu($data['menu']);
//            if(empty($menu)){
//                return '请选择菜单';
//            }
      }
      if($value == 2){
        if(empty($data['url'])){
            return '请输入链接';
        }
      }

      return true;
    }

}