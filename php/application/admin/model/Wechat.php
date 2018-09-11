<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\model;

use think\Db;
use app\admin\model\Common;
use com\verify\HonrayVerify;
class Wechat extends Common
{
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'wx_user';
    protected $insert = ['status' => 1];

    /**
     * 通过id修改用户
     * @param  array   $param  [description]
     */
    public function updateDataById($param, $id)
    {
        // 不能操作超级管理员
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
