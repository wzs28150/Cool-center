<?php
// +----------------------------------------------------------------------
// | Description: 系统用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Article extends ApiCommon
{

  public function index()
  {
    $articleModel = model('Article');
    $param = $this->param;
    $keywords = !empty($param['keywords']) ? $param['keywords']: '';
    $page = !empty($param['page']) ? $param['page']: '';
    $limit = !empty($param['limit']) ? $param['limit']: '';
    $uid = !empty($param['uid']) ? $param['uid']: '';
    $mid = !empty($param['mid']) ? $param['mid']: '';
    $data = $articleModel->getDataList($keywords, $page, $limit, $uid, $mid);
    return resultArray(['data' => $data]);
  }
}
