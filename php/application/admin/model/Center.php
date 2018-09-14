<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;

class Center extends Common
{
  protected $name = 'center';
  /**
   * [getDataList 列表]
   * @AuthorHTL
   * @DateTime  2017-02-10T22:19:57+0800
   * @param     [string]                   $keywords [关键字]
   * @param     [number]                   $page     [当前页数]
   * @param     [number]                   $limit    [t每页数量]
   * @return    [array]                             [description]
   */
  public function getDataList($keywords, $page, $limit)
  {
      $map = [];
      if($keywords){
        $map['name'] = ['like','%'.$keywords.'%'];
      }
      $dataCount = $this->where($map)->count('id');
      $list = $this->where($map);
      // 若有分页
      if ($page && $limit) {
          $list = $list->page($page, $limit);
      }

      $list = $list->order('addtime desc')->fetchsql(false)->select();
      // echo $list; exit;
      $data['list'] = $list;
      foreach ($list as $key => $value) {
        $list[$key]['addtime'] = date('Y-m-d',$value['addtime']);
        $list[$key]['pic'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['pic'];
      }
      $data['dataCount'] = $dataCount;
      return $data;
  }

  public function getmenu($module='')
  {
    $map['module'] = ['in', $module.',Member'];
    $map['status'] = 1;
    $data = db('admin_menu')->where($map)->fetchsql(false)->select();
    // dump($data);
    $tree = new \com\Tree();
    $ret['menusList'] = $tree->list_to_tree($data, 'id', 'pid', 'child', 0, true, array('pid'));
    return $ret;
  }
}
