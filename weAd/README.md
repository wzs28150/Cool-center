# 产品微广告 广告植入

## 主要使用技术栈
* Vue.JS 2.x <https://cn.vuejs.org/>
* element-ui <http://element.eleme.io>
* Swiper 3.x <http://swiper.com.cn>
* axios  <https://github.com/mzabriskie/axios>
* fontawesome <http://fontawesome.io/icons/>
* js-cookie  <https://github.com/js-cookie/js-cookie>
* lockr  <https://github.com/tsironis/lockr>
* lodash  <http://lodashjs.com/docs/>
* moment  <http://momentjs.cn/>
* mescroll <http://www.mescroll.com/>
### 客户端部署

1.安装node.js
  前端部分是基于node.js上运行的，所以必须先安装node.js，版本要求为6.9.0以上(推荐安装官方推荐版本)，下载地址：https://nodejs.org/zh-cn/

2.使用npm安装依赖
  进入frontEnd目录，执行命令安装依赖：npm install(可安装cnpm 使用cnpm install)

3.修改内部配置
  修改请求地址或域名：build/webpack.base.conf.js里修改DEV_HOST（开发环境服务端地址，默认localhost）
  修改自定义端口：config/index.js里面的dev对象的port参数（默认8080，不建议修改）

4.运行前端
  npm run dev
5.打包前端
  npm run build
6.部署服务器配置伪静态
```
location / {
 try_files $uri $uri/ @router;
 index  index.html index.htm;
}

location @router {
 rewrite ^.*$ /index.html last;
}
error_page 404 /404.html;
 location = /40x.html {
}
error_page 500 502 503 504 /50x.html;
 location = /50x.html {
}
```

注意：前端服务启动，默认会占用8080端口，所以在启动前端服务之前，请确认8080端口没有被占用。

* 程序运行之前需搭建好Server api端

### api端

## 主要使用技术栈

* querylist <https://www.querylist.cc/> 抓取新闻
* Redis <https://redis.io/> 缓存
