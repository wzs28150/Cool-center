<template>
  <div id="">
    <el-row  :gutter="20">
      <el-col :lg="6" :xl="4" v-for="(item, index) in list" :key="item.id">
        <el-card :body-style="{ padding: '0px' }">
          <img :src="item.pic" class="image">
          <div style="padding: 14px;">
            <span>{{ item.name }}</span>
            <div class="bottom clearfix">
              <time class="time">{{ item.addtime }}</time>
              <router-link :to="item.url" class="button">点击进入</router-link>
            </div>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>
<script>
import http from '../../assets/js/http'
export default {
  data() {
    return {
      currentDate: '2018-09-13',
      dataCount: null,
      currentPage: null,
      keywords: '',
      list: [],
      limit: 10
    }
  },
  methods: {
    getCenterList() {
      const data = {
        params: {
          keywords: this.keywords,
          page: this.currentPage,
          limit: this.limit,
          sid: Lockr.get('userInfo').id
        }
      }
      this.apiGet('admin/center', data).then((res) => {
        // console.log('res = ', _g.j2s(res))
        this.handelResponse(res, (data) => {
          this.list = data.list
          this.dataCount = data.dataCount
        })
      })
    },
    getCurrentPage() {
      let data = this.$route.query
      if (data) {
        if (data.page) {
          this.currentPage = parseInt(data.page)
        } else {
          this.currentPage = 1
        }
      }
    },
    getKeywords() {
      let data = this.$route.query
      if (data) {
        if (data.keywords) {
          this.keywords = data.keywords
        } else {
          this.keywords = ''
        }
      }
    },
    init() {
      this.getCurrentPage()
      this.getCenterList()
    }
  },
  created() {
    _g.closeGlobalLoading()
    this.init()
  },
  watch: {
    '$route' (to, from) {
      this.init()
    }
  },
  mixins: [http]
}
</script>
<style  scoped>
.time {
    font-size: 13px;
    color: #999;
  }

  .bottom {
    margin-top: 13px;
    line-height: 12px;
  }
  .bottom  a{color: #409eff; font-size: 14px; font-weight: 500; }
  .button {
    padding: 0;
    float: right;
  }

  .image {
    width: 100%;
    display: block;
  }

  .clearfix:before,
  .clearfix:after {
      display: table;
      content: "";
  }

  .clearfix:after {
      clear: both
  }
  .el-col{ margin-bottom: 20px; }
</style>
