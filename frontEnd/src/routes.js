import Login from './components/Account/Login.vue'
import refresh from './components/refresh.vue'
import Home from './components/Home.vue'
import Homen from './components/Homen.vue'
import systemConfig from './components/Administrative/system/config/add.vue'
import systemEmail from './components/Administrative/system/config/email.vue'
import systemSms from './components/Administrative/system/config/sms.vue'
import databaseList from './components/Administrative/system/database/list.vue'
import databaseRestore from './components/Administrative/system/database/restore.vue'
import ruleList from './components/Administrative/system/rule/list.vue'
import ruleAdd from './components/Administrative/system/rule/add.vue'
import ruleEdit from './components/Administrative/system/rule/edit.vue'
import groupsList from './components/Administrative/structures/groups/list.vue'
import groupsAdd from './components/Administrative/structures/groups/add.vue'
import groupsEdit from './components/Administrative/structures/groups/edit.vue'
import usersList from './components/Administrative/personnel/users/list.vue'
import usersAdd from './components/Administrative/personnel/users/add.vue'
import usersEdit from './components/Administrative/personnel/users/edit.vue'
import menuList from './components/Administrative/system/menu/list.vue'
import menuAdd from './components/Administrative/system/menu/add.vue'
import menuEdit from './components/Administrative/system/menu/edit.vue'
import moduleList from './components/Module/module/list.vue'
import moduleAdd from './components/Module/module/add.vue'
import moduleEdit from './components/Module/module/edit.vue'
import fieldList from './components/Module/field/list.vue'
import wechatConfig from './components/Wechat/weixin/index.vue'
import memberList from './components/Member/index.vue'
import memberAdd from './components/Member/add.vue'
import memberEdit from './components/Member/edit.vue'
import adAdd from './components/Ad/add.vue'
import adList from './components/Ad/list.vue'
import adEdit from './components/Ad/edit.vue'
import articleList from './components/Article/list.vue'
import articleEdit from './components/Article/edit.vue'
import main from './components/Administrative/system/main/index.vue'
/**
 * meta参数解析
 * hideLeft: 是否隐藏左侧菜单，单页菜单为true
 * module: 菜单所属模块
 * menu: 所属菜单，用于判断三级菜单是否显示高亮，如菜单列表、添加菜单、编辑菜单都是'menu'，用户列表、添加用户、编辑用户都是'user'，如此类推
 */

const routes = [
  { path: '/', component: Login, name: 'Login' },
  {
    path: '/home',
    component: Home,
    children: [
      { path: '/refresh', component: refresh, name: 'refresh' }
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'config/add', component: systemConfig, name: 'systemConfig', meta: { hideLeft: false, module: 'System', menu: 'systemConfig', title: '系统设置' }},
      { path: 'config/email', component: systemEmail, name: 'systemEmail', meta: { hideLeft: false, module: 'System', menu: 'systemEmail', title: '邮箱设置' }},
      { path: 'config/sms', component: systemSms, name: 'systemSms', meta: { hideLeft: false, module: 'System', menu: 'systemSms', title: '短信设置' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'database/list', component: databaseList, name: 'databaseList', meta: { hideLeft: false, module: 'Database', menu: 'databaseList', title: '数据库管理' }},
      { path: 'database/restore', component: databaseRestore, name: 'databaseRestore', meta: { hideLeft: false, module: 'Database', menu: 'databaseRestore', title: '数据库还原' }}
    ]
  },
  {
    path: '/home',
    component: Homen,
    children: [
      { path: 'main', component: main, name: 'main', meta: { hideLeft: false, module: 'Main', menu: 'main', title: '系统首页' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'rule/list', component: ruleList, name: 'ruleList', meta: { hideLeft: false, module: 'Auth', menu: 'rule', title: '权限设置' }},
      { path: 'rule/add', component: ruleAdd, name: 'ruleAdd', meta: { hideLeft: false, module: 'Auth', menu: 'rule', title: '权限添加' }},
      { path: 'rule/edit/:id', component: ruleEdit, name: 'ruleEdit', meta: { hideLeft: false, module: 'Auth', menu: 'rule', title: '权限编辑' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'menu/list', component: menuList, name: 'menuList', meta: { hideLeft: false, module: 'Menu', menu: 'menu', title: '菜单列表' }},
      { path: 'menu/add', component: menuAdd, name: 'menuAdd', meta: { hideLeft: false, module: 'Menu', menu: 'menu', title: '菜单添加' }},
      { path: 'menu/edit/:id', component: menuEdit, name: 'menuEdit', meta: { hideLeft: false, module: 'Menu', menu: 'menu', title: '菜单修改' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'module/list', component: moduleList, name: 'moduleList', meta: { hideLeft: false, module: 'Module', menu: 'module', title: '模型列表' }},
      { path: 'module/add', component: moduleAdd, name: 'moduleAdd', meta: { hideLeft: false, module: 'Module', menu: 'module', title: '模型添加' }},
      { path: 'module/edit/:id', component: moduleEdit, name: 'moduleEdit', meta: { hideLeft: false, module: 'Module', menu: 'module', title: '模型编辑' }},
      { path: 'module/field/:id', component: fieldList, name: 'fieldList', meta: { hideLeft: false, module: 'Module', menu: 'module', title: '字段管理' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'groups/list', component: groupsList, name: 'groupsList', meta: { hideLeft: false, module: 'Administrative', menu: 'groups', title: '用户组管理' }},
      { path: 'groups/add', component: groupsAdd, name: 'groupsAdd', meta: { hideLeft: false, module: 'Administrative', menu: 'groups', title: '用户组添加' }},
      { path: 'groups/edit/:id', component: groupsEdit, name: 'groupsEdit', meta: { hideLeft: false, module: 'Administrative', menu: 'groups', title: '用户组编辑' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'users/list', component: usersList, name: 'usersList', meta: { hideLeft: false, module: 'Administrative', menu: 'users', title: '管理员列表' }},
      { path: 'users/add', component: usersAdd, name: 'usersAdd', meta: { hideLeft: false, module: 'Administrative', menu: 'users', title: '管理员添加' }},
      { path: 'users/edit/:id', component: usersEdit, name: 'usersEdit', meta: { hideLeft: false, module: 'Administrative', menu: 'users', title: '管理员编辑' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'wechat/index', component: wechatConfig, name: 'wechatConfig', meta: { hideLeft: false, module: 'Wechat', menu: 'wechat', title: '微信公众号设置' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'member/list', component: memberList, name: 'memberList', meta: { hideLeft: false, module: 'Member', menu: 'memberList', title: '会员管理' }},
      { path: 'member/add', component: memberAdd, name: 'memberAdd', meta: { hideLeft: false, module: 'Member', menu: 'memberAdd', title: '会员添加' }},
      { path: 'member/edit/:id', component: memberEdit, name: 'memberEdit', meta: { hideLeft: false, module: 'Member', menu: 'memberEdit', title: '会员编辑' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'ad/index', component: adList, name: 'adList', meta: { hideLeft: false, module: 'Ad', menu: 'adList', title: '广告管理' }},
      { path: 'ad/add/:id', component: adAdd, name: 'adAdd', meta: { hideLeft: false, module: 'Ad', menu: 'adAdd', title: '广告添加' }},
      { path: 'ad/edit/:id', component: adEdit, name: 'adEdit', meta: { hideLeft: false, module: 'Ad', menu: 'adEdit', title: '广告编辑' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'article/list', component: articleList, name: 'articleList', meta: { hideLeft: false, module: 'Article', menu: 'articleList', title: '文章管理' }},
      { path: 'article/edit/:id', component: articleEdit, name: 'articleEdit', meta: { hideLeft: false, module: 'Article', menu: 'articleEdit', title: '文章编辑' }}
    ]
  }
]
export default routes
