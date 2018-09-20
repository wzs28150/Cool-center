<template>
  <div>
    <div class="m-b-20">
      <el-button type="primary" @click="backUp" ><i class="el-icon-download el-icon--left"></i>备份</el-button>
    </div>
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
      label="数据库表"
      width="150">
      </el-table-column>
      <el-table-column
      prop="rows"
      label="记录条数">
      </el-table-column>
      <el-table-column
      prop="size"
      label="占用空间">
      </el-table-column>
      <el-table-column
      prop="engine"
      label="类型">
      </el-table-column>
      <el-table-column
      prop="collation"
      label="编码">
      </el-table-column>
      <el-table-column
      prop="create_time"
      label="创建时间">
      </el-table-column>
      <!-- <el-table-column
      prop="Comment"
      label="说明">
      </el-table-column> -->
      <el-table-column
      label="操作"
      width="200">
        <template slot-scope="scope">
          <span>
            <el-button
            size="mini"
            type="primary"
            @click="optimize(scope.row.name)">
            优化
            </el-button>
          </span>
          <span>
            <el-button
            size="mini"
            type="danger"
            @click="confirmDelete(scope.row.name)">
            修复
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
      multipleSelection: []
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
    optimize (table) {
      const data = {
        table: table
      }
      this.apiPost('admin/database/optimize', data).then((res) => {
        this.handelResponse(res, (data) => {
          _g.toastMsg('success', '数据表优化成功！')
        })
      })
    },
    backUp () {
      const data = {
        table: this.multipleSelection
      }
      this.apiPost('admin/database/backup', data).then((res) => {
        this.handelResponse(res, (data) => {
          _g.toastMsg('success', '数据表优化成功！')
        })
      })
    }
  },
  created () {
    this.apiGet('admin/database/database').then((res) => {
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
