import Login from './components/Account/Login.vue'
import refresh from './components/refresh.vue'
import Home from './components/Home.vue'
import systemConfig from './components/Administrative/system/config/add.vue'
import systemEmail from './components/Administrative/system/config/email.vue'
import systemSms from './components/Administrative/system/config/sms.vue'
import databaseList from './components/Administrative/system/database/list.vue'
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
      { path: 'config/add', component: systemConfig, name: 'systemConfig', meta: { hideLeft: false, module: 'System', menu: 'systemConfig' }},
      { path: 'config/email', component: systemEmail, name: 'systemEmail', meta: { hideLeft: false, module: 'System', menu: 'systemEmail' }},
      { path: 'config/sms', component: systemSms, name: 'systemSms', meta: { hideLeft: false, module: 'System', menu: 'systemSms' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: 'database/list', component: databaseList, name: 'databaseList', meta: { hideLeft: false, module: 'Database', menu: 'databaseList' }}
    ]
  }
]
export default routes
