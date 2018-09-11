<?php
// +----------------------------------------------------------------------
// | Description: 文章
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\api\controller;
use app\common\controller\Common;
use QL\QueryList;

class Article extends ApiCommon
{
    public function index()
    {
        // //采集某页面所有的图片
        // $data = QueryList::Query('http://cms.querylist.cc/bizhi/453.html',['image' => ['img','src']])->data;
        // //打印结果
        // print_r($data);
        $param = $this->param;
        $id = $param['id'];
        $page = $param['page'];
        if(cache('Article_' . $time. $id. $page)){
          return resultArray(['data' => cache('Article_' . $time. $id. $page)]);
        }
        $url = 'http://weixin.sogou.com/pcindex/pc/'.$id.'/'.$page.'.html';
        $articleModel = model('Article');
        $data = $articleModel->getArticleList($url);
        foreach ($data as $key => $value) {
          $data[$key]['image'] = 'http://'.$_SERVER['HTTP_HOST'].'/api/base/imgproxy?1=1&siteid=1&url='.$value['image'];
          $data[$key]['btnShow'] = false;
        }
        // 时间 id page
        $time = strtotime(date('Y-m-d H',time()));
        cache('Article_' . $time. $id. $page, $data);
        return resultArray(['data' => $data]);
    }

    public function adlist()
    {
      $param = $this->param;
      $id = $param['id'];
      $data = db('ad')->field('ad_title,id')->where('userid',$id)->select();
      return resultArray(['data' => $data]);
    }

    public function add()
    {
      $param = $this->param;
      $articleModel = model('Article');
      $data = $articleModel->createData($param);
      if (!$data) {
          return resultArray(['error' => $articleModel->getError()]);
      }
      // echo $data;
      $info = $articleModel->getArticleById($data);
      return resultArray(['data' => $info]);
    }

    public function save()
    {
      $param = $this->param;
      $articleModel = model('Article');
      $data = $articleModel->updateArticleById($param,$param['id']);
      if (!$data) {
          return resultArray(['error' => $userModel->getError()]);
      }
      return resultArray(['data' => '编辑成功']);
    }

    public function info()
    {
      $param = $this->param;
      if(cache('Art_' . $param['id'])){
        return resultArray(['data' => cache('Article_' . $param['id'])]);
      }
      $articleModel = model('Article');
      $data = $articleModel->getmeArticleById($param['id']);
      if (!$data) {
          return resultArray(['error' => $userModel->getError()]);
      }
      cache('Art_' . $param['id'], $data);
      return resultArray(['data' => $data]);
    }

    public function read()
    {
      $param = $this->param;
      $articleModel = model('Article');
      $data = $articleModel->getDataById($param['id']);
      return resultArray(['data' => $data]);
    }

}
