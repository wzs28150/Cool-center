<template>
  <div>
		<div class="m-b-20 ovf-hd">
			<div class="fl" v-show="addShow">
				<router-link class="btn-link-large add-btn" to="add">
					<i class="el-icon-plus"></i>&nbsp;&nbsp;添加字段
				</router-link>
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
			prop="field"
			label="字段名">
			</el-table-column>
			<el-table-column
			label="别名"
			prop="name">
			</el-table-column>
			<el-table-column
			label="字段类型"
			prop="type">
			</el-table-column>
      <el-table-column
			label="系统字段">
      <template scope="scope">
        <el-switch v-model="scope.row.issystem" :active-value="1" @change="itemChange(scope.row,'issystem',$event)" :inactive-value="0"></el-switch>
      </template>
			</el-table-column>
      <el-table-column
			label="必填"
      >
        <template scope="scope">
          <el-switch v-model="scope.row.required" :active-value="1" @change="itemChange(scope.row,'required',$event)" :inactive-value="0"></el-switch>
        </template>
			</el-table-column>
      <el-table-column
			label="排序"
			width="200">
      <template scope="scope">
        <el-input-number v-model="scope.row.listorder" size="mini" controls-position="right" @change="itemChange(scope.row,'listorder',$event)" :min="0" ></el-input-number>
      </template>
			</el-table-column>
			<el-table-column
			label="状态"
			width="100">
        <template scope="scope">
          <el-switch v-model="scope.row.status" :active-value="1" @change="itemChange(scope.row,'status',$event)" :inactive-value="0"></el-switch>
        </template>
			</el-table-column>
			<el-table-column
			label="操作"
			width="250">
        <template scope="scope">
          <div>
            <span>
              <router-link :to="{ name: 'moduleEdit', params: { id: scope.row.id }}" class="btn-link edit-btn">
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
			<btnGroup :selectedData="multipleSelection" :type="'module'"></btnGroup>
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
import btnGroup from '../../Common/btn-group.vue'
import http from '../../../assets/js/http'
export default {
  data() {
    return {
      tableData: [],
      dataCount: null,
      currentPage: null,
      keywords: '',
      multipleSelection: [],
      mid: 0,
      limit: 15
    }
  },
  methods: {
    search() {
      router.push({ path: this.$route.path, query: { keywords: this.keywords, page: 1 }})
    },
    selectItem(val) {
      this.multipleSelection = val
    },
    handleCurrentChange(page) {
      router.push({ path: this.$route.path, query: { keywords: this.keywords, page: page }})
    },
    itemChange(item, field, event) {
      // console.log(event)
      this.loading = true
      const data = {
        id: item.id,
        field: field,
        value: event
      }
      this.apiPost('admin/field/change', data).then((res) => {
        // console.log('res = ', _g.j2s(res))
      })
      // _g.shallowRefresh(this.$route.name, this.mid)
    },
    confirmDelete(item) {
      this.$confirm('确认删除该模型?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        _g.openGlobalLoading()
        this.apiDelete('admin/module/', item.id).then((res) => {
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
    getAllModule() {
      this.loading = true
      const data = {
        params: {
          mid: this.mid,
          keywords: this.keywords,
          page: this.currentPage,
          limit: this.limit
        }
      }
      this.apiGet('admin/field', data).then((res) => {
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
  created() {
    this.mid = this.$route.params.id
    // console.log(this.$route)
    this.init()
  },
  computed: {
    addShow() {
      return _g.getHasRule('module-save')
    },
    editShow() {
      return _g.getHasRule('module-update')
    },
    deleteShow() {
      return _g.getHasRule('module-delete')
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
</style>
