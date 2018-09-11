<?php
// +----------------------------------------------------------------------
// | Description: 模型系统
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +-

namespace app\admin\controller;

class Member extends ApiCommon
{
  public function index()
  {
    $memberModel = model('Member');
    $param = $this->param;
    $shuyu = $param['sid'];
    $keywords = !empty($param['keywords']) ? $param['keywords']: '';
    $page = !empty($param['page']) ? $param['page']: '';
    $limit = !empty($param['limit']) ? $param['limit']: '';
    $data = $memberModel->getDataList($keywords, $page, $limit, $shuyu);
    return resultArray(['data' => $data]);
  }


  public function save()
  {
    $memberModel = model('Member');
    $param = $this->param;
    $data = $memberModel->addMember($param);
    if (!$data) {
        return resultArray(['error' => $memberModel->getError()]);
    }
    return resultArray(['data' => '添加成功']);
  }

  public function read()
  {
    $memberModel = model('Member');
    $param = $this->param;
    $data = $memberModel->getDataById($param['id']);
    if (!$data) {
        return resultArray(['error' => $memberModel->getError()]);
    }
    return resultArray(['data' => $data]);
  }

  public function delete()
  {
    $memberModel = model('Member');
    $param = $this->param;
    $data = $memberModel->delDataById($param['id']);
    if (!$data) {
        return resultArray(['error' => $memberModel->getError()]);
    }
    return resultArray(['data' => '删除成功']);
  }

  public function deletes()
  {
    $memberModel = model('Member');
    $param = $this->param;
    $data = $memberModel->delDatas($param['ids']);
    if (!$data) {
        return resultArray(['error' => $memberModel->getError()]);
    }
    return resultArray(['data' => '删除成功']);
  }

  public function update()
  {
    $memberModel = model('Member');
    $param = $this->param;
    $data = $memberModel->updateDataById($param, $param['id']);
    if (!$data) {
        return resultArray(['error' => $memberModel->getError()]);
    }
    return resultArray(['data' => '编辑成功']);
  }
}
?>
