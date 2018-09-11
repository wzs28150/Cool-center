<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\api\model;

use think\Db;
use app\api\model\Common;

class Me extends Common
{
  protected $name = 'info';

  public function getMeList($userid='')
  {
    $Map['userid'] = $userid;
    $data = Db::name('info')->where($Map)->order('addtime asc')->fetchsql(false)->select();
    // dump($data);
    if (!$data) {
        $this->error = '暂无此数据';
        return false;
    }
    return $data;
  }
}
