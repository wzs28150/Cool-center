<?php
// +----------------------------------------------------------------------
// | Description: 系统用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------

namespace app\admin\controller;
use \tp5er\Backup;
use think\Request;
class Database extends ApiCommon
{
  protected $db = '', $datadir;
  function _initialize(){
      parent::_initialize();
      $this->config = array(
          'path'     => './Data/',//数据库备份路径
          'part'     => 20971520,//数据库备份卷大小
          'compress' => 0,//数据库备份文件是否启用压缩 0不压缩 1 压缩
          'level'    => 9 //数据库备份文件压缩级别 1普通 4 一般  9最高
      );
      $this->db = new Backup($this->config);

  }

  public function database(){
    $list = $this->db->dataList();
    $total = 0;
    foreach ($list as $k => $v) {
        $list[$k]['size'] = format_bytes($v['data_length']);
        $total += $v['data_length'];
    }
    // dump($list);
    return resultArray(['data' => $list]);
  }

  public function optimize() {
    $param = $this->param;
    $tables = $param['table'];
    if (empty($tables)) {
      return resultArray(['error' => '请选择要优化的表！']);
    }
    if($this->db->optimize($tables)){
      return resultArray(['data' => '数据表优化成功！']);
    }else{
      return resultArray(['error' => '数据表优化出错请重试！']);
    }
  }

  //备份
  public function backup(){
    $param = $this->param;
    $tables = $param['table'];
    $tables = array_column($tables,'name');
    // dump($tables);exit;
    if (!empty($tables)) {
      foreach ($tables as $table) {
        $this->db->setFile()->backup($table, 0);
      }
      return resultArray(['data' => '备份成功！']);
    } else {
      return resultArray(['error' => '请选择要备份的表！']);
    }
  }

  //备份列表
  public function restore(){
    $list =  $this->db->fileList();
    // dump($list);
    foreach ($list as $k => $v) {
        $list[$k]['size'] = format_bytes($v['size']);
        $list[$k]['time'] = date('Y-m-d H:i:s',$v['time']);
    }
    return resultArray(['data' => array_values($list)]);
  }

  //执行还原数据库操作
  public function import() {
    $param = $this->param;
    $time = strtotime($param['time']);
    $list  = $this->db->getFile('timeverif',$time);
    $this->db->setFile($list)->import(1);
    return resultArray(['data' => '还原成功！']);
  }
}
