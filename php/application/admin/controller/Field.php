<?php
// +----------------------------------------------------------------------
// | Description: 模型系统
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +-

namespace app\admin\controller;

class Field extends ApiCommon
{
  public function index()
  {

    $moduleModel = model('Field');
    $param = $this->param;
    $mid = $param['mid'];
    $keywords = !empty($param['keywords']) ? $param['keywords']: '';
    $page = !empty($param['page']) ? $param['page']: '';
    $limit = !empty($param['limit']) ? $param['limit']: '';
    $data = $moduleModel->getDatafieldList($mid, $keywords, $page, $limit);
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
  public function field(){
      if(request()->isPost()){
          $nodostatus = array('catid','title','status','createtime');
          $sysfield = array('catid','userid','username','title','thumb','keywords','description','posid','status','createtime','url','template');

          $list = db('field')->where("moduleid=".input('param.id'))->order('listorder asc,id asc')->select();
          foreach ($list as $k=>$v){
              if($v['status']==1){
                  if(in_array($v['field'],$nodostatus)){
                      $list[$k]['disable']=2;
                  }else{
                      $list[$k]['disable']=0;
                  }
              }else{
                  $list[$k]['disable']=1;
              }

              if(in_array($v['field'],$sysfield)){
                  $list[$k]['delStatus']=1;
              }else{
                  $list[$k]['delStatus']=0;
              }
          }
          $this->assign('list', $list);
          return $result = ['code'=>0,'msg'=>'获取成功!','data'=>$list,'rel'=>1];
      }else{
          return $this->fetch();
      }
  }

  public function change()
  {
    $param = $this->param;
    dump($param['id']);
  }
}
?>
