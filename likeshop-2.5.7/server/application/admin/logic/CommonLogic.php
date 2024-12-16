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
use app\common\server\UrlServer;
use think\Db;
class CommonLogic{
    /**
     * note 修改制定表的某个字段
     * author cjh 2020/10/14 14:51
     * @param $table 表名
     * @param $pk_name  id
     * @param $pk_value id的值
     * @param $field 需要修改的字段
     * @param $field_value  需要修改的值
     * @return bool
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public static function changeTableValue($table,$pk_name,$pk_value,$field,$field_value){
        //允许修改的字段
        $allow_field = [
            'is_show','sort','status','is_new','is_best','is_like','is_recommend'
        ];
        if(!in_array($field,$allow_field)){
            return false;
        }
        if(is_array($pk_value)){
            $where[] = [$pk_name,'in',$pk_value];
        }else{
            $where[] = [$pk_name,'=',$pk_value];
        }

        $data= [
            $field          => $field_value,
            'update_time'   => time(),
        ];

        if ($field == 'status' and $field_value == 0) {
            $res = Db::name('team_activity')
                ->where(['goods_id'=>$pk_value])
                ->find();
            if ($res) {
                return '该商品正在参与拼团，请先关闭后才允许下架';
            }
        }

        $result = Db::name($table)->where($where)->update($data);
        return $result ? true : '修改失败';
    }

    //获取商品列表
    public static function getGoodsList($get,$is_item = false){
        $where = [];
        $where[] = ['del', '=', '0'];
        $where[] = ['status','=',1];

        if (isset($get['keyword']) && $get['keyword']) {
            $where[] = ['name', 'like', '%' . $get['keyword'] . '%'];
        }
        if(isset($get['cid']) && $get['cid']){
            $where[] = ['first_category_id|second_category_id|third_category_id','=',$get['cid']];
        }

        $goods_count = Db::name('goods')
            ->where($where)
            ->count();

        $goods_list = Db::name('goods')
            ->where($where)
            ->page($get['page'], $get['limit'])
            ->column('*','id');

        foreach ($goods_list as &$item) {
            $item['goods_item'] = [];
            $item['price'] = '￥'.$item['min_price'];
            if($item['max_price'] != $item['min_price']){
                $item['price'] = '￥'.$item['max_price'].'~'.'￥'.$item['min_price'];
            }
            $item['create_time_desc'] = date('Y-m-d H:i:s',$item['create_time']);
            $item['image'] = UrlServer::getFileUrl($item['image']);
        }

        if($is_item){
            $goods_ids = array_keys($goods_list);
            $goods_item = Db::name('goods_item')->where(['goods_id'=>$goods_ids])->select();
            foreach ($goods_item as $items){
                if(isset($goods_list[$items['goods_id']])){
                    if($items['image']){
                        $items['image'] = UrlServer::getFileUrl($items['image']);
                    }else{
                        $items['image'] = $goods_list[$items['goods_id']]['image'];
                    }
                    $goods_list[$items['goods_id']]['goods_item'][] = $items;
                }
            }
        }
        return ['count' => $goods_count, 'list' =>array_values($goods_list)];
    }


}