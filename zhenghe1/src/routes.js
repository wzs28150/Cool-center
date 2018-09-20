import Login from './components/Account/Login.vue'
import refresh from './components/refresh.vue'
import Home from './components/Home.vue'
import Homen from './components/Homen.vue'
import main from './components/Administrative/Main/index.vue'

import center from './components/Administrative/Center/index.vue'
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
    component: Homen,
    children: [
      {path: 'main', component: main, name: 'main', meta: { hideLeft: false, hideCenter: false, module: 'Main', menu: 'main', title: '系统首页' }}
    ]
  },
  ...generateRoutesFromMenu(menuModule.state.items)
]

function generateRoutesFromMenu (menu = [], routes = []) {
  for (let i = 0, l = menu.length; i < l; i++) {
    let item = menu[i]
    if (item.path) {
      routes.push(item)
    }
  }
  return routes
}
export default routes
