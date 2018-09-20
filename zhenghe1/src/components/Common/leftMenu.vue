<template>
  <div class="" v-on:mouseenter="changeCollapse(false)" v-on:mouseleave="changeCollapse(true)">
    <template>
      <div class="l-logo" v-if="!isCollapse">
        COOLVUE
      </div>
      <div class="l-logo nopadding" v-else>
        <img src="../../assets/images/logo.png" width="" alt="">
      </div>
    </template>
    <el-menu :default-active="menu" :unique-opened="unique" class="el-menu-vertical-demo" background-color="#324057" text-color="#fff" active-text-color="#ffd04b" @open="handleOpen" @close="handleClose" :collapse="isCollapse" >
      <el-menu-item index="main" @click="routerChange({'id':0,'title':'系统首页','url':'/home/main','icon':'cogs','menu_type':1,'sort':1,'status':1,'rule_id':61,'module':'Main','menu':'main','selected':true,'level':1})">
         <i class="fa fa-tachometer"  ></i>
         <span slot="title">系统首页</span>
      </el-menu-item>
      <div v-for="(secMenu, index) in  menuData" :key="secMenu.id">
        <el-submenu :index="'m' + index" v-if="secMenu.child" >
          <template slot="title"><i :class="['fa','fa-' + secMenu.icon]" ></i> <span slot="title">{{secMenu.title}}</span> </template>
          <div v-for="item in secMenu.child" :key="item.id" >
            <el-menu-item  :index="item.menu"  @click="routerChange(item)">{{item.title}}</el-menu-item>
          </div>
        </el-submenu>
        <el-menu-item :index="secMenu.menu" v-else @click="routerChange(secMenu)">
           <i :class="['fa','fa-' + secMenu.icon]"  ></i>
           <span slot="title">{{secMenu.title}}</span>
        </el-menu-item>
      </div>
      <template >
        <div class="Collapse" @click="changeCollapse(!isCollapse)">
          <div class="ico">
            <i class="el-icon-arrow-left" ></i>
          </div>
        </div>
      </template>
    </el-menu>
  </div>
</template>
<style lang="scss">
  @import '../../assets/css/leftMenu.scss';
</style>
<script>
export default {
  props: ['menuData', 'menu'],
  data () {
    return {
      isCollapse: true,
      unique: true
    }
  },
  methods: {
    routerChange (item) {
      // 与当前页面路由相等则刷新页面
      // console.log(item.url + "/" + this.$route.path)
      // router.push(item.url)
      // console.log(item)
      if (item.url != this.$route.path) {
        router.push(item.url)
      } else {
        _g.shallowRefresh(this.$route.name)
      }
    },
    changeCollapse ($flag) {
      this.isCollapse = $flag
      this.$emit('isCollapse', this.isCollapse)
    },
    handleOpen (key, keyPath) {
      // console.log(2)
      // console.log(key, keyPath)
    },
    handleClose (key, keyPath) {
      // console.log(key, keyPath)
    }
  },
  created () {
    // console.log(this.menuData)
  }
}
</script>
