<template>
  <div class="centerMenu" >
    <el-menu :default-active="menu" :unique-opened="unique" class="el-menu-vertical-demo" background-color="#f1f2f7" text-color="#333" active-text-color="#ffd04b" @open="handleOpen" @close="handleClose" :collapse="isCollapse" >
      <el-menu-item index="main" @click="routerChange({'id':0,'title':'系统首页','url':'/home/main','icon':'cogs','menu_type':1,'sort':1,'status':1,'rule_id':61,'module':'Main','menu':'main','selected':true,'level':1})">
         <i class="fa fa-tachometer"  ></i>
         <span slot="title">首页</span>
      </el-menu-item>
      <template v-for="(secMenu, index) in  menuData" >
        <el-submenu :index="'m' + index" v-if="secMenu.child" >
          <template slot="title"><i :class="['fa','fa-' + secMenu.icon]"  @click="routerChange(item)"></i> <span slot="title">{{secMenu.title}}</span>  </template>
          <template v-for="(item, ind) in secMenu.child" >
            <el-menu-item  :index="item.menu"  @click="routerChange(item)">{{item.title}}</el-menu-item>
          </template>
        </el-submenu>
        <el-menu-item :index="secMenu.menu" v-else @click="routerChange(secMenu)">
           <i :class="['fa','fa-' + secMenu.icon]"  ></i>
           <span slot="title">{{secMenu.title}}</span>
        </el-menu-item>
      </template>

      <template >
        <div class="Collapse" @click="changeCollapse">
          <div class="ico">
            <i class="el-icon-arrow-left" ></i>
          </div>
        </div>
      </template>
    </el-menu>
  </div>
</template>
<style>
  .centerMenu{ background-color: #f1f2f7; height: calc(100% - 20px); padding: 20px 0; }
  .l-logo{ overflow: hidden; color: #fff; font-size: 30px; line-height: 30px; font-weight: bold; text-align: center; padding: 20px 0;  font-family: "Helvetica Neue", Helvetica, "PingFang SC", 微软雅黑, Tahoma, Arial, sans-serif; position: fixed; left: 0; top:0; z-index: 999; width: 200px; background:rgb(50, 64, 87); transition: width .3s;}
  .nopadding{ padding: 0; }
  .l-logo img{ width: 50px; padding: 5px 7px;}
  .l-logo + .el-menu{ padding-top: 70px;}
  .shouMenu .l-logo{ width: 64px; transition: width .3s;}
  .el-menu{ border: none;}
  .Collapse{ color: #fff; text-align: center; position: relative; line-height: 0; font-size: 0; cursor: pointer; padding: 20px 0; }
  .Collapse i { font-size: 16px; background-color: #324057;position: relative; z-index: 1; border-radius: 100%;  box-shadow: 0 0 10px #909399; transform: rotate(0deg);  transition: transform .3s; padding: 5px;}
  .Collapse .ico{  }
  .Collapse::before{ position: absolute; width: 200%; height: 1px; background-color: #909399; content: ""; left: 50%; margin-left: -100%; top: 50%; transform: scale(0.5);}
  .centerMenu .el-menu-vertical-demo:not(.el-menu--collapse) {
    width: 100%;
    min-height: 400px;
  }
  .centerMenu .is-opened .el-menu-item{ background-color:  #f1f2f7!important; }
  .shouMenu .Collapse i { transform: rotate(180deg); transition: transform .3s;}
  .el-submenu__title{  }
  .centerMenu .is-opened .el-menu>li{ background-color: #f1f2f7!important; }
  .centerMenu .is-opened .el-submenu__title{ background-color: #fff!important; }
  .el-menu--popup-right-start {
    margin-left: 0px;
    margin-right: 0px;
 }
 .el-submenu [class^=fa],.el-menu-item [class^=fa] {
    margin-right: 5px;
    width: 24px;
    text-align: center;
    font-size: 18px;
    vertical-align: middle;
}
</style>
<script>
export default {
  props: ['menuData', 'menu'],
  data() {
    return {
      isCollapse: false,
      unique: true
    }
  },
  methods: {
    routerChange(item) {
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
    changeCollapse($flag) {
      this.isCollapse = !this.isCollapse
      this.$emit('iscenterMenu', this.isCollapse)
    },
    handleOpen(key, keyPath) {
      // console.log(2)
      // console.log(key, keyPath)
    },
    handleClose(key, keyPath) {
      // console.log(key, keyPath)
    }
  },
  created() {
    // console.log(this.menuData)
  }
}
</script>
