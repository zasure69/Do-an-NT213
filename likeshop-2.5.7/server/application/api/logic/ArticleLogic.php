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


namespace app\api\logic;

use app\common\server\UrlServer;
use think\Db;

class ArticleLogic
{
    public static function lists($id, $page, $size)
    {
        $where[] = [
            ['del', '=', 0],
            ['is_show', '=', 1],
        ];

        if (!empty($id)) {
            $where[] = ['cid', '=', $id];
        }

        $res = DB::name('article')
            ->where($where)
            ->field('id,title,synopsis,image,visit,create_time')
            ->order(['create_time' => 'desc']);

        $count = $res->count();
        $article = $res->page($page, $size)->select();

        foreach ($article as &$item) {
            $item['create_time'] = date('Y-m-d ', $item['create_time']);
            $item['image'] = UrlServer::getFileUrl($item['image']);
        }

        $more = is_more($count, $page, $size);
        return [
            'list' => $article,
            'count' => $count,
            'page_no' => $page,
            'page_size' => $size,
            'more' => $more
        ];
    }

    public static function CategoryLists()
    {
        $res = DB::name('article_category')
            ->where(['del' => 0])
            ->where('is_show', 1)
            ->field('id,name')
            ->select();
        return $res;
    }

    public static function getArticleDetail($id,$client)
    {
        DB::name('article')
            ->where(['id' => $id, 'del' => 0])
            ->setInc('visit');

        $res = DB::name('article')
            ->where(['del' => 0, 'id' => $id])
            ->field('id,title,image,visit,create_time,content')
            ->order(['create_time' => 'desc'])
            ->find();

        $preg = '/<img.*?src="((?!(https|http)).*?)".*?\/?>/i';
        $local_url = UrlServer::getFileUrl();
        $res['content'] = preg_replace($preg, '<img src="' . $local_url . '${1}" />', $res['content']);
        $res['create_time'] = date('Y-m-d ', $res['create_time']);
        $res['image'] = UrlServer::getFileUrl($res['image']);
        $recommend_list = [];
        if(2 == $client){
            $recommend_list = Db::name('article')
                            ->where([['del','=','0'], ['id','<>',$id]])
                            ->field('id,title,image,visit')
                            ->order('visit desc')
                            ->limit(5)
                            ->select();


            foreach ($recommend_list as $key => $recommend){
                $recommend_list[$key]['image'] = UrlServer::getFileUrl($recommend['image']);
            }
        }
        $res['recommend_list'] = $recommend_list;

        return $res;
    }
}