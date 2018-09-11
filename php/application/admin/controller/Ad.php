<?php
// +----------------------------------------------------------------------
// | Description: 系统用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;

class Ad extends ApiCommon
{

  public function index()
  {
      $adModel = model('Ad');
      $param = $this->param;
      $keywords = !empty($param['keywords']) ? $param['keywords']: '';
      $page = !empty($param['page']) ? $param['page']: '';
      $limit = !empty($param['limit']) ? $param['limit']: '';
      $uid = !empty($param['uid']) ? $param['uid']: '';
      $mid = !empty($param['mid']) ? $param['mid']: '';
      $data = $adModel->getDataList($keywords, $page, $limit, $uid, $mid);
      return resultArray(['data' => $data]);
  }

  public function save()
  {
      $adModel = model('Ad');
      $param = $this->param;
      $data = $adModel->createData($param);
      if (!$data) {
          return resultArray(['error' => $adModel->getError()]);
      }
      return resultArray(['data' => '添加成功']);
  }

  public function read()
  {
    $adModel = model('Ad');
    $param = $this->param;
    $data = $adModel->getDataById($param['id']);
    if (!$data) {
        return resultArray(['error' => $adModel->getError()]);
    }
    return resultArray(['data' => $data]);
  }
  public function update()
  {
    $adModel = model('Ad');
    $param = $this->param;
    // dump($param);
    $data = $adModel->updateDataById($param, $param['id']);
    if (!$data) {
        return resultArray(['error' => $adModel->getError()]);
    }
    return resultArray(['data' => '编辑成功']);
  }

  public function delete()
  {
      $adModel = model('Ad');
      $param = $this->param;
      $data = $adModel->delDataById($param['id']);
      if (!$data) {
          return resultArray(['error' => $adModel->getError()]);
      }
      return resultArray(['data' => '删除成功']);
  }
}
