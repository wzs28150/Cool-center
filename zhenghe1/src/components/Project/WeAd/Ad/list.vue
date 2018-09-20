<template>
  <div>
    <div class="m-b-20 ovf-hd">
      <!-- <div class="fl" v-show="addShow">
        <router-link class="btn-link-large add-btn" to="add">
          <i class="el-icon-plus"></i>&nbsp;&nbsp;添加模型
        </router-link>
      </div> -->
      <div class="fl w-300 ">
        <el-input placeholder="请输入用户名" v-model="keywords">
          <el-button slot="append" icon="el-icon-search" @click="search()"></el-button>
        </el-input>
      </div>
    </div>
    <el-table
    :data="tableData"
    stripe
    style="width: 100%"
    @selection-change="selectItem">
      <el-table-column
      type="selection"
      width="50">
      </el-table-column>
      <el-table-column
      prop="ad_title"
      label="广告名称">
      </el-table-column>
      <el-table-column
      label="用户ID"
      prop="username"
      width="200">
      </el-table-column>
      <el-table-column
      label="广告图片">
      <template slot-scope="scope">
        <div>
          <img class="adimg" :src="scope.row.ad_img" alt="">
          <img class="adimg" :src="scope.row.ad_img_one" alt="">
          <img class="adimg" :src="scope.row.ad_img_two" alt="">
        </div>
      </template>
      </el-table-column>
      <el-table-column
      label="二维码"
      width="100">
      <template slot-scope="scope">
        <div>
          <img class="adimg" :src="scope.row.erweima" alt="">
        </div>
      </template>
      </el-table-column>
      <el-table-column
      label="状态"
      width="100">
        <template slot-scope="scope">
          <div>
            {{ scope.row.status | status }}
          </div>
        </template>
      </el-table-column>
      <el-table-column
      label="操作"
      width="250">
        <template slot-scope="scope">
          <div>
            <span>
              <router-link :to="{ name: 'adEdit', params: { id: scope.row.id }}" class="btn-link edit-btn">
            编辑
              </router-link>
            </span>
            <span>
              <el-button size="mini" type="danger" @click="confirmDelete(scope.row)">删除</el-button>
            </span>
          </div>
        </template>
      </el-table-column>
    </el-table>
    <div class="pos-rel p-t-20">
      <btnGroup :selectedData="multipleSelection" :type="'ad'"></btnGroup>
      <div class="block pages">
        <el-pagination
        @current-change="handleCurrentChange"
        layout="prev, pager, next"
        :page-size="limit"
        :current-page="currentPage"
        :total="dataCount">
        </el-pagination>
      </div>
    </div>
  </div>
</template>
<script>
import btnGroup from '../Common/btn-group.vue'
import http from '../../assets/js/http'
export default {
  data () {
    return {
      tableData: [],
      dataCount: null,
      currentPage: null,
      keywords: '',
      multipleSelection: [],
      limit: 15,
      mid: null
    }
  },
  methods: {
    search () {
      router.push({path: this.$route.path, query: { keywords: this.keywords, page: 1 }})
    },
    selectItem (val) {
      this.multipleSelection = val
    },
    handleCurrentChange (page) {
      router.push({path: this.$route.path, query: { keywords: this.keywords, page: page }})
    },
    confirmDelete (item) {
      this.$confirm('确认删除该广告?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        _g.openGlobalLoading()
        this.apiDelete('admin/ad/', item.id).then((res) => {
          _g.closeGlobalLoading()
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', '删除成功')
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1500)
          })
        })
      }).catch(() => {
        // catch error
      })
    },
    getAllad () {
      this.loading = true
      const data = {
        params: {
          uid: Lockr.get('userInfo').id,
          mid: this.mid,
          keywords: this.keywords,
          page: this.currentPage,
          limit: this.limit
        }
      }
      this.apiGet('admin/ad', data).then((res) => {
        // console.log('res = ', _g.j2s(res))
        this.handelResponse(res, (data) => {
          this.tableData = data.list
          this.dataCount = data.dataCount
        })
      })
    },
    getCurrentPage () {
      let data = this.$route.query
      if (data) {
        if (data.page) {
          this.currentPage = parseInt(data.page)
        } else {
          this.currentPage = 1
        }
      }
    },
    getKeywords () {
      let data = this.$route.query
      if (data) {
        if (data.keywords) {
          this.keywords = data.keywords
        } else {
          this.keywords = ''
        }
      }
    },
    init () {
      this.getKeywords()
      this.getCurrentPage()
      this.getAllad()
    }
  },
  created () {
    if (this.$route.query.id) {
      this.mid = this.$route.query.id
    }
    this.init()
  },
  computed: {
    addShow () {
      return _g.getHasRule('ad-save')
    },
    editShow () {
      return _g.getHasRule('ad-update')
    },
    deleteShow () {
      return _g.getHasRule('ad-delete')
    }
  },
  watch: {
    '$route' (to, from) {
      this.init()
    }
  },
  components: {
    btnGroup
  },
  mixins: [http]
}
</script>
<style  scoped>
  .adimg{ display: inline-block; height: 50px; width: auto; }
</style>
