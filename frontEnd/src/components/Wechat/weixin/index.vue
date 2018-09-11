<template>
<div class="m-l-50 m-t-30 w-500">
  <el-form ref="form"
           :model="form"  label-width="110px">
    <el-form-item label="服务器地址" prop="apiurl">
      <el-input v-model.trim="form.apiurl" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="公众号名称" prop="wxname">
      <el-input v-model.trim="form.wxname" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="原始ID" prop="wxid">
      <el-input v-model.trim="form.wxid" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="微信号" prop="weixin">
      <el-input v-model.trim="form.weixin" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="AppID" prop="appid">
      <el-input v-model.trim="form.appid" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="AppSecret" prop="appsecret">
      <el-input v-model.trim="form.appsecret" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="Token" prop="w_token">
      <el-input v-model.trim="form.w_token" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="微信号类型" prop="type">
      <el-select v-model.trim="form.type"  placeholder="请选择" class="h-40 w-300">
        <el-option
          v-for="item in type"
          :key="item.value"
          :label="item.label"
          :value="item.value">
        </el-option>
      </el-select>
    </el-form-item>
    <el-form-item  label="接入状态" prop="wait_access">
      <el-radio v-model.trim="form.wait_access"  label="0">等待接入</el-radio>
      <el-radio v-model.trim="form.wait_access"  label="1">已接入</el-radio>
    </el-form-item>
    <el-form-item label="关注回复" prop="concern">
      <el-input v-model.trim="form.concern" type="textarea" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item label="默认回复" prop="default">
      <el-input v-model.trim="form.default" type="textarea" class="h-40 w-300"></el-input>
    </el-form-item>
    <el-form-item>
      <el-button type="primary" @click="onSubmit()" :loading="isLoading">提交</el-button>
    </el-form-item>
  </el-form>
</div>
</template>
<script>
import http from '../../../assets/js/http'

export default {
  data() {
    return {
      form: {
        apiurl: '',
        wxname: '',
        wxid: '',
        weixin: '',
        appid: '',
        appsecret: '',
        w_token: '',
        type: '1',
        wait_access: '0',
        concern: '',
        default: ''
      },
      type: [{
        value: '1',
        label: '订阅号'
      }, {
        value: '2',
        label: '认证订阅号'
      }, {
        value: '3',
        label: '服务号'
      }, {
        value: '4',
        label: '认证服务号'
      }]
    }
  },
  methods: {
    onSubmit(form) {
      this.$refs.form.validate((pass) => {
        this.isLoading = !this.isLoading
        this.apiPut('admin/wechat/', 1, this.form).then((res) => {
          this.handelResponse(res, (data) => {
            _g.toastMsg('success', '修改成功')
            _g.clearVuex('setwechat')
          }, () => {
            this.isLoading = !this.isLoading
          })
        })
      })
    },
    async getCompleteData() {
      this.apiGet('admin/wechat/').then((res) => {
        this.form = res.data
        _g.closeGlobalLoading()
      })
    }
  },
  created() {
    this.getCompleteData()
  },
  mixins: [http]
}
</script>
<style  scoped>
</style>
