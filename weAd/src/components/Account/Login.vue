<template>
  <div>
    <el-carousel height="150px" :interval="5000" indicator-position="none">
      <el-carousel-item v-for="item in 4"  :key="item">
        <img src="~assets/images/bg.jpg" alt="">
      </el-carousel-item>
    </el-carousel>
    <transition name="el-fade-in-linear">
      <img src="~assets/images/banner1_img4256911.png" v-show="!formShow" class="banner-tit" alt="">
    </transition>
    <transition name="el-fade-in-linear">
      <el-form :model="form" :rules="rules2" ref="form" v-show="formShow" label-position="left" label-width="0px" class="demo-ruleForm card-box loginform">
      <h3 class="title">用户登录</h3>
      <el-form-item prop="username">
        <el-input type="text" v-model="form.username" auto-complete="off" placeholder="账号"></el-input>
      </el-form-item>
      <el-form-item prop="password">
        <el-input type="password" v-model="form.password" auto-complete="off" placeholder="密码"></el-input>
      </el-form-item>
      <el-form-item v-show="requireVerify" prop="verifyCode">
        <el-input type="text" v-model="form.verifyCode" auto-complete="off" placeholder="验证码" class="w-150"></el-input>
        <img :src="verifyUrl" @click="refreshVerify()" class="verify-pos"/>
      </el-form-item>
      <el-checkbox v-model="checked" style="margin:0px 0px 35px 0px;">记住密码</el-checkbox>
      <el-form-item style="width:100%;">
        <el-button type="primary" style="width:100%;" v-loading="loading" @click.native.prevent="handleSubmit2('form')">登录</el-button>
      </el-form-item>
    </el-form>
    </transition>
  </div>
</template>

<script>
  import http from '../../assets/js/http'

  export default {
    data() {
      return {
        title: '',
        systemName: '',
        loading: false,
        formShow: false,
        form: {
          username: '',
          password: '',
          verifyCode: ''
        },
        requireVerify: false,
        verifyUrl: '',
        verifyImg: axios.defaults.baseURL + '/api/base/getVerify',
        rules2: {
          username: [
            { required: true, message: '请输入账号', trigger: 'blur' }
          ],
          password: [
            { required: true, message: '请输入密码', trigger: 'blur' }
          ],
          verifyCode: [
            { required: false, message: '请输入验证码', trigger: 'blur' }
          ]
        },
        checked: false
      }
    },
    methods: {
      refreshVerify() {
        this.verifyUrl = ''
        setTimeout(() => {
          this.verifyUrl = this.verifyImg + '?v=' + moment().unix()
        }, 300)
      },
      handleSubmit2(form) {
        if (this.loading) return
        this.$refs.form.validate((valid) => {
          if (valid) {
            this.loading = !this.loading
            let data = {}
            if (this.requireVerify) {
              data.username = this.form.username
              data.password = this.form.password
              data.verifyCode = this.form.verifyCode
            } else {
              data.username = this.form.username
              data.password = this.form.password
            }
            if (this.checked) {
              data.isRemember = 1
            } else {
              data.isRemember = 0
            }
            this.apiPost('api/base/login', data).then((res) => {
              if (res.code != 200) {
                this.loading = !this.loading
                this.handleError(res)
              } else {
                this.refreshVerify()
                if (this.checked) {
                  Cookies.set('rememberPwd', true, { expires: 1 })
                }
                this.resetCommonData(res.data)
                _g.toastMsg('success', '登录成功')
              }
            })
          } else {
            return false
          }
        })
      },
      checkIsRememberPwd() {
        if (Cookies.get('rememberPwd')) {
          let data = {
            rememberKey: Lockr.get('rememberKey')
          }
          this.apiPost('api/base/relogin', data).then((res) => {
            this.handelResponse(res, (data) => {
              this.resetCommonData(data)
            })
          })
        }
      }
    },
    created() {
      this.checkIsRememberPwd()
      this.apiPost('api/base/getConfigs').then((res) => {
        this.handelResponse(res, (data) => {
          document.title = data.SYSTEM_NAME
          this.systemName = data.SYSTEM_NAME
          if (parseInt(data.IDENTIFYING_CODE)) {
            this.requireVerify = true
            this.rules2.verifyCode[0].required = true
          }
        })
      })
      // this.verifyUrl = this.verifyImg
      setTimeout(() => {
        this.formShow = true
      }, 3000)
    },
    mounted() {
      window.addEventListener('keyup', (e) => {
        if (e.keyCode === 13) {
          this.handleSubmit2('form')
        }
      })
    },
    mixins: [http]
  }
</script>

<style lang="scss">
  body,html{ height: 100%; }
  .el-carousel{ width: 100%;height: 100%; position: fixed; z-index: 0;
    .el-carousel__container{ height: 100%!important;
      .el-carousel__item {
        height: 100%;
        h3 {
          color: #475669;
          font-size: 14px;
          line-height: 150px;
          margin: 0;

        }

        &:nth-child(2n) {
           background-color: #99a9bf;
        }

        &:nth-child(2n+1) {
           background-color: #d3dce6;
        }
      }
    }
  }

  .banner-tit{
     position: fixed; z-index: 5; top: 30%; width: 70%; left: 50%; margin-left: -35%;
  }

.loginform {
	width: calc(100% - 70px);
	padding: 35px 35px 15px 35px;
  position: relative; z-index: 2;
  color: #fff;
  .title{ }
}
h3 {
  display: block;
  font-size: 1.17em;
  -webkit-margin-before: 1em;
  -webkit-margin-after: 1em;
  -webkit-margin-start: 0px;
  -webkit-margin-end: 0px;
  font-weight: bold;
}
.el-loading-mask {
	background: none;
}
</style>
