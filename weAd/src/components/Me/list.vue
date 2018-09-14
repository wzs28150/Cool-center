<template>
  <div ref="mescroll" class="mescroll articleList">
  <div>
    <div class="item" v-for="(item, index)  in list"  :key="item.key">
      <!-- <img :src="item.image" alt=""> -->
      <div class="item-inner" @click="itemClick($event, index)">
        <el-badge :value="item.share_num" class="badge">
          <div class="img" :style="{ 'background-image': 'url(' + item.share_pic+ ')' }"></div>
        </el-badge>
        <!-- <div class="author">
          {{item.author}}
        </div> -->
        <div class="icon">
          <i class="el-icon-arrow-right"></i>
        </div>
        <div class="inner">
          <div class="title" solt="title">
            {{item.title}}{{item.id}}
          </div>
          <div class="info">
            {{item.share_desc}}
          </div>
        </div>
      </div>
      <div :class="['btn', { active: item.btnShow }]" @click="itemClick($event, index)">
        <el-button type="primary"  icon="fa fa-link" @click="info(item.id)" circle></el-button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <el-button type="primary"  icon="el-icon-edit-outline" @click="edit(item.id)" circle></el-button>
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <el-button type="primary"  icon="el-icon-delete" @click="del(item.id)" circle></el-button>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
import http from '../../assets/js/http'
import MeScroll from 'mescroll.js'
import 'mescroll.js/mescroll.min.css'
export default {
  data() {
    return {
      list: []
    }
  },
  methods: {
    init() {
      this.apiGet('api/me/' + Lockr.get('userInfo').id).then((res) => {
        this.handelResponse(res, (data) => {
          this.list = res.data
          _g.closeGlobalLoading()
        })
      })
    },
    itemClick(event, $key) {
      this.list[$key]['btnShow'] = !this.list[$key]['btnShow']
      this.list.forEach(function(value, index, array) {
        if (index !== $key) {
          value['btnShow'] = false
        }
      })
    },
    edit($id) {
      let $url = '/article/add/' + $id
      router.push({ path: $url })
    },
    info($id) {
      let $url = '/article/infon/' + $id
      router.push({ path: $url })
    },
    del($id) {
      this.$confirm('确认删除吗?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消'
      }).then(() => {
        _g.openGlobalLoading()
        let data = {
          id: $id
        }
        this.apiPost('api/me/delete', data).then((res) => {
          _g.closeGlobalLoading()
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', '删除成功')
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1500)
          })
        })
      }).catch(() => {

      })
    },
    /* 下拉刷新的回调 */
    downCallback () {
      // 联网加载数据
      this.getListDataFromNet(1, 1, (data) => {
        // 添加新数据到列表顶部
        this.list = data
        // 数据渲染成功后,隐藏下拉刷新的状态
        this.$nextTick(() => {
          this.mescroll.endSuccess()// 结束下拉刷新,无参
        })
      }, () => {
        // 联网失败的回调,隐藏下拉刷新的状态
        this.mescroll.endErr()
      })
    },
    // 上拉回调 page = {num:1, size:10}; num:当前页 ,默认从1开始; size:每页数据条数,默认10
    upCallback (page) {
      // 联网加载数据
      this.getListDataFromNet(page.num, page.size, (curPageData) => {
        // 添加列表数据
        this.list = this.list.concat(curPageData)
        // 数据渲染成功后,隐藏下拉刷新的状态
        this.$nextTick(() => {
          this.mescroll.endSuccess(curPageData.length)
        })
      }, () => {
        // 联网失败的回调,隐藏下拉刷新和上拉加载的状态;
        this.mescroll.endErr()
      })
    },
    getListDataFromNet (pageNum, pageSize, successCallback, errorCallback) {
      // 延时一秒,模拟联网
      const data = {
        params: {
          page: pageNum,
          pageSize: pageSize,
          id: this.id
        }
      }
      this.apiGet('api/me/' + Lockr.get('userInfo').id, data).then((res) => {
        this.handelResponse(res, (data) => {
          successCallback && successCallback(res.data)
          setTimeout(() => {
            _g.closeGlobalLoading()
          }, 1500)
        })
      })
    }
  },
  created() {
    _g.closeGlobalLoading()
    // this.init()
    document.title = '我发布的'
  },
  mounted () {
    // 创建MeScroll对象:为避免配置的id和父组件id重复,这里使用ref的方式初始化mescroll
    this.mescroll = new MeScroll(this.$refs.mescroll, {// 在mounted生命周期初始化mescroll,以确保您配置的dom元素能够被找到.
      down: {
        auto: false, // 是否在初始化完毕之后自动执行下拉回调callback; 默认true
        callback: this.downCallback, // 下拉刷新的回调
        page: {
          num: 0, // 当前页码,默认0,回调之前会加1,即callback(page)会从1开始
          size: 20 // 每页数据的数量
        }
      },
      up: {
        auto: true, // 是否在初始化时以上拉加载的方式自动加载第一页数据; 默认false
        callback: this.upCallback, // 上拉回调,此处可简写; 相当于 callback: function (page) { upCallback(page); }
        page: {
          num: 0, // 当前页码,默认0,回调之前会加1,即callback(page)会从1开始
          size: 20 // 每页数据的数量
        },
        isBounce: true,
        noMoreSize: 5,
        htmlNodata: '<p class="upwarp-nodata">-- 没有更多啦 --</p>'
      }
    })
  },
  mixins: [http]
}
</script>
<style lang="scss" scoped>
  .articleList{
    .item{ background-color: #fff; overflow: hidden; margin-bottom: 1px; position: relative;
      .item-inner{ margin: 15px; position: relative; min-height: 70px;  }
      .img{ width: 70px; height: 70px; background-position: center; background-color: #eee; background-size: cover; }
      // .author{ width: 70px; height: 1em; position: absolute; left: 0; bottom:0;}
      .icon{  position: absolute; right: 0; top:0; height: 70px; line-height: 70px; color: #409eff; animation: swing 1s .15s ease-in-out infinite; }

      .inner{ padding-left: 80px; margin-right: 1em;
        .title{
          color: #000; overflow: hidden; white-space: nowrap; text-overflow: ellipsis; font-size: 16px; line-height: 1.2em; margin-bottom: 10px;
        }
        .info{
          height: 3em; line-height: 1.5em; width: 100%; color: #999; font-size:14px;
          overflow: hidden; text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; flex-direction: column; font-weight: 600;
        }

      }
      .btn{ position: absolute; top:0; width: 100%; height: 40px; padding: 30px 0;   z-index: 1; background-color: rgba(0,0,0,0.5); text-align: center; visibility: hidden; opacity: 0; transition: all .4s;
        &.active{
          visibility: visible; opacity: 1; transition: all .4s;
        }
      }
      .badge{ width: 70px; height: 70px; position: absolute; left: 0; top: 0; }
      // &:hover{
      //   .btn{
      //     visibility: visible; opacity: 1; transition: all .4s;
      //   }
      // }
    }
  }
  @keyframes swing {
    0 {
      transform: translateX(5px);
    }
    50% {
      transform: translateX(0px);
    }
    100% {
      transform: translateX(-5px);
    }
  }
</style>
