<?php
// +----------------------------------------------------------------------
// | Description: 模型系统
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +-

namespace app\admin\controller;

class Module extends ApiCommon
{
  public function index()
  {

    $moduleModel = model('Modules');
    $param = $this->param;
    $keywords = !empty($param['keywords']) ? $param['keywords']: '';
    $page = !empty($param['page']) ? $param['page']: '';
    $limit = !empty($param['limit']) ? $param['limit']: '';
    $data = $moduleModel->getDataList($keywords, $page, $limit);
    return resultArray(['data' => $data]);
  }

  public function save()
  {
    $moduleModel = model('Modules');
    $param = $this->param;
    $data = $moduleModel->createData($param);
    if (!$data) {
      return resultArray(['error' => $userModel->getError()]);
    }
    return resultArray(['data' => '添加成功']);
  }

  public function read()
  {
    $moduleModel = model('Modules');
    $param = $this->param;
    $data = $moduleModel->getDataById($param['id']);
    if (!$data) {
      return resultArray(['error' => $userModel->getError()]);
    }
    return resultArray(['data' => $data]);
  }

  public function delete()
  {
      $moduleModel = model('Modules');
      $param = $this->param;
      $data = $moduleModel->delDataById($param['id']);
      if (!$data) {
          return resultArray(['error' => $userModel->getError()]);
      }
      return resultArray(['data' => '删除成功']);
  }
}
?>
