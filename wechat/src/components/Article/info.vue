<template>
  <div class="articleinfo">
    <div class="title">
      {{info.title}}
    </div>
    <div id="meta_content" class="rich_media_meta_list">
      <span class="rich_media_meta rich_media_meta_nickname" id="profileBt"><a href="javascript:void(0);" id="js_name">{{info.gongzhonghao}}</a></span>
      <em id="publish_time" class="rich_media_meta rich_media_meta_text">{{addtime}}</em>
    </div>
    <div class="content" v-html="info.content" :style="'padding-bottom:'+ swiperHeight +'px;'">

    </div>
    <swiper :options="swiperOption" ref="mySwiper">
      <swiper-slide v-for="item in img" :key="item">
        <a :href="adlink" target="_blank">
          <img :src="item"  alt="">
        </a>
      </swiper-slide>
    </swiper>
    <div class="swiper-pagination"  slot="pagination"></div>
    <!-- 全屏广告开始 -->
    <div class="ad-bg" v-show="dialogFormVisible">
      <transition name="fade" mode="out-in" appear>
        <a :href="info.adlink">
          <img :src="quanping" alt="" v-show="dialogFormVisible">
        </a>
      </transition>
      <a class="closead" @click="closead" ><i class="el-icon-close"></i></a>
    </div>
    <!-- 全屏广告结束 -->
    <!-- 菜单开始 -->
    <div :class="['menu-btn', {'active': isactive}]" :style="'bottom:'+ (swiperHeight + 20) +'px;'">
       <a v-for="(item, index) in menu" :key="item.key" :class="'btn' + (index + 1)" :href="item.url"><i :class="item.icon"></i></a>
       <a @click="showMenu"><i :class="isactive ? 'fa fa-close' : 'fa fa-navicon' "></i></a>
    </div>
    <!-- 菜单结束 -->
    <div class="backhome" v-show="showback" :style="'bottom:'+ (swiperHeight + 20) +'px;'">
      <a @click="backtohome"><i class="fa fa-reply"></i></a>
    </div>
  </div>
</template>
<script>
import http from '../../assets/js/http'
import 'swiper/dist/css/swiper.css'
import { swiper, swiperSlide } from 'vue-awesome-swiper'
import wx from 'weixin-js-sdk'
export default {
  data: () => ({
    id: null,
    info: {
      title: '',
      gongzhonghao: '',
      addtime: '',
      content: '',
      adlink: '',
      telnum: '',
      gzurl: '',
      home_url: '',
      img: [],
      share_desc: ''
    },
    menu: [],
    dialogFormVisible: false,
    swiperOption: {
      speed: 1000,
      autoplay: {
        delay: 3000
      },
      loop: true
    },
    swiperHeight: 107,
    isactive: false,
    showback: false,
    url: ''
  }),
  mounted() {
    if (Lockr.get('swiperHeight')) {
      setTimeout(() => {
        this.swiperHeight = Lockr.get('swiperHeight')
      }, 1000)
    }
  },
  beforeCreate() {
    this.$nextTick(function () {
      this.id = this.$route.params.id
      this.init()
    })
  },
  methods: {
    showMenu() {
      this.isactive = !this.isactive
    },
    backtohome() {
      router.replace('/main')
    },
    closead() {
      this.dialogFormVisible = false
    },
    init() {
      this.apiGet('api/articleread/' + this.id).then((res) => {
        this.info.title = res.data.title
        this.info.content = res.data.content
        this.info.gongzhonghao = res.data.gongzhonghao
        this.info.adlink = res.data.adlink
        this.info.is_quanping = res.data.is_quanping
        this.info.telnum = res.data.telnum
        this.info.gzurl = res.data.gzurl
        this.info.home_url = res.data.home_url
        this.share_desc = res.data.share_desc
        let userInfo = Lockr.get('userInfo')
        if (userInfo) {
          if (Number(res.data.userid) === userInfo.id) {
            this.showback = true
          }
        }
        if (this.info.home_url) {
          this.menu.push({ 'icon': 'fa fa-home', 'url': this.info.home_url })
        }
        if (this.info.telnum) {
          this.menu.push({ 'icon': 'fa fa-phone', 'url': 'tel:' + this.info.telnum })
        }
        if (this.info.gzurl) {
          this.menu.push({ 'icon': 'fa fa-weixin', 'url': 'tel:' + this.info.gzurl })
        }
        if (this.info.is_quanping === 1) {
          this.dialogFormVisible = true
        }
        // setTimeout(() => {
        //   this.dialogFormVisible = false
        // }, 3000)
        // console.log(this.info)
        this.quanping = axios.defaults.baseURL + '/' + res.data.quanping
        this.img = [axios.defaults.baseURL + '/' + res.data.adpic, axios.defaults.baseURL + '/' + res.data.adpic_one, axios.defaults.baseURL + '/' + res.data.adpic_two]
        this.addtime = _g.dealArticleTime(Date.parse(_g.convertDateFromString(res.data.addtime)) / 1000)
        // console.log(this.addtime)
        var oImg = new Image()
        oImg.src = axios.defaults.baseURL + '/' + res.data.adpic
        let swiperHeight = parseInt(document.documentElement.clientWidth * oImg.naturalHeight / oImg.naturalWidth)
        Lockr.set('swiperHeight', swiperHeight)
        _g.closeGlobalLoading()
        if (this.swiperHeight > 0) {
          this.swiperHeight = swiperHeight
        }
      })
    }
  },
  created() {
    // this.id = this.$route.params.id
    // this.init()
    this.url = encodeURIComponent(location.href.split('#')[0])
    this.apiGet('/api/jsdk?url=' + this.url).then((res) => {
    // axios.get('http://daikou.coolwx.com.cn/jssdk.php?url=' + this.url).then((response) => {
    //   console.log(response)
    // })
    // this.apiGet('http://daikou.coolwx.com.cn/jssdk.php?url=' + this.url).then((res) => {
      // console.log(res.data)
      wx.config({
        debug: false,
        appId: res.data.appId,
        timestamp: res.data.timestamp,
        nonceStr: res.data.nonceStr,
        signature: res.data.signature,
        jsApiList: [
          'onMenuShareTimeline',
          'onMenuShareAppMessage',
          'onMenuShareQQ',
          'onMenuShareWeibo'
        ]
      })
      // console.log(wx.config)
      wx.ready(function() {
        var shareData = {
          title: '平安好贷-安金服',
          desc: '平安好贷-安金服',
          link: this.url,
          imgUrl: ''
        }
        wx.onMenuShareAppMessage(shareData)
        wx.onMenuShareTimeline(shareData)
        wx.onMenuShareQQ(shareData)
        wx.onMenuShareWeibo(shareData)
      })
    })
  },
  components: {
    swiper,
    swiperSlide
  },
  mixins: [http]
}
</script>
<style lang="scss" scoped>
  .fade-enter-active,
  .fade-leave-active {
    transition: opacity .5s
  }
  .articleinfo{ background-color: #fff; min-height: 100%;  padding: 20px 16px 12px; width: calc(100% - 32px);
    .title{ font-size: 22px; line-height: 1.4; margin-bottom: 14px; color: #333; }
    .rich_media_meta_list{ margin-bottom: 22px; line-height: 20px;
      em { font-style: normal; font-style: normal; }
      a{ color: #576b95; }
      .rich_media_meta { display: inline-block; vertical-align: middle; margin: 0 10px 10px 0; font-size: 15px; -webkit-tap-highlight-color: rgba(0,0,0,0); }
      .rich_media_meta_text { color: rgba(0,0,0,0.3); }
    }
    .content { overflow: hidden; color: #333; font-size: 17px; word-wrap: break-word; -webkit-hyphens: auto; -ms-hyphens: auto; hyphens: auto; text-align: justify;
      p { clear: both; min-height: 1em; padding: 0; margin: 0; }
      img{ height: auto!important; max-width: 100%!important; width: auto; margin: 0 auto; display: block; }
    }
  }
  .swiper-container{ position: fixed; bottom: 0; width: 100%; left: 0; z-index: 9; background-color: #fff;
    img{ width: 100%; display: block; }
  }
  .ad-bg{ position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); z-index: 10;
    img{ max-width: 80%; max-height: 80%; margin: 0 auto; position: absolute; top:50%; transform: translateY(-50%) translateX(-50%); left: 50%;}
    .closead{ position: fixed; right: 5px; color: #fff; top: 5px;  z-index: 10;  border: 1px solid #fff; border-radius: 100%; padding: 5px;
      i{display: block;}
    }
  }
  .menu-btn{ position: fixed; z-index: 5; left: 5px; width: 36px; height: 36px;
    a{ font-size: 0; display: block; width: 16px;height: 16px; color: #333; background-color: #409eff; color: #fff; text-align: center; padding: 10px; border-radius: 100%; margin-top: 5px; position: absolute; top: 0;
      i{ font-size: 16px;  }
    }
    .btn1,.btn2,.btn3{ transform: translateY(0); transition: all 0.4s;}
    &.active{
      .btn1{ transform: translateY(-41px); transition: all 0.4s;}
      .btn2{ transform: translateY(-82px); transition: all 0.4s;}
      .btn3{ transform: translateY(-123px); transition: all 0.4s;}
    }
  }
  .backhome{ position: fixed; z-index: 5; right: 5px; width: 36px; height: 36px;
    a{ font-size: 0; display: block; width: 16px;height: 16px; color: #333; background-color: #909399; color: #fff; text-align: center; padding: 10px; border-radius: 100%; margin-top: 5px; position: absolute; top: 0;
      i{ font-size: 16px; }
    }
  }
</style>
