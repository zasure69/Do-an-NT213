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

use think\Validate;

class HelpCategory extends Validate
{

    protected $rule = [
        'id' => 'require|CheckHelp',
        'name' => 'require|unique:help_category,name^del',
        'is_show' => 'require'
    ];

    protected $message = [
        'id.require' => 'id不可为空',
        'name.require' => '分类名称不能为空！',
        'name.unique' => '分类名称已存在',
        'is_show.require' => '请选择显示状态'
    ];

    protected function sceneAdd()
    {
        $this->only(['name']);

    }

    protected function sceneEdit()
    {
        $this->only(['id', 'name'])
            ->remove('id', 'CheckHelp');
    }

    public function sceneDel()
    {
        $this->only(['id']);
    }

    protected function CheckHelp($value, $rule, $data)
    {
        if (\app\admin\model\Help::get(['cid' => $value, 'del' => 0])) {
            return '该分类下有文章，不可删除';
        }
        return true;
    }

}