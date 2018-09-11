<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;

class Field extends Common
{
  protected $name = 'admin_field';


  public function getDatafieldList($mid, $keywords, $page, $limit)
  {
    $map = [];
    $map['moduleid'] = $mid;
    // dump($map);
    $dataCount = $this->where($map)->count('id');
    $list = $this->where($map);
    // 若有分页
    if ($page && $limit) {
        $list = $list->page($page, $limit);
    }
    $list = $list->select();
    $data['list'] = $list;
    $data['dataCount'] = $dataCount;
    return $data;
  }

}
