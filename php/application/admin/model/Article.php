<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;

class Article extends Common
{
  protected $name = 'info';

  /**
   * [getDataList 列表]
   * @AuthorHTL
   * @DateTime  2017-02-10T22:19:57+0800
   * @param     [string]                   $keywords [关键字]
   * @param     [number]                   $page     [当前页数]
   * @param     [number]                   $limit    [t每页数量]
   * @return    [array]                             [description]
   */
  public function getDataList($keywords, $page, $limit, $uid, $mid='')
  {
      $map = [];

      if($uid!=1){
        $map['user.id'] = $uid;
      }

      if($mid){
        $map['member.id'] = $mid;
      }

      if($keywords){
        $map['title'] = ['like','%'.$keywords.'%'];
      }

      $dataCount = $this->alias('info')->join('oa_member member', 'member.id = info.userid', 'LEFT')->join('oa_admin_user user', 'member.shuyu = user.id', 'LEFT')->where($map)->fetchsql(false)->count('info.id');

      $list = $this->alias('info')->join('oa_member member', 'member.id = info.userid', 'LEFT')->join('oa_admin_user user', 'member.shuyu = user.id', 'LEFT')->where($map);
      // 若有分页
      if ($page && $limit) {
          $list = $list->page($page, $limit);
      }
      $list = $list->field('info.*')->order('info.addtime desc')->fetchsql(false)->select();
      // echo $list; exit;
      foreach ($list as $key => $value) {
        $info = Db::name('member')->find($value['userid']);
        $list[$key]['username'] = $info['username'];
        // $list[$key]['ad_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['ad_img'];
        // $list[$key]['ad_img_one'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['ad_img_one'];
        // $list[$key]['ad_img_two'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['ad_img_two'];
        // $list[$key]['erweima'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['erweima'];
      }
      $data['list'] = $list;
      $data['dataCount'] = $dataCount;
      return $data;
  }
}
