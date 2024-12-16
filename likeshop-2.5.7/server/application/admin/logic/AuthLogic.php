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


namespace app\admin\logic;


use think\Db;

class AuthLogic
{

    /**
     * 获取菜单列表
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function lists()
    {
        $lists = Db::name('dev_auth')
            ->where(['del' => 0])
            ->field(['id', 'type', 'system', 'pid', 'name', 'sort', 'icon', 'uri', 'disable'])
            ->order(['sort' => 'desc', 'type' => 'asc'])
            ->select();
        $pids = Db::name('dev_auth')
            ->where(['del'=>0,'type'=>1])
            ->column('pid');
        foreach ($lists as $k => $v) {
            $lists[$k]['type_str'] = $v['type'] == 1 ? '菜单' : '权限';
            $lists[$k]['open'] = in_array($v['id'],$pids)  ? true : false;
        }
        return linear_to_tree($lists);
    }

    /**
     * 获取菜单信息
     * @param $id
     * @return array|\PDOStatement|string|\think\Model|null
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function info($id)
    {
        return Db::name('dev_auth')
            ->where(['del' => 0, 'id' => $id])
            ->field(['id', 'pid', 'type', 'name', 'sort', 'icon', 'uri', 'disable'])
            ->find();
    }

    /**
     * 获取菜单选项
     * @param string $id 当前编辑菜单id（选项不包含该菜单的子菜单）
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function chooseMenu($id = '')
    {
        $lists = Db::name('dev_auth')
            ->field(['id', 'pid', 'name'])
            ->where(['del' => 0, 'type' => 1])
            ->select();
        if ($id) {
            $remove_ids = self::getChildIds($lists, $id);
            $remove_ids[] = $id;
            foreach ($lists as $key => $row) {
                if (in_array($row['id'], $remove_ids)) {
                    unset($lists[$key]);
                }
            }
            $lists = array_values($lists);
        }
        return multilevel_linear_sort($lists, '|-');
    }

    /**
     * 获取子类id
     * @param $lists
     * @param $id
     * @return array
     */
    private static function getChildIds($lists, $id)
    {
        $ids = [];
        foreach ($lists as $key => $row) {
            if ($row['pid'] == $id) {
                $ids[] = $row['id'];
                $child_ids = self::getChildIds($lists, $row['id']);
                foreach ($child_ids as $child_id) {
                    $ids[] = $child_id;
                }
            }
        }
        return $ids;
    }

    /**
     * 添加菜单
     * @param $post
     * @return int|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function addMenu($post)
    {
        if ($post['type'] == 1) {
            $level = self::getParent($post['pid']);
            if ($level >= 3) {
                return '菜单不允许超出三级';
            }
        }

        $data = [
            'pid' => $post['pid'],
            'type' => $post['type'],
            'name' => $post['name'],
            'icon' => $post['icon'],
            'sort' => $post['sort'],
            'uri' => $post['uri'],
            'disable' => $post['disable'],
            'create_time' => time(),
        ];
        return Db::name('dev_auth')->insert($data);
    }

    /**
     * Notes: 查找层级
     * @param $pid
     * @author 张无忌(2021/2/6 11:08)
     * @return int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function getParent($pid)
    {
        static $count = 0;
        $auth = Db::name('dev_auth')->where(['id' => $pid])->find();
        if ($auth) {
            $count += 1;
            if ($count < 3) {
                self::getParent($auth['pid']);
            }
            return $count;
        }
        return $count;
    }

    /**
     * 更新菜单
     * @param $post
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function updateMenu($post)
    {
        if ($post['type'] == 1) {
            $level = self::getParent($post['pid']);
            if ($level >= 3) {
                return '菜单不允许超出三级';
            }
        }

        $data = [
            'pid' => $post['pid'],
            'type' => $post['type'],
            'name' => $post['name'],
            'icon' => $post['icon'],
            'sort' => $post['sort'],
            'uri' => $post['uri'],
            'disable' => $post['disable'],
            'update_time' => time(),
        ];
        return Db::name('dev_auth')
            ->where(['id' => $post['id'], 'system' => 0])
            ->update($data);
    }

    /**
     * 设置菜单状态
     * @param $post
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function setStatus($post)
    {
        $data = [
            'disable' => $post['disable'],
            'update_time' => time(),
        ];
        return Db::name('dev_auth')
            ->where(['id' => $post['id'], 'system' => 0])
            ->update($data);
    }

    /**
     * 删除菜单
     * @param $ids
     * @return int|string
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function delMenu($ids)
    {
        $lists = Db::name('dev_auth')
            ->where(['del' => 0])
            ->field(['id', 'pid', 'name', 'sort', 'icon', 'disable'])
            ->select();
        $del_ids = $ids;
        foreach ($ids as $id) {
            $temp = self::getChildIds($lists, $id);
            $del_ids = array_merge($del_ids, $temp);
        }
        return Db::name('dev_auth')
            ->where('id', 'in', $del_ids)
            ->where(['del' => 0, 'system' => 0])
            ->update(['del' => 1]);
    }

}