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

class Article extends Validate
{

    protected $rule = [
        'id' => 'require',
        'title' => 'require|unique:article,title^del',
        'cid' => 'require|checkCid',
    ];

    protected $message = [
        'id.require' => 'id不可为空',
        'title.require' => '请输入文章标题',
        'title.unique' => '标题不能重复！',
        'cid.require' => '请选择分类！',
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

    protected function checkCid($value, $rule, $data)
    {
        if (\app\admin\model\ArticleCategory::get(['id' => $value, 'del' => 0])) {
            return true;
        }
        return '请选择文章分类';
    }
}