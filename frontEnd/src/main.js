import 'babel-polyfill'
import Vue from 'vue'
import App from './App'
import axios from 'axios'
import Lockr from 'lockr'
import Cookies from 'js-cookie'
import _ from 'lodash'
import moment from 'moment'
import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
import routes from './routes'
import VueRouter from 'vue-router'
import store from './vuex/store'
import filter from './assets/js/filter'
import _g from './assets/js/global'
import NProgress from 'nprogress'
import 'nprogress/nprogress.css'
import 'assets/css/global.css'
import 'assets/css/base.css'
import 'assets/css/font-awesome.min.css'
// axios.defaults.baseURL = HOST
// axios.defaults.baseURL = 'http://api.local.com'
// axios.defaults.baseURL = 'http://192.168.1.106:9002'
// axios.defaults.baseURL = 'http://192.168.3.19:8900/'
// http://wdj.coolwx.com.cn/
axios.defaults.baseURL = 'http://wdj.coolwx.com.cn'
axios.defaults.timeout = 1000 * 15
axios.defaults.headers.authKey = Lockr.get('authKey')
axios.defaults.headers.sessionId = Lockr.get('sessionId')
axios.defaults.headers['Content-Type'] = 'application/json'

const router = new VueRouter({
  // mode: 'history',
  mode: 'hash',
  base: __dirname,
  routes
})

router.beforeEach((to, from, next) => {
  const hideLeft = to.meta.hideLeft
  const hideCenter = to.meta.hideCenter
  store.dispatch('showLeftMenu', hideLeft)
  store.dispatch('showCenterMenu', hideCenter)
  store.dispatch('showLoading', true)
  NProgress.start()
  next()
})

router.afterEach(transition => {
  NProgress.done()
})

Vue.use(ElementUI)
Vue.use(VueRouter)

window.router = router
window.store = store
window.HOST = HOST
window.axios = axios
window._ = _
window.moment = moment
window.Lockr = Lockr
window.Cookies = Cookies
window._g = _g
window.pageSize = 15

const bus = new Vue()
window.bus = bus

new Vue({
  el: '#app',
  template: '<App/>',
  filters: filter,
  router,
  store,
  components: { App }
// render: h => h(Login)
}).$mount('#app')
