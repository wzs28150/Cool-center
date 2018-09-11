<template>
	<div class="main">
    <el-scrollbar wrap-class="list"  view-style="font-weight: bold;" view-class="view-box" :native="false">
		<transition name="fade" mode="out-in" appear>
				<router-view v-loading="showLoading" ></router-view>
		</transition>
    </el-scrollbar>
  </div>

</template>
<style lang="scss" scoped>
	.fade-enter-active,
	.fade-leave-active {
		transition: opacity .5s
	}
	body,html{ height: 100%; overflow: hidden; }
	.main{ height: 100%!important; background-color: #f2f2f2; overflow: hidden;  padding-bottom: 0; }
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
  import http from '../assets/js/http'
  export default {
    data() {
      return {
      }
    },
    created() {

    },
    watch: {

    },
    mixins: [http]
  }
</script>
