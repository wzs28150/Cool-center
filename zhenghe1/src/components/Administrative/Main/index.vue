<template>
  <div id="">
    <el-row :gutter="20">
      <el-col :span="8">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>快捷方式</span>
            <el-button style="float: right; padding: 3px 0" type="text">操作按钮</el-button>
          </div>
          <div style="height:207px">
            <div v-for="o in 4" :key="o" class="text item">
              {{'列表内容 ' + o }}
            </div>
          </div>
        </el-card>
      </el-col>
      <el-col :span="8">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>数据统计</span>
            <el-button style="float: right; padding: 3px 0" type="text">操作按钮</el-button>
          </div>
          <div style="height:207px">
            <div v-for="o in 4" :key="o" class="text item">
              {{'列表内容 ' + o }}
            </div>
          </div>
        </el-card>
      </el-col>
      <el-col :span="8">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>版本信息</span>
            <!-- <el-button style="float: right; padding: 3px 0" type="text">操作按钮</el-button> -->
          </div>
          <template>
          <table class="el-table el-table--border">
            <tr class="el-table__row">
              <td><div class="cell">当前版本</div></td>
              <td>
                <div class="cell">v1.0.0 std <a href="http://fly.layui.com/docs/3/" target="_blank" style="padding-left: 15px;">更新日志</a></div>
              </td>
            </tr>
            <tr class="el-table__row">
              <td><div class="cell">基于框架</div></td>
              <td>
                <div class="cell">layui-v2.3.0</div>
              </td>
            </tr>
            <tr class="el-table__row">
              <td><div class="cell">主要特色</div></td>
              <td><div class="cell">零门槛 / 响应式 / 清爽 / 极简</div></td>
            </tr>
            <tr class="el-table__row">
              <td><div class="cell">获取渠道</div></td>
              <td>
                <div class="cell">
                  <a href="http://www.layui.com/admin/" target="_blank" class="layui-btn layui-btn-danger">获取授权</a>
                  <a href="http://fly.layui.com/download/layuiAdmin/" target="_blank" class="layui-btn">立即下载</a>
                </div>
              </td>
            </tr>
          </table>
        </template>
        </el-card>
      </el-col>
    </el-row>
    <el-row :gutter="20" style="margin-top:20px;">
      <el-col :span="24">
        <el-card class="box-card">
          <div slot="header" class="clearfix">
            <span>数据概览</span>
            <el-button style="float: right; padding: 3px 0" type="text">操作按钮</el-button>
          </div>
          <div style="height:207px">
            <div v-for="o in 4" :key="o" class="text item">
              {{'列表内容 ' + o }}
            </div>
          </div>
        </el-card>
      </el-col>
    </el-row>
  </div>
</template>
<script>
export default {
  data: () => ({

  }),
  methods: {
    methodName() {

    }
  },
  created() {
    _g.closeGlobalLoading()
  }
}
</script>
<style scoped>
  .grid-content{ color: #333; font-weight: normal; }
  .bg-blue{ color: #fff; }
  .bg-green{ background-color: #00FFFF;}
</style>
