<template>
  <div>
    <el-table
    :data="tableData"
    style="width: 100%"
    @selection-change="selectItem">
      <el-table-column
      type="selection"
      :context="_self"
      width="50">
      </el-table-column>
      <el-table-column
      prop="name"
      label="文件名称">
      </el-table-column>
      <el-table-column
      prop="size"
      label="文件大小">
      </el-table-column>
      <el-table-column
      prop="time"
      label="备份时间">
      </el-table-column>
      <!-- <el-table-column
      prop="number"
      label="卷号">
      </el-table-column> -->
      <!-- <el-table-column
      prop="Comment"
      label="说明">
      </el-table-column> -->
      <el-table-column
      label="操作"
      width="250">
        <template slot-scope="scope">
          <span>
            <el-button
            size="mini"
            type="primary"
            :loading="loading"
            @click="recover(scope.row.time)">
            恢复
            </el-button>
          </span>
          <span>
            <el-button
            size="mini"
            type="danger"
            @click="confirmDelete(scope.row.name)">
            下载
            </el-button>
          </span>
          <span>
            <el-button
            size="mini"
            type="danger"
            @click="confirmDelete(scope.row.name)">
            删除
            </el-button>
          </span>
        </template>
      </el-table-column>
    </el-table>
    <div class="pos-rel p-t-20">
      <btnGroup :selectedData="multipleSelection" :type="'menus'"></btnGroup>
    </div>
  </div>
</template>

<script>
import btnGroup from '../../../Common/btn-group.vue'
import http from '../../../../assets/js/http'

export default {
  data () {
    return {
      tableData: [],
      multipleSelection: [],
      loading: false
    }
  },
  methods: {
    selectItem (val) {
      this.multipleSelection = val
    },
    confirmDelete (item) {
      this.$confirm('确认删除该菜单?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        _g.openGlobalLoading()
        this.apiDelete('admin/menus/', item.id).then((res) => {
          _g.closeGlobalLoading()
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', '删除成功')
            setTimeout(() => {
              _g.shallowRefresh(this.$route.name)
            }, 1500)
          })
        })
      }).catch(() => {
        // handel error
      })
    },
    recover (time) {
      this.loading = true
      this.$confirm('确认删除该菜单?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        const data = {
          time: time
        }
        this.apiPost('admin/database/import', data).then((res) => {
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', '删除成功')
            setTimeout(() => {
              this.loading = false
            }, 1500)
          })
        })
      }).catch(() => {
        this.loading = false
      })
    }
  },
  created () {
    this.apiGet('admin/database/restore').then((res) => {
      this.handelResponse(res, (data) => {
        this.tableData = data
      })
    })
  },
  computed: {
    addShow () {
      return _g.getHasRule('menus-save')
    },
    editShow () {
      return _g.getHasRule('menus-update')
    },
    deleteShow () {
      return _g.getHasRule('menus-delete')
    }
  },
  components: {
    btnGroup
  },
  mixins: [http]
}
</script>
