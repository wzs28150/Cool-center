<template>
  <div class="teminner">
    <div class="nav">
      <swiper :options="swiperOption" ref="mySwiper">
        <swiper-slide v-for="item in category" :key="item.title">
          <a @click="navClick(item)" v-if="item.id == id" class="active" target="_blank">
            {{item.title}}
          </a>
          <a @click="navClick(item)" v-else  target="_blank">
            {{item.title}}
          </a>
        </swiper-slide>
      </swiper>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
    <div ref="mescroll" class="mescroll articleList">
    <div>
        <div v-for="(item, index)  in list" class="item"  :key="item.title" >
          <!-- <img :src="item.image" alt=""> -->
          <div class="item-inner" @click="itemClick($event, index)">
            <div class="img" :style="{ 'background-image': 'url(' + item.image+ ')' }"></div>
            <!-- <div class="author">
              {{item.author}}
            </div> -->
            <div class="icon">
              <i class="el-icon-arrow-right"></i>
            </div>
            <div class="inner">
              <div class="title" solt="title">
                {{item.title}}
              </div>
              <div class="info">
                {{item.info}}
              </div>
            </div>
          </div>
          <div :class="['btn', { active: item.btnShow }]" @click="itemClick($event, index)">
            <el-button type="primary"  icon="el-icon-more-outline" @click="info(item.href)" circle></el-button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <el-button type="primary"  icon="el-icon-share" @click="edit(item.href)" circle></el-button>
          </div>
        </div>
    </div>
    </div>
  </div>
</template>
<script>
import http from '../../assets/js/http'
import 'swiper/dist/css/swiper.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import MeScroll from 'mescroll.js'
import 'mescroll.js/mescroll.min.css'
export default {
  data() {
    return {
      refreshEnd: false,
      list: [],
      swiperOption: {
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        },
        speed: 1000,
        slidesPerView: 5,
        loop: false
      },
      mescroll: null,
      id: 'pc_0',
      currentPage: 1,
      category: [
        { id: 'pc_0', title: '热门' },
        { id: 'pc_1', title: '搞笑' },
        { id: 'pc_2', title: '养生' },
        { id: 'pc_3', title: '私房' },
        { id: 'pc_4', title: '八卦' },
        { id: 'pc_5', title: '科技' },
        { id: 'pc_6', title: '财经' },
        { id: 'pc_7', title: '汽车' },
        { id: 'pc_8', title: '生活' },
        { id: 'pc_9', title: '时尚' },
        { id: 'pc_10', title: '育儿' },
        { id: 'pc_11', title: '旅游' },
        { id: 'pc_12', title: '职场' },
        { id: 'pc_13', title: '美食' },
        { id: 'pc_14', title: '历史' },
        { id: 'pc_15', title: '教育' },
        { id: 'pc_16', title: '星座' },
        { id: 'pc_17', title: '体育' },
        { id: 'pc_18', title: '军事' },
        { id: 'pc_19', title: '游戏' },
        { id: 'pc_20', title: '萌宠' }
      ],
      width: '',
      itemAmount: 8,
      refresh: 1,
      topshow: false,
      toplineheight: 30
    }
  },
  computed: {},
  methods: {
    // async
    getArticleList() {
      const data = {
        params: {
          page: this.currentPage,
          id: this.id
        }
      }
      this.apiGet('api/article/', data).then((res) => {
        this.handelResponse(res, (data) => {
          this.list = res.data
          setTimeout(() => {
            _g.closeGlobalLoading()
          }, 1500)
        })
      })
    },
    navClick(item) {
      _g.openGlobalLoading()
      router.push({ path: this.$route.path, query: { id: item.id }})
    },
    itemClick(event, $key) {
      this.list[$key]['btnShow'] = !this.list[$key]['btnShow']
      this.list.forEach(function(value, index, array) {
        if (index !== $key) {
          value['btnShow'] = false
        }
      })
    },
    edit($href) {
      let $url = '/article/edit'
      router.push({ path: $url, query: { url: $href }})
    },
    info($href) {
      let $url = '/articlen/info'
      router.push({ path: $url, query: { url: $href }})
    },
    getanums() {
      let data = this.$route.query
      if (data) {
        if (data.page) {
          this.currentPage = parseInt(data.page)
        } else {
          this.currentPage = 1
        }
      }
    },
    getId() {
      let data = this.$route.query
      if (data) {
        if (data.id) {
          this.id = data.id
        } else {
          this.id = 'pc_0'
        }
      }
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
      this.apiGet('api/article/', data).then((res) => {
        this.handelResponse(res, (data) => {
          successCallback && successCallback(res.data)
          setTimeout(() => {
            _g.closeGlobalLoading()
          }, 1500)
        })
      })
    },
    init() {
      this.getId()
      // this.getCurrentPage()
      // this.getArticleList()
    }
  },
  created() {
    this.init()
  },
  components: {
    swiper,
    swiperSlide
  },
  watch: {
    '$route' (to, from) {
      this.init()
      this.mescroll.triggerDownScroll()
      this.mescroll.scrollTo(0, 0)
    }
  },
  mounted () {
    this.mescroll = new MeScroll(this.$refs.mescroll, {
      down: {
        auto: false,
        callback: this.downCallback,
        page: {
          num: 0,
          size: 20
        }
      },
      up: {
        auto: true,
        callback: this.upCallback,
        page: {
          num: 0,
          size: 20
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
<style >
  body{ overflow: hidden; }
  .__vuescroll .__view{ width: 100%!important; }
</style>
<style lang="scss" scoped>
  $fontsize:16px;
  .teminner{ height: 100%; }
  .nav{ box-shadow: 0 0 2px #ccc; height: 3 * $fontsize; position: fixed; width: 100%; left: 0; top: 0; z-index: 1; background-color: #fff; z-index: 2;
    .swiper-container{ background-color: #fff; position: fixed; width: calc(100% - 30px); margin: 0 15px; z-index: 2;
      .swiper-slide{ text-align: center;
        a{ color: #333; line-height: 3em; font-size: $fontsize; font-weight: normal; display: block;
          &.active{ background-color: #409eff; color: #fff; }
        }
      }
    }
  }

  .swiper-button-prev, .swiper-button-next{ top: 0; height: 3 * $fontsize; margin: 0; width: 9px; background-size: 0.6em auto; padding: 0 3px; background-color: #fff; z-index: 2;
    &:focus { outline: none; }
  }
  // .swiper-button-prev.swiper-button-disabled, .swiper-button-next.swiper-button-disabled{ opacity: 1; color: #ccc; }
  .swiper-button-prev{ left: 0; }
  .swiper-button-next{ right: 0; }
  .articleList{ padding-top: 3 * $fontsize; height: calc(100% - 48px);
    .swiper-container { height: 100%; }
    .item{ background-color: #fff; overflow: hidden; margin-bottom: 1px; position: relative; height: 100px;
      .item-inner{ margin: 15px; position: relative; min-height: 70px;  }
      .img{ width: 70px; height: 70px; background-position: center; background-color: #eee; background-size: cover; position: absolute; left: 0; top: 0; }
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
      .btn{ position: absolute; top:0; width: 100%; height: 100px; line-height: 100px;  z-index: 1; background-color: rgba(0,0,0,0.5); text-align: center; visibility: hidden; opacity: 0; transition: all .4s;
        &.active{
          visibility: visible; opacity: 1; transition: all .4s;
        }
      }
      // &:hover{
      //   .btn{
      //     visibility: visible; opacity: 1; transition: all .4s;
      //   }
      // }
    }
  }
  .toprefresh{ position: fixed; width: 100%; z-index: 1; text-align: center;  top: 3 * $fontsize; line-height: 2em; font-size: 14px; }
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
