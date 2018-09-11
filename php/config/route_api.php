<?php
// +----------------------------------------------------------------------
// | Description: 基础框架路由配置文件
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honghaiweb.com>
// +----------------------------------------------------------------------

return [
    // 定义资源路由
    '__rest__'=>[
        'api/rules'		   =>'api/rules',
        'api/groups'		   =>'api/groups',
        'api/users'		   =>'api/users',
        'api/menus'		   =>'api/menus',
        'api/structures'	   =>'api/structures',
        'api/posts'          =>'api/posts',
        'api/module'          =>'api/module',
        'api/field'          =>'api/field',
        'api/wechat'          =>'api/wechat',
        'api/member'          =>'api/member',
    ],

	// 【基础】登录
	'api/base/login' => ['api/base/login', ['method' => 'POST']],
	// 【基础】记住登录
	'api/base/relogin'	=> ['api/base/relogin', ['method' => 'POST']],
	// 【基础】修改密码
	'api/base/setInfo' => ['api/base/setInfo', ['method' => 'POST']],
	// 【基础】退出登录
	'api/base/logout' => ['api/base/logout', ['method' => 'POST']],
	// 【基础】获取配置
	'api/base/getConfigs' => ['api/base/getConfigs', ['method' => 'POST']],
	// 【基础】获取验证码
	'api/base/getVerify' => ['api/base/getVerify', ['method' => 'GET']],
  // 【文章】获取广告列表
	'api/article/adlist/:id' => ['api/article/adlist', ['method' => 'GET']],
  // 【文章】采集
  'api/article' => ['api/article/index', ['method' => 'GET']],
  // 【文章】采集
  'api/article/add' => ['api/article/add', ['method' => 'POST']],
  'api/article/save' => ['api/article/save', ['method' => 'POST']],
  'api/articleinfo/:id' => ['api/article/info', ['method' => 'GET']],
  'api/articleread/:id' => ['api/info/read', ['method' => 'GET']],
  'api/articlereadn' => ['api/info/readn', ['method' => 'POST']],
  'api/me/:id' => ['api/me/index', ['method' => 'GET']],
  'api/me/delete' => ['api/me/delete', ['method' => 'POST']],
  'api/base/imgproxy' => ['api/base/imgproxy', ['method' => 'GET']],
  'api/jsdk' => ['api/jsdk/index', ['method' => 'GET']],
	// MISS路由
	'__miss__'  => 'api/base/miss',
];
