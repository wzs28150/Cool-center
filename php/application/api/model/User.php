<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\api\model;

use think\Db;
use app\api\model\Common;
use com\verify\HonrayVerify;
class User extends Common
{
    /**
     * 为了数据库的整洁，同时又不影响Model和Controller的名称
     * 我们约定每个模块的数据表都加上相同的前缀，比如微信模块用weixin作为数据表前缀
     */
    protected $name = 'member';
    protected $createTime = 'ctime';
    protected $updateTime = false;
    protected $autoWriteTimestamp = true;
    protected $insert = ['status' => 1];

    /**
     * [login 登录]
     * @AuthorHTL
     * @DateTime  2017-02-10T22:37:49+0800
     * @param     [string]                   $u_username [账号]
     * @param     [string]                   $u_pwd      [密码]
     * @param     [string]                   $verifyCode [验证码]
     * @param     Boolean                  	 $isRemember [是否记住密码]
     * @param     Boolean                    $type       [是否重复登录]
     * @return    [type]                               [description]
     */
    public function login($username, $userpwd, $verifyCode = '', $isRemember = false, $type = false)
    {
        if (!$username) {
            $this->error = '帐号不能为空';
            return false;
        }
        if (!$userpwd) {
            $this->error = '密码不能为空';
            return false;
        }
        if (config('IDENTIFYING_CODE') && !$type) {
            if (!$verifyCode) {
                $this->error = '验证码不能为空';
                return false;
            }
            $captcha = new HonrayVerify(config('captcha'));
            if (!$captcha->check($verifyCode)) {
                $this->error = '验证码错误';
                return false;
            }
        }
        $map['userid'] = $username;
        $userInfo = $this->where($map)->fetchsql(false)->find();
        // echo $userInfo;exit;
        if (!$userInfo) {
            $this->error = '帐号不存在';
            return false;
        }
        if (md5($userpwd) !== $userInfo['userpwd']) {
            $this->error = '密码错误' . user_md5($userpwd);
            return false;
        }
        if(strtotime($userInfo['beizhu1']) < time()){
            $this->error = '帐号已到期,请联系客服续费~';
            return false;
        }
        // if ($userInfo['status'] === 0) {
        //     $this->error = '帐号已被禁用';
        //     return false;
        // }
        // 获取菜单和权限
        // $dataList = $this->getMenuAndRule($userInfo['id']);
        // dump($dataList);
        // if (!$dataList['menusList']) {
        //     $this->error = '没有权限';
        //     return false;
        // }
        if ($isRemember || $type) {
            $secret['username'] = $username;
            $secret['userpwd'] = $userpwd;
            $data['rememberKey'] = encrypt($secret);
        }
        // 保存缓存
        session_start();
        $info['userInfo'] = $userInfo;
        $info['sessionId'] = session_id();
        $authKey = user_md5($userInfo['username'] . $userInfo['userpwd'] . $info['sessionId']);
        $info['_AUTH_LIST_'] = $dataList['rulesList'];
        $info['authKey'] = $authKey;
        cache('Auth_' . $authKey, null);
        cache('Auth_' . $authKey, $info, config('LOGIN_SESSION_VALID'));
        // 返回信息
        $data['authKey'] = $authKey;
        $data['sessionId'] = $info['sessionId'];
        $data['userInfo'] = $userInfo;
        // dump($data);exit;
        // $data['authList'] = $dataList['rulesList'];
        // $data['menusList'] = $dataList['menusList'];
        return $data;
    }
    /**
     * 修改密码
     * @param  array   $param  [description]
     */
    public function setInfo($auth_key, $old_pwd, $new_pwd)
    {
        $cache = cache('Auth_' . $auth_key);
        if (!$cache) {
            $this->error = '请先进行登录';
            return false;
        }
        if (!$old_pwd) {
            $this->error = '请输入旧密码';
            return false;
        }
        if (!$new_pwd) {
            $this->error = '请输入新密码';
            return false;
        }
        if ($new_pwd == $old_pwd) {
            $this->error = '新旧密码不能一致';
            return false;
        }
        $userInfo = $cache['userInfo'];
        $userpwd = $this->where('id', $userInfo['id'])->value('userpwd');
        if (user_md5($old_pwd) != $userpwd) {
            $this->error = '原密码错误';
            return false;
        }
        if (user_md5($new_pwd) == $userpwd) {
            $this->error = '密码没改变';
            return false;
        }
        if ($this->where('id', $userInfo['id'])->setField('userpwd', user_md5($new_pwd))) {
            $userInfo = $this->where('id', $userInfo['id'])->find();
            // 重新设置缓存
            session_start();
            $cache['userInfo'] = $userInfo;
            $cache['authKey'] = user_md5($userInfo['username'] . $userInfo['userpwd'] . session_id());
            cache('Auth_' . $auth_key, null);
            cache('Auth_' . $cache['authKey'], $cache, config('LOGIN_SESSION_VALID'));
            return $cache['authKey'];
            //把auth_key传回给前端
        }
        $this->error = '修改失败';
        return false;
    }
    /**
     * 获取菜单和权限
     * @param  array   $param  [description]
     */
    protected function getMenuAndRule($u_id)
    {
        if ($u_id === 1) {
            $map['status'] = 1;
            $menusList = Db::name('admin_menu')->where($map)->order('sort asc')->select();
        } else {
					// dump($this);exit;
            $groups = $this->get($u_id)->groups;
						// dump($groups);exit;
            $ruleIds = [];
            foreach ($groups as $k => $v) {
                $ruleIds = array_unique(array_merge($ruleIds, explode(',', $v['rules'])));
            }
						//dump($groups);exit;
            $ruleMap['id'] = array('in', $ruleIds);
            $ruleMap['status'] = 1;
            // 重新设置ruleIds，除去部分已删除或禁用的权限。
            $rules = Db::name('admin_rule')->where($ruleMap)->select();

            foreach ($rules as $k => $v) {
                $ruleIds[] = $v['id'];
                $rules[$k]['name'] = strtolower($v['name']);
            }
            empty($ruleIds) && ($ruleIds = '');
            $menuMap['status'] = 1;
            $menuMap['rule_id'] = array('in', $ruleIds);

            $menusList = Db::name('admin_menu')->where($menuMap)->order('sort asc')->fetchsql(false)->select();

        }
        if (!$menusList) {
            return null;
        }
        //处理菜单成树状
        $tree = new \com\Tree();

        $ret['menusList'] = $tree->list_to_tree($menusList, 'id', 'pid', 'child', 0, true, array('pid'));
        // dump($ret['menusList']);
        $ret['menusList'] = memuLevelClear($ret['menusList']);

        // 处理规则成树状
        // dump($tree->list_to_tree($rules, 'id', 'pid', 'child', 0, true, array('pid')));
        $ret['rulesList'] = $tree->list_to_tree($rules, 'id', 'pid', 'child', 0, true, array('pid'));
        $ret['rulesList'] = rulesDeal($ret['rulesList']);
				// dump($ret);
        return $ret;

    }
}
