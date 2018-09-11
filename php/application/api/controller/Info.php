<?php
// +----------------------------------------------------------------------
// | Description: 文章
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller;
use app\common\controller\Common;


class Info extends Common
{
  public function read()
  {
    $param = $this->param;
    if(cache('Info_' . $param['id'])){
      return resultArray(['data' => cache('Info_' . $param['id'])]);
    }
    $articleModel = model('Article');
    $data = $articleModel->getDataById($param['id']);
    cache('Info_' . $param['id'], $data);
    return resultArray(['data' => $data]);
  }

  public function readn()
  {
    $param = $this->param;
    $url = $param['url'];
    if(cache('Info_' . $url)){
      return resultArray(['data' => cache('Info_' . $url)]);
    }
    $articleModel = model('Article');
    $data = $articleModel->getArticleByUrl($url);
    cache('Info_' . $url, $data);
    return resultArray(['data' => $data]);
  }
}
