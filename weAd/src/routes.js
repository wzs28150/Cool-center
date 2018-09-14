import Login from './components/Account/Login.vue'
import refresh from './components/refresh.vue'
import Home from './components/Home.vue'
import Homen from './components/Homen.vue'
import Homens from './components/Homens.vue'
import main from './components/Main/index.vue'
import articleEdit from './components/Main/edit.vue'
import articleAdd from './components/Main/add.vue'
import articleInfo from './components/Article/info.vue'
import articleInfon from './components/Article/infon.vue'
import me from './components/Me/index.vue'
import list from './components/Me/list.vue'
/**
 * meta参数解析
 * hideLeft: 是否隐藏左侧菜单，单页菜单为true
 * module: 菜单所属模块
 * menu: 所属菜单，用于判断三级菜单是否显示高亮，如菜单列表、添加菜单、编辑菜单都是'menu'，用户列表、添加用户、编辑用户都是'user'，如此类推
 */

const routes = [
  {
    path: '/homen',
    component: Homen,
    children: [
      { path: '/article/infon/:id', component: articleInfo, name: 'articleInfonn', meta: { hideLeft: false, module: 'Main', menu: 'articleInfonn', title: '文章详细' }},
      { path: '/article/infonn/:id', component: articleInfo, name: 'articleInfonnn', meta: { hideLeft: false, module: 'Main', menu: 'articleInfonnn', title: '文章详细' }}
    ]
  },
  { path: '/', component: Login, name: 'Login', title: '登录' },
  {
    path: '/home',
    component: Home,
    children: [
      { path: '/refresh', component: refresh, name: 'refresh', title: '刷新' }
    ]
  },
  {
    path: '/home',
    component: Homens,
    children: [
      { path: '/main', component: main, name: 'main', meta: { hideLeft: false, module: 'Main', menu: 'main', title: '首页' }}
    ]
  },
  {
    path: '/home',
    component: Home,
    children: [
      { path: '/article/edit', component: articleEdit, name: 'articleEdit', meta: { hideLeft: false, module: 'Main', menu: 'main', title: '设置广告' }},
      { path: '/article/add/:id', component: articleAdd, name: 'articleAdd', meta: { hideLeft: false, module: 'Main', menu: 'main', title: '编辑文章' }},
      { path: '/article/info/:id', component: articleInfo, name: 'articleInfo', meta: { hideLeft: false, module: 'Main', menu: 'main', title: '文章详细' }},
      { path: '/articlen/info', component: articleInfon, name: 'articleInfon', meta: { hideLeft: false, module: 'Main', menu: 'main', title: '文章详细' }}
    ]
  },
  {
    path: '/me',
    component: Home,
    children: [
      { path: '/me', component: me, name: 'me', meta: { hideLeft: false, module: 'Me', menu: 'me', title: '我的' }}
    ]
  },
  {
    path: '/me',
    component: Homens,
    children: [
      { path: '/me/list', component: list, name: 'list', meta: { hideLeft: false, module: 'Me', menu: 'me', title: '我发布的' }}
    ]
  }
]
export default routes
