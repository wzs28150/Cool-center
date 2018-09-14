<?php
// +----------------------------------------------------------------------
// | Description: 系统用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Center extends ApiCommon
{
  public function index()
  {
      $centerModel = model('Center');
      $param = $this->param;
      $keywords = !empty($param['keywords']) ? $param['keywords']: '';
      $page = !empty($param['page']) ? $param['page']: '';
      $limit = !empty($param['limit']) ? $param['limit']: '';
      $data = $centerModel->getDataList($keywords, $page, $limit);
      return resultArray(['data' => $data]);
  }
}
