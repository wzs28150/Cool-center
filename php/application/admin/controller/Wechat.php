<?php
// +----------------------------------------------------------------------
// | Description: 模型系统
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +-

namespace app\admin\controller;

class Wechat extends ApiCommon
{
  public function index()
  {

    $data = db('wx_user')->where('id',1)->find();
    $data['type'] = strval($data['type']);
    $data['wait_access'] = strval($data['wait_access']);
		$data['apiurl'] = 'http://'.$_SERVER['HTTP_HOST'].'/home/weixin/index';
    return resultArray(['data' => $data]);
  }

  public function update()
  {
    $param = $this->param;
    $wechatModel = model('Wechat');
    $data = $wechatModel->updateDataById($param, $param['id']);
    if (!$data) {
        return resultArray(['error' => $wechatModel->getError()]);
    }
    return resultArray(['data' => '修改成功']);
  }
}
?>
