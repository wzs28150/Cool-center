<?php
// +----------------------------------------------------------------------
// | Description: 文章
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller;
use app\common\controller\Common;


class Me extends ApiCommon
{
  public function index()
  {
    $param = $this->param;
    $meModel = model('Me');
    // dump($param);exit;
    $data = $meModel->getMeList($param['id']);
    foreach ($data as $key => $value) {
      $data[$key]['btnShow'] = false;
    }
    return resultArray(['data' => $data]);
  }

  public function delete()
  {
    $param = $this->param;
    $meModel = model('Me');
    if(!$param['id']){
      return resultArray(['error' => $meModel->getError()]);
    }
    $data = $meModel->delDataById($param['id']);
    if (!$data) {
        return resultArray(['error' => $postModel->getError()]);
    }
    return resultArray(['data' => '删除成功']);
  }
}
