<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;

class Ad extends Common
{
  protected $name = 'ad';


  /**
   * 创建用户
   * @param  array   $param  [description]
   */
  public function createData($param)
  {
      $this->startTrans();
      try {
          $param['addtime'] = date('Y-m-d H:i:s',time());
          $this->data($param)->allowField(true)->save();
          $this->commit();
          return true;
      } catch (\Exception $e) {
          $this->rollback();
          $this->error = '添加失败';
          return false;
      }
  }

  /**
   * [getDataList 列表]
   * @AuthorHTL
   * @DateTime  2017-02-10T22:19:57+0800
   * @param     [string]                   $keywords [关键字]
   * @param     [number]                   $page     [当前页数]
   * @param     [number]                   $limit    [t每页数量]
   * @return    [array]                             [description]
   */
  public function getDataList($keywords, $page, $limit, $uid, $mid='')
  {
      $map = [];

      if($uid!=1){
        $map['user.id'] = $uid;
      }

      if($mid){
        $map['member.id'] = $mid;
      }
      if($keywords){
        $map['ad_title'] = ['like','%'.$keywords.'%'];
      }

      $dataCount = $this->alias('ad')->join('oa_member member', 'member.id = ad.userid', 'LEFT')->join('oa_admin_user user', 'member.shuyu = user.id', 'LEFT')->where($map)->fetchsql(false)->count('ad.id');

      $list = $this->alias('ad')->join('oa_member member', 'member.id = ad.userid', 'LEFT')->join('oa_admin_user user', 'member.shuyu = user.id', 'LEFT')->where($map);
      // 若有分页
      if ($page && $limit) {
          $list = $list->page($page, $limit);
      }
      $list = $list->field('ad.*')->order('ad.addtime desc')->fetchsql(false)->select();
      foreach ($list as $key => $value) {
        $info = Db::name('member')->find($value['userid']);
        $list[$key]['username'] = $info['username'];
        $list[$key]['ad_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['ad_img'];
        $list[$key]['ad_img_one'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['ad_img_one'];
        $list[$key]['ad_img_two'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['ad_img_two'];
        $list[$key]['erweima'] = 'http://'.$_SERVER['HTTP_HOST'].'/'.$value['erweima'];
      }
      $data['list'] = $list;
      $data['dataCount'] = $dataCount;
      return $data;
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
