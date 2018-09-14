<template>
	<div class="navbar">
		<el-menu :default-active="menu" :unique-opened="unique" class="el-menu-vertical-demo" background-color="#fff" text-color="#000" active-text-color="#409eff" mode="horizontal" @open="handleOpen" @close="handleClose" :collapse="isCollapse" >
			<template v-for="(secMenu, index) in  menuData" >
        <el-menu-item :index="secMenu.name" @click="routerChange(secMenu)" >
          <div class="inner">
            <i :class="secMenu.icon"></i><span slot="title">{{secMenu.title}}</span>
          </div>
        </el-menu-item>
			</template>
	  </el-menu>
	</div>
</template>
<style lang="scss">
  .navbar{ box-shadow: 0 0 2px #ccc;
    .el-menu-item{
      width: 50%; text-align: center; background-color: #fff!important;
      height: 56px;
      line-height: 56px;
      i{
        // display: block; margin: 0 auto;
        margin-right: 5px;
        width: 24px;
        text-align: center;
        font-size: 18px;
        vertical-align: middle;
      }
    }
    .el-menu-item [class^=el-icon-]{
      // margin: 0 auto;
    }
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
    routerChange(item) 	{
      // console.log(item)
      // // 与当前页面路由相等则刷新页面
      // console.log(item.url + '/' + this.$route.path)
      // router.push(item.url)
      if (item.url != this.$route.path) {
        router.push(item.url)
      } else {
        _g.shallowRefresh(this.$route.name)
      }
    },
    changeCollapse() {
      this.isCollapse = !this.isCollapse
      this.$emit('isCollapse', this.isCollapse)
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
