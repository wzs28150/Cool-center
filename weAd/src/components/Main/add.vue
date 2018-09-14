<template>
  <div class="edit">
    <div class="title">
      编辑文章
    </div>
    <el-form ref="form" :model="form" :rules="rules" label-position="top"  label-width="6em">
      <el-form-item label="文章标题" prop="title">
        <el-input v-model.trim="form.title" class="ftitle" type="textarea" ></el-input>
      </el-form-item>
      <el-form-item label="文章内容" >
        <vue-html5-editor :content="form.content" @change="updateContent" :auto-height="true" :show-module-name="false"></vue-html5-editor>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="onSubmit('form')">提交</el-button>
        <el-button @click="back">返回</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>
<script>
import http from '../../assets/js/http'
import fomrMixin from '../../assets/js/form_com'
export default {
  data() {
    return {
      id: null,
      form: {
        title: '',
        content: ''
      },
      info: [],
      addFormVisible: false,
      rules: {
        title: [
          { required: true, message: '请输入文章标题' }
        ],
        content: [
          { required: true, message: '请输入文章内容' }
        ]
      }
    }
  },
  methods: {
    updateContent(v) {
      this.form.content = v
    },
    back() {
      router.replace('/me/list')
    },
    onSubmit(form) {
      _g.openGlobalLoading()
      this.$refs.form.validate((pass) => {
        if (pass) {
          this.form.id = this.id
          this.apiPost('api/article/save', this.form).then((res) => {
            this.handelResponse(res, (data) => {
              _g.toastMsg('success', '修改成功')
              setTimeout(() => {
                this.goback()
              }, 1500)
              // console.log(data)
              // _g.toastMsg('success', '添加成功')
              // console.log(res.data.id)
              // router.push({ path: '/article/info/' + this.id })
              // if (this.active <= 2) {
              //   _g.closeGlobalLoading()
              //   this.active = this.active + 1
              // }
            })
          })
        }
      })
    },
    init() {
      this.apiGet('api/articleinfo/' + this.id).then((res) => {
        this.handelResponse(res, (data) => {
          this.form.title = res.data.title
          this.form.content = res.data.content
          _g.closeGlobalLoading()
        })
      })
    }
  },
  created() {
    console.log(this.$route.params.id)
    this.id = this.$route.params.id
    this.init()
  },
  mixins: [http, fomrMixin]
}
</script>
<style media="screen">
  .ftitle textarea{ font-size: 22px; line-height: 1.4; margin-bottom: 14px; color: #333; font-weight: 400!important; font-family: Helvetica Neue, Helvetica, PingFang SC, Hiragino Sans GB, Microsoft YaHei, SimSun, sans-serif!important; }
  .vue-html5-editor img{ width: auto!important; height: auto!important; max-width: 100%!important;}
</style>
<style lang="scss" scoped>
.edit{ background-color: #fff; padding: 15px; min-height: 100%; height: 100%;
  .title{ text-align: center;  margin-bottom: 15px; color: #000; font-size: 18px; }

}
.el-form-item__label{ width: 4em!important; }
</style>
