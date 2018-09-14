<template>
	<div class="main">
		<transition name="fade" mode="out-in" appear>
				<router-view v-loading="showLoading" ref="home" ></router-view>
		</transition>
		<div class="nav-bar">
			<leftMenu v-on:isCollapse="isCollapse" :menuData="menuData" :menu="menu"></leftMenu>
		</div>
  </div>
</template>
<style lang="scss" scoped>
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity .5s
	}
	body,html{ height: 100%; overflow: hidden; }
	.main{ height: calc(100% - 57px); background-color: #f2f2f2; padding-bottom: 57px;}
	.nav-bar{ position: fixed; bottom: 0; left: 0; width: 100%; z-index: 10; }
  .el-scrollbar {
	  height: 100%; width: 100%;
	}
	.el-scrollbar__wrap{
	 overflow-y: scroll;overflow-x: hidden;
	}
  .el-scrollbar__view.view-box{ min-height: 100%; }
	.is-horizontal{ display: none; }
</style>
<script>
  import leftMenu from './Common/leftMenu.vue'
  import changePwd from './Account/changePwd.vue'
  import http from '../assets/js/http'

  export default {
    data() {
      return {
        username: '',
        topMenu: [],
        childMenu: [],
        menuData: [],
        hasChildMenu: false,
        menu: null,
        module: null,
        img: '',
        title: '',
        logo_type: null,
        Collapse: false,
        menu_title: null,
        isPageDown: false
      }
    },
    methods: {
      logout() {
        this.$confirm('确认退出吗?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消'
        }).then(() => {
          _g.openGlobalLoading()
          let data = {
            authkey: Lockr.get('authKey'),
            sessionId: Lockr.get('sessionId')
          }
          this.apiPost('admin/base/logout', data).then((res) => {
            _g.closeGlobalLoading()
            this.handelResponse(res, (data) => {
              Lockr.rm('menus')
              Lockr.rm('authKey')
              Lockr.rm('rememberKey')
              Lockr.rm('authList')
              Lockr.rm('userInfo')
              Lockr.rm('sessionId')
              Cookies.remove('rememberPwd')
              _g.toastMsg('success', '退出成功')
              setTimeout(() => {
                router.replace('/')
              }, 1500)
            })
          })
        }).catch(() => {

        })
      },
      switchTopMenu(item) {
        if (!item.child) {
          router.push(item.url)
        } else {
          router.push(item.child[0].url)
        }
      },
      handleMenu(val) {
        switch (val) {
          case 'logout':
            this.logout()
            break
          case 'changePwd':
            this.changePwd()
            break
        }
      },
      changePwd() {
        this.$refs.changePwd.open()
      },
      getTitleAndLogo() {
        this.apiPost('admin/base/getConfigs').then((res) => {
          this.handelResponse(res, (data) => {
            // document.title = data.SYSTEM_NAME
            document.title = '微点击'
            this.logo_type = data.LOGO_TYPE
            this.title = data.SYSTEM_NAME
            this.img = window.HOST + data.SYSTEM_LOGO
          })
        })
      },
      getUsername() {
        this.username = Lockr.get('userInfo').username
      },
      isCollapse(Collapse) {
        this.Collapse = Collapse
      }
    },
    created() {
      this.getTitleAndLogo()
      let sessionId = Lockr.get('sessionId')
      if (!sessionId) {
        _g.toastMsg('warning', '您尚未登录')
        setTimeout(() => {
          router.replace('/')
        }, 1500)
        return
      }
      this.getUsername()
      this.menuData = [{ title: '文章', name: 'main', url: '/main', icon: 'el-icon-document' }, { title: '我的', name: 'me', url: '/me', icon: 'fa fa-user-circle-o' }]
      // let menus = Lockr.get('menus')
      // // console.log(this.$route.meta.title)
      this.menu = this.$route.meta.menu
      // this.menu_title = this.$route.meta.title
      // this.module = this.$route.meta.module
      // this.topMenu = menus
      // // console.log(menus)
      // this.menuData = menus
      // _(menus).forEach((res, index) => {
      //   // console.log(this.module + '/' + res.module)
      //   // console.log(res)
      //   if (res.module == this.module) {
      //     res.selected = true
      //   } else {
      //     res.selected = false
      //   }
      // })
      setTimeout(() => {
        this.$nextTick(() => {

        })
      }, 1500)
    },
    computed: {
      routerShow() {
        return store.state.routerShow
      },
      showLeftMenu() {
        this.hasChildMenu = store.state.showLeftMenu
        return store.state.showLeftMenu
      }
    },
    components: {
      leftMenu,
      changePwd
    },
    watch: {
      '$route' (to, from) {
        this.menu = to.meta.menu

        if (to.name === 'refresh') {
          document.title = '刷新中...'
        } else {
          document.title = to.meta.title
          this.menu_title = to.meta.title
        }
      }
    },
    mixins: [http]
  }
</script>
