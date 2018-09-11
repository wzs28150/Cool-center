<template>
  <div>
		<div class="m-b-20 ovf-hd">
			<div class="fl" v-show="addShow">
				<router-link class="btn-link-large add-btn" to="add">
					<i class="el-icon-plus"></i>&nbsp;&nbsp;添加会员
				</router-link>
			</div>
      <div class="fl w-200 m-l-30">
				<el-input placeholder="请输入用户姓名" v-model="keywords">
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
			prop="username"
			label="用户姓名">
			</el-table-column>
			<el-table-column
			prop="userid"
			label="用户名">
			</el-table-column>
      <el-table-column
			prop="anums"
			label="文章数量">
			</el-table-column>
      <el-table-column
			prop="ccc"
			label="已发数量">
			</el-table-column>
			<el-table-column
			label="注册时间"
			prop="ctime" width="160px">
			</el-table-column>
			<el-table-column
			label="到期时间"
			prop="dq">
			</el-table-column>
      <el-table-column
			label="备注2"
			prop="beizhu2">
			</el-table-column>
			<el-table-column
			label="操作" width="250px">
        <template scope="scope">
          <div>
            <span>
              <router-link :to="{ name: 'memberEdit', params: { id: scope.row.id }}" class="btn-link edit-btn">
            编辑
              </router-link>
            </span>
            <span>
              <el-button size="mini" type="danger" @click="confirmDelete(scope.row)">删除</el-button>
            </span>
            <span>
              <router-link :to="{ name: 'articleList', query: { id: scope.row.id }}" class="btn-link edit-btn">
            文章管理
              </router-link>
            </span>
            <div style="height:10px;"></div>
            <span>
              <router-link :to="{ name: 'adAdd', params: { id: scope.row.id }}" class="btn-link edit-btn">
            添加广告
              </router-link>
            </span>
            <span>
              <router-link :to="{ name: 'adList', query: { id: scope.row.id }}" class="btn-link edit-btn">
            广告管理
              </router-link>
            </span>
          </div>
        </template>
			</el-table-column>
		</el-table>
		<div class="pos-rel p-t-20">
			<btnGroup :selectedData="multipleSelection" :type="'member'"></btnGroup>
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
  data() {
    return {
      tableData: [],
      dataCount: null,
      currentPage: null,
      keywords: '',
      multipleSelection: [],
      limit: 10
    }
  },
  methods: {
    search() {
      router.push({ path: this.$route.path, query: { keywords: this.keywords, page: 1 }})
    },
    selectItem(val) {
      this.multipleSelection = val
    },
    confirmDelete(item) {
      this.$confirm('确认删除该会员?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        _g.openGlobalLoading()
        this.apiDelete('admin/member/', item.id).then((res) => {
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
    handleCurrentChange(page) {
      router.push({ path: this.$route.path, query: { keywords: this.keywords, page: page }})
    },
    getAllModule() {
      this.loading = true
      const data = {
        params: {
          keywords: this.keywords,
          page: this.currentPage,
          limit: this.limit,
          sid: Lockr.get('userInfo').id
        }
      }
      this.apiGet('admin/member', data).then((res) => {
        // console.log('res = ', _g.j2s(res))
        this.handelResponse(res, (data) => {
          this.tableData = data.list
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
      // this.getKeywords()
      this.getCurrentPage()
      this.getAllModule()
    }
  },
  computed: {
    addShow() {
      return _g.getHasRule('member-save')
    },
    editShow() {
      return _g.getHasRule('member-update')
    },
    deleteShow() {
      return _g.getHasRule('member-delete')
    }
  },
  created() {
    this.init()
    // _g.closeGlobalLoading()
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
</style>
