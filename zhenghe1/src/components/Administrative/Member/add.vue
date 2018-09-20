<template>
  <div class="m-l-50 m-t-30 w-500">
    <el-form ref="form" :model="form" :rules="rules" label-width="130px">
      <el-form-item label="用户名" prop="userid">
        <el-input v-model.trim="form.userid" class="h-40 w-300"  ></el-input>
      </el-form-item>
      <el-form-item label="密码" prop="pwd">
        <el-input type="password" v-model.trim="form.pwd" class="h-40 w-300"></el-input>
      </el-form-item>
      <el-form-item label="确认密码" prop="repwd">
        <el-input type="password" v-model.trim="form.repwd" class="h-40 w-300"></el-input>
      </el-form-item>
      <el-form-item label="用户姓名" prop="username">
        <el-input v-model.trim="form.username" class="h-40 w-300"></el-input>
      </el-form-item>
      <el-form-item label="文章数量" prop="anums">
        <el-input-number v-model.trim="form.anums" controls-position="right" class="h-40 w-300" :min="0" ></el-input-number>
      </el-form-item>
      <el-form-item label="到期时间" prop="beizhu1">
        <el-date-picker v-model.trim="form.beizhu1" type="date" class="h-40 w-300" placeholder="到期时间">
        </el-date-picker>
      </el-form-item>
      <el-form-item label="广告数" prop="adnums">
        <el-input-number v-model.trim="form.adnums" controls-position="right" class="h-40 w-300" :min="0" ></el-input-number>
      </el-form-item>
      <el-form-item label="备注" prop="beizhu2">
        <el-input type="textarea" v-model.trim="form.beizhu2" class="h-40 w-300"></el-input>
      </el-form-item>
      <el-form-item>
        <el-input type="hidden" v-model.trim="form.shuyu" ></el-input>
        <el-button type="primary" @click="add('form')" :loading="isLoading">提交</el-button>
        <el-button @click="goback()">返回</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<style type="text/css">
  .form-checkbox:first-child{
    margin-left: 15px;
  }
</style>
<script>
import http from '../../assets/js/http'
import fomrMixin from '../../assets/js/form_com'

export default {
  data () {
    return {
      isLoading: false,
      form: {
        userid: '',
        pwd: '',
        repwd: '',
        username: '',
        anums: '',
        beizhu1: '',
        adnums: '',
        beizhu2: '',
        shuyu: ''
      },
      username: '',
      rules: {
        userid: [
          { required: true, message: '请输入用户名' }
        ],
        pwd: [
          { required: true, message: '请输入密码' }
        ],
        repwd: [
          { required: true, message: '请输入确认密码' }
        ],
        username: [
          { required: true, message: '请输入用户姓名' }
        ],
        anums: [
          { required: true, type: 'number', message: '请输入文章数量' }
        ],
        beizhu1: [
          { required: true, type: 'date', message: '请输入到期时间' }
        ],
        adnums: [
          { required: true, type: 'number', message: '请输入广告数' }
        ],
        shuyu: [
          { required: true, message: '参数错误' }
        ]
      }
    }
  },
  methods: {
    add (form) {
      // console.log('res = ', _g.j2s(this.form))
      this.$refs.form.validate((pass) => {
        if (pass) {
          this.isLoading = !this.isLoading
          if (isNaN(this.form.beizhu1)) {
            this.form.beizhu1 = this.form.beizhu1.getTime() / 1000
          }
          this.apiPost('admin/member', this.form).then((res) => {
            this.handelResponse(res, (data) => {
              _g.toastMsg('success', '添加成功')
              setTimeout(() => {
                this.goback()
              }, 1500)
            }, () => {
              this.isLoading = !this.isLoading
            })
          })
        }
      })
    }
  },
  created () {
    _g.closeGlobalLoading()
    this.form.shuyu = Lockr.get('userInfo').id
  },
  mixins: [http, fomrMixin]
}
</script>
