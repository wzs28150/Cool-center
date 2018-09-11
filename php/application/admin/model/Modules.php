<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;

class Modules extends Common
{
  protected $name = 'admin_module';
  /**
   * [getDataList 列表]
   * @AuthorHTL
   * @DateTime  2017-02-10T22:19:57+0800
   * @param     [string]                   $keywords [关键字]
   * @param     [number]                   $page     [当前页数]
   * @param     [number]                   $limit    [t每页数量]
   * @return    [array]                             [description]
   */
  public function getDataList($keywords, $page, $limit)
  {
      $map = [];
      $dataCount = $this->where($map)->count('id');
      $list = $this->where($map);
      // 若有分页
      if ($page && $limit) {
          $list = $list->page($page, $limit);
      }
      $list = $list->select();
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
      // $data['groups'] = $this->get($id)->groups;
      return $data;
  }
  /**
   * 创建模型
   * @param  array   $param  [description]
   */
  public function createData($param)
  {
      // 验证
      //获取数据库所有表名
      $tables = Db::getTables();
      //组装表名
      $prefix = config('database.prefix');
      $tablename = $prefix.$param['name'];
      //判断表名是否已经存在
      if(in_array($tablename,$tables)){
          $result['status'] = 0;
          $result['info'] = '该表已经存在！';
          return $result;
      }
      $name = ucfirst($param['name']);
      $data['title'] = $param['title'];
      $data['name'] = $param['name'];
      $data['listfields'] = $param['listfields'];
      $data['description'] = $param['description'];
      $data['type'] = 1;
      $data['setup'] = "";
      $moduleid = $this->insertGetId($data);
      if(empty($moduleid)){
          $result['code'] = 0;
          $result['msg'] = '添加模型失败！';
          return $result;
      }
      $emptytable =input('post.emptytable');
      if($emptytable=='0') {
        $sql1 = "CREATE TABLE `".$tablename."` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`catid` smallint(5) unsigned NOT NULL DEFAULT '0',`userid` int(8) unsigned NOT NULL DEFAULT '0',`username` varchar(40) NOT NULL DEFAULT '',`title` varchar(120) NOT NULL DEFAULT '',`title_style` varchar(225) NOT NULL DEFAULT '',`thumb` varchar(225) NOT NULL DEFAULT '',`keywords` varchar(120) NOT NULL DEFAULT '',`description` mediumtext NOT NULL,`content` mediumtext NOT NULL,`template` varchar(40) NOT NULL DEFAULT '',`posid` tinyint(2) unsigned NOT NULL DEFAULT '0',`status` tinyint(1) unsigned NOT NULL DEFAULT '0',`recommend` tinyint(1) unsigned NOT NULL DEFAULT '0',`readgroup` varchar(100) NOT NULL DEFAULT '',`readpoint` smallint(5) NOT NULL DEFAULT '0',`listorder` int(10) unsigned NOT NULL DEFAULT '0',`hits` int(11) unsigned NOT NULL DEFAULT '0',`createtime` int(11) unsigned NOT NULL DEFAULT '0',`updatetime` int(11) unsigned NOT NULL DEFAULT '0',PRIMARY KEY (`id`),KEY `status` (`id`,`status`,`listorder`),KEY `catid` (`id`,`catid`,`status`),KEY `listorder` (`id`,`catid`,`status`,`listorder`)) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";
        Db::execute($sql1);
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'catid', '栏目', '', '1', '1', '6', '', '必须选择一个栏目', '', 'catid', '','1','', '1', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'title', '标题', '', '1', '1', '80', '', '标题必须为1-80个字符', '', 'title', 'array (\n  \'thumb\' => \'1\',\n  \'style\' => \'1\',\n  \'size\' => \'55\',\n)','1','',  '2', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'keywords', '关键词', '', '0', '0', '80', '', '', '', 'text', 'array (\n  \'size\' => \'55\',\n  \'default\' => \'\',\n  \'ispassword\' => \'0\',\n  \'fieldtype\' => \'varchar\',\n)','1','',  '3', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'description', 'SEO简介', '', '0', '0', '0', '', '', '', 'textarea', 'array (\n  \'fieldtype\' => \'mediumtext\',\n  \'rows\' => \'4\',\n  \'cols\' => \'55\',\n  \'default\' => \'\',\n)','1','',  '4', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'content', '内容', '', '0', '0', '0', '', '', '', 'editor', 'array (\n  \'toolbar\' => \'full\',\n  \'default\' => \'\',\n  \'height\' => \'\',\n  \'showpage\' => \'1\',\n  \'enablekeylink\' => \'0\',\n  \'replacenum\' => \'\',\n  \'enablesaveimage\' => \'0\',\n  \'flashupload\' => \'1\',\n  \'alowuploadexts\' => \'\',\n)','1','',  '5', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'createtime', '发布时间', '', '1', '0', '0', 'date', '', '', 'datetime', '','1','',  '6', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'status', '状态', '', '0', '0', '0', '', '', '', 'radio', 'array (\n  \'options\' => \'发布|1\r\n定时发布|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'numbertype\' => \'1\',\n  \'labelwidth\' => \'75\',\n  \'default\' => \'1\',\n)','1','','7', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'recommend', '允许评论', '', '0', '0', '1', '', '', '', 'radio', 'array (\n  \'options\' => \'允许评论|1\r\n不允许评论|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'numbertype\' => \'1\',\n  \'labelwidth\' => \'\',\n  \'default\' => \'\',\n)','1','', '8', '0', '0')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'readpoint', '阅读收费', '', '0', '0', '5', '', '', '', 'number', 'array (\n  \'size\' => \'5\',\n  \'numbertype\' => \'1\',\n  \'decimaldigits\' => \'0\',\n  \'default\' => \'0\',\n)','1','', '9', '0', '0')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'hits', '点击次数', '', '0', '0', '8', '', '', '', 'number', 'array (\n  \'size\' => \'10\',\n  \'numbertype\' => \'1\',\n  \'decimaldigits\' => \'0\',\n  \'default\' => \'0\',\n)','1','',  '10', '0', '0')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'readgroup', '访问权限', '', '0', '0', '0', '', '', '', 'groupid', 'array (\n  \'inputtype\' => \'checkbox\',\n  \'fieldtype\' => \'tinyint\',\n  \'labelwidth\' => \'85\',\n  \'default\' => \'\',\n)','1','', '11', '0', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'posid', '推荐位', '', '0', '0', '0', '', '', '', 'posid', '','1','', '12', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'template', '模板', '', '0', '0', '0', '', '', '', 'template', '','1','', '13', '1', '1')");
      } else {
        $sql2 = "CREATE TABLE `".$tablename."` (`id` int(11) unsigned NOT NULL AUTO_INCREMENT,`title` varchar(120) NOT NULL DEFAULT '',`title_style` varchar(225) NOT NULL DEFAULT '',`thumb` varchar(225) NOT NULL DEFAULT '',`hits` int(11) unsigned NOT NULL DEFAULT '0',`status` tinyint(1) unsigned NOT NULL DEFAULT '0',`userid` int(8) unsigned NOT NULL DEFAULT '0',`username` varchar(40) NOT NULL DEFAULT '',`listorder` int(10) unsigned NOT NULL DEFAULT '0',`createtime` int(11) unsigned NOT NULL DEFAULT '0',`updatetime` int(11) unsigned NOT NULL DEFAULT '0',`lang` tinyint(1) unsigned NOT NULL DEFAULT '0',`template` varchar(40) NOT NULL DEFAULT '',PRIMARY KEY (`id`)) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8";
        Db::execute($sql2);
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'title', '标题', '', '1', '1', '80', '', '标题必须为1-80个字符', '', 'title', 'array (\n  \'thumb\' => \'1\',\n  \'style\' => \'1\',\n  \'size\' => \'55\',\n)','1','',  '2', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'hits', '点击次数', '', '0', '0', '8', '', '', '', 'number', 'array (\n  \'size\' => \'10\',\n  \'numbertype\' => \'1\',\n  \'decimaldigits\' => \'0\',\n  \'default\' => \'0\',\n)','1','',  '8', '0', '0')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'createtime', '发布时间', '', '1', '0', '0', 'date', '', '', 'datetime', '','1','',  '97', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'template', '模板', '', '0', '0', '0', '', '', '', 'template', '','1','', '99', '1', '1')");
        Db::execute("INSERT INTO `".$prefix."admin_field` VALUES (NULL, '".$moduleid."', 'status', '状态', '', '0', '0', '0', '', '', '', 'radio', 'array (\n  \'options\' => \'发布|1\r\n定时发布|0\',\n  \'fieldtype\' => \'tinyint\',\n  \'numbertype\' => \'1\',\n  \'labelwidth\' => \'75\',\n  \'default\' => \'1\',\n)','1','', '98', '1', '1')");
      }
      if($moduleid !== false) {
          return true;
      }
  }

  public function getDatafieldList($mid, $keywords, $page, $limit)
  {
    $map = [];
    $dataCount = $this->where($map)->count('id');
    $list = $this->where($map);
    // 若有分页
    if ($page && $limit) {
        $list = $list->page($page, $limit);
    }
    $list = $list->select();
    $data['list'] = $list;
    $data['dataCount'] = $dataCount;
    return $data;
  }

}
