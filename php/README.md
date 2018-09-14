Cool-center
===============

## 项目介绍
起初，Cool-center是一套个人搭建的基于Vue全家桶（Vue2.x + Vue-router2.x + Vuex）+ electron + Thinkphp5的前后端分离的微信广告植入系统。

后来，觉得可扩展为一个平台并进行修改整合开发

所以，Cool-center是一个多产品管理平台，且广泛适用于B/S架构的项目开发。Cool-center是对前后端分离技术的应用实践，2018年由酷创网络技术团队研发并投入商业开发使用。框架开源，希望能有更多志同道合的伙伴参与Cool-center的迭代 ^_^


## 使用许可：
Cool-center是基于MIT协议的开源框架，它完全免费。你可以免费下载Cool-center，用来搭建自己的或者团体的软件。

## 主要适用技术栈
* api框架：ThinkPHP 5.0.x
* 客户端MVVM框架：Vue.JS 2.x
  管理端：Vue.JS 2.x + electron ^2.0.9 打包 桌面应用程序
* 开发工作流：Webpack 1.x
* 路由：Vue-Router 2.x
* 数据交互：Axios
* 代码风格检测：Eslint
* UI框架：Element-UI 2.4.6
* JS函数库：Lodash

> Cool-center的运行环境要求PHP5.6以上。

<!-- 详细开发文档参考 [ThinkPHP5完全开发手册](http://www.kancloud.cn/manual/thinkphp5) -->

## 系统功能

* 登录、退出登录
* 修改密码、记住密码
* 菜单管理
* 系统参数
* 权限节点
* 用户组管理
* 用户管理
* 用户管理
* 产品中心
* 广告管理
* 文章管理
* 公众号设置

### Demo

演示地址：<http://ad.coolwx.com.cn>

用户名：user01

密码：user01

### QQ群交流

欢迎加入qq群：711296415

### 开发依赖

* vue <https://vuefe.cn/v2/guide/>
* element-ui <http://element.eleme.io>
* axios  <https://github.com/mzabriskie/axios>
* fontawesome <http://fontawesome.io/icons/>
* js-cookie  <https://github.com/js-cookie/js-cookie>
* lockr  <https://github.com/tsironis/lockr>
* lodash  <http://lodashjs.com/docs/>
* moment  <http://momentjs.cn/>
* electron <https://github.com/electron/electron>

## 数据交互

数据交互通过axios以及RESTful架构来实现

用户校验通过登录返回的auth_key放在header

值得注意的一点是：跨域的情况下，会有预请求OPTION的情况


## Server搭建
服务端使用的框架为thinkphp5.搭建前请确保拥有lamp/lnmp/wamp环境。

集成环境推荐使用phpstudy：<http://www.phpstudy.net/>
或者phpset：<http://www.phpset.cn/>

这里所说的搭建其实就是把server框架放入WEB运行环境，并使用80端口。

导入服务端根文件夹数据库文件install.sql，(数据库内用户表账号root,数据库名*****，密码123456)并修改config/database.php配置文件。

* PHP >= 5.6.0
* PDO PHP Extension
* MBstring PHP Extension
* CURL PHP Extension
* Redis

服务端开发手册请参考：<http://www.kancloud.cn/manual/thinkphp5/118003>

当访问 <http://localhost>, 出现“coolCenter接口”即代表后端接口搭建成功。

## 服务端重写配置
```
请参考[ThinPHP重写](https://www.kancloud.cn/manual/thinkphp5_1/353955)
```



### 前端搭建
```
请参考frontEnd里的README文件
```
