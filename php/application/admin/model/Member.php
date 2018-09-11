<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;

class Member extends Common
{
  protected $name = 'member';
  /**
   * [getDataList 列表]
   * @AuthorHTL
   * @DateTime  2017-02-10T22:19:57+0800
   * @param     [string]                   $keywords [关键字]
   * @param     [number]                   $page     [当前页数]
   * @param     [number]                   $limit    [t每页数量]
   * @return    [array]                             [description]
   */
  public function getDataList($keywords, $page, $limit, $shuyu)
  {
      $map = [];
      if($shuyu != 1){
        $map['shuyu'] = $shuyu;
      }
      if($keywords){
        $map['username'] = ['like','%'.$keywords.'%'];
      }
      $dataCount = $this->where($map)->count('id');
      $list = $this->where($map);
      $time1=strtotime(date("Y-m-d H:i:s"));
      // 若有分页
      if ($page && $limit) {
          $list = $list->page($page, $limit);
      }

      $list = $list->order('ctime desc')->fetchsql(false)->select();
      // echo $list; exit;
      $data['list'] = $list;
      foreach ($list as $key => $value) {
        $time2= date_to_unixtime($value['beizhu1']);
        $mintime = ceil(($time2-$time1)/86400);
        if(ceil(($time2-$time1)/86400)>0){
          $list[$key]['dq'] = "还有".ceil(($time2-$time1)/86400)."天到期";
        }else{
          $list[$key]['dq'] = "已到期";
        }
        $list[$key]['ccc'] = Db::name('info')->where('userid',$value['userid'])->count();
      }
      $data['dataCount'] = $dataCount;
      return $data;
  }

  // <pre>array(10) {
  //   ["/admin/member"] =&gt; string(0) ""
  //   ["userid"] =&gt; string(8) "caiyilin"
  //   ["pwd"] =&gt; string(6) "123456"
  //   ["repwd"] =&gt; string(6) "123456"
  //   ["username"] =&gt; string(6) "许梦"
  //   ["anums"] =&gt; int(1000)
  //   ["beizhu1"] =&gt; string(24) "2018-09-29T16:00:00.000Z"
  //   ["adnums"] =&gt; int(1000)
  //   ["beizhu2"] =&gt; string(0) ""
  //   ["shuyu"] =&gt; int(1)
  // }
  // </pre>
  //
  public function addMember($param)
  {
    $checkData = $this->where('userid',$param['userid'])->find();
    if ($checkData) {
        $this->error = '用户名不能重复';
        return false;
    }
    $param['userpwd'] = md5($param["pwd"]);
    $param['beizhu1'] = date("Y-m-d H:i:s",$param["beizhu1"]);
    $param['ctime'] = date("Y-m-d H:i:s",time());
    $this->startTrans();
    try {
      $this->allowField(true)->save($param);
      $this->commit();
      return true;
    } catch (\Exception $e) {
        $this->rollback();
        $this->error = '添加失败';
        return false;
    }
  }

  /**
   * [getDataById 根据主键获取详情]
   * @linchuangbin
   * @DateTime  2017-02-10T21:16:34+0800
   * @param     string                   $id [主键]
   * @return    [array]
   */
  public function getDataById($id = '')
  {
      $data = $this->get($id);
      if (!$data) {
          $this->error = '暂无此数据';
          return false;
      }
      $data['beizhu1'] = strtotime($data['beizhu1']);
      return $data;
  }

  /**
   * 通过id修改用户
   * @param  array   $param  [description]
   */
  public function updateDataById($param, $id)
  {

      $checkData = $this->get($id);
      if (!$checkData) {
          $this->error = '暂无此数据';
          return false;
      }
      $this->startTrans();
      try {
          $this->allowField(true)->save($param, ['id' => $id]);
          $this->commit();
          return true;
      } catch (\Exception $e) {
          $this->rollback();
          $this->error = '编辑失败';
          return false;
      }
  }
}
