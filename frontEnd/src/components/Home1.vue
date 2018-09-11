<template>
	<el-row class="panel m-w-1280">
		<el-col :span="24" class="panel-center">
			<aside :class="['w-200', 'ovf-hd',{'shouMenu': Collapse}] " v-show="!showLeftMenu">
				<el-scrollbar wrap-class="list" wrap-style="color: red;" view-style="font-weight: bold;" view-class="view-box" :native="false">
					<leftMenu v-on:isCollapse="isCollapse" :menuData="menuData" :menu="menu" ref="leftMenu"></leftMenu>
				</el-scrollbar>
			</aside>
			<section class="panel-c-c" :class="{'hide-leftMenu': hasChildMenu, 'shouMenu': Collapse}">
				<el-col :span="24" class="panel-top">
					<el-col :span="16" class="ofv-hd">
						<div class="fl p-l-20 p-r-20 top-menu2"   @click="switchTopMenu(menu)">
							<i class="fa fa-refresh"></i>
						</div>
					</el-col>
					<el-col :span="4" class="pos-rel pos-relr">
						<el-dropdown @command="handleMenu" trigger="click" class="user-menu">
				      <span class="el-dropdown-link" >
				        {{username}}&nbsp;&nbsp;<i class="fa fa-user" aria-hidden="true"></i>
				      </span>
				      <el-dropdown-menu slot="dropdown">
				        <el-dropdown-item command="changePwd">修改密码</el-dropdown-item>
				        <el-dropdown-item command="logout">退出</el-dropdown-item>
				      </el-dropdown-menu>
				    </el-dropdown>
					</el-col>
				</el-col>

				<div class="grid-content bg-purple-light">
					<el-card class="box-card">
						<div slot="header" class="clearfix">
							<span>{{menu_title}}</span>
							<!-- <el-button style="float: right; padding: 3px 0" type="text">操作按钮</el-button> -->
						</div>
						<el-scrollbar wrap-class="list" wrap-style="color: red;" view-style="font-weight: bold;" view-class="view-box" :native="false">
						<el-col :span="24">
							<transition name="fade" mode="out-in" appear>
								<router-view v-loading="showLoading" ></router-view>
							</transition>
						</el-col>
						</el-scrollbar>
					</el-card>
				</div>
			</section>
		</el-col>
		<changePwd ref="changePwd"></changePwd>
	</el-row>
</template>
<style>
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity .5s
	}
	.top-menu2{ cursor: pointer; transform: rotate(0deg); transition: transform .3s}
	.top-menu2:hover i{ transform: rotate(360deg); transition: transform .3s}
	.fade-enter,
	.fade-leave-active {
		opacity: 0
	}

	.panel {
		position: absolute;
		top: 0px;
		bottom: 0px;
		width: 100%;
	}
	aside{ height: 100%; }
	.ovf-hd{
		transition: width .3s;
	}
	.ovf-hd.shouMenu {
		width: 64px !important;
	}

	.panel-top {
		height: 60px;
		line-height: 60px;
		background: #fff;
		color: #333;
		position: absolute;
		top: 0;
		left: 0;
		z-index: 99; box-shadow: 0 0 5px #ccc;
	}
	.pos-relr{ float: right; }
	.panel-center {
		background: #324057;
		position: absolute;
		top: 0px;
		bottom: 0px;
		overflow: hidden;
	}

	.panel-c-c {
		background: #f1f2f7;
		position: absolute;
		right: 0px;
		top: 0px;
		bottom: 0px;
		left: 200px;
		overflow-y: hidden;
		padding: 60px 0 20px;
		transition: left .3s;overflow: hidden;
	}
	.user-menu{ right: 20px!important; cursor: pointer; }
	.panel-c-c.shouMenu{
		left: 64px;
	}
	.el-dropdown-link:focus {
    outline: none;
   }
	.logout {
		background: url(../assets/images/logout_36.png);
		background-size: contain;
		width: 20px;
		height: 20px;
		float: left;
	}

	.logo {
		width: 150px;
		float: left;
		margin: 10px 10px 10px 18px;
	}

	.tip-logout {
		float: right;
		margin-right: 20px;
		padding-top: 5px;
		cursor: pointer;
	}

	.admin {
		color: #c0ccda;
		text-align: center;
	}
	.hide-leftMenu {
		left: 0px;
	}
	.grid-content{ height: calc(100% - 20px); padding: 20px 20px 0;}
	.el-scrollbar {
	  height: 100%; width: 100%;
	}
	.el-scrollbar__wrap{
	 overflow-y: scroll;overflow-x: hidden;
	}
	.is-horizontal{ display: none; }
	.el-card{ height: 100%; }
	.el-card__body{ height: calc(100% - 55px - 40px); overflow: hidden; }
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
        menu_title: null
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
            document.title = data.SYSTEM_NAME
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
      let authKey = Lockr.get('authKey')
      let sessionId = Lockr.get('sessionId')
      if (!authKey || !sessionId) {
        _g.toastMsg('warning', '您尚未登录')
        setTimeout(() => {
          router.replace('/')
        }, 1500)
        return
      }
      this.getUsername()
      let menus = Lockr.get('menus')
      // console.log(this.$route.meta.title)
      this.menu = this.$route.meta.menu
      this.menu_title = this.$route.meta.title
      this.module = this.$route.meta.module
      this.topMenu = menus
      // console.log(menus)
      this.menuData = menus
      _(menus).forEach((res, index) => {
        // console.log(this.module + '/' + res.module)
        // console.log(res)
        if (res.module == this.module) {
          res.selected = true
        } else {
          res.selected = false
        }
      })
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
        this.menuData = this.topMenu
        this.menu = to.meta.menu
        this.menu_title = to.meta.title
      }
    },
    mixins: [http]
  }
</script>
