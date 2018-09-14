<template>
  <div class="edit">
    <!-- <div class="title">
      设置广告
    </div> -->
    <el-steps :active="active" :align-center="true" finish-status="success">
      <el-step title="设置广告"></el-step>
      <el-step title="编辑文章"></el-step>
      <el-step title="生成文章"></el-step>
    </el-steps>
    <el-form ref="form" :model="form" :rules="rules" label-position="top"  label-width="6em">
      <div :class="active==0?'form-step show':'form-step '">
        <el-form-item label="原文链接" prop="link">
          <el-input v-model.trim="form.link" ></el-input>
        </el-form-item>
        <el-form-item label="选择广告" prop="adid">
          <el-select v-model.trim="form.adid" placeholder="请选择广告类型">
            <el-option v-for="item in adlist" :key="item.key"  :label="item.ad_title" :value="item.id"></el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="全屏广告" prop="is_quanping">
          <el-radio-group v-model.trim="form.is_quanping">
            <el-radio  label="1" size="small" border>显示</el-radio>
            <el-radio  label="0" active size="small" border>隐藏</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit1('form')">下一步</el-button>
          <el-button @click="goback()">返回</el-button>
        </el-form-item>
      </div>
      <div :class="active==1?'form-step show':'form-step '">
        <el-form-item label="文章标题" prop="title">
          <el-input v-model.trim="form.title" type="textarea" ></el-input>
        </el-form-item>
        <el-form-item label="文章内容" >
          <vue-html5-editor :content="form.content" @change="updateContent" :auto-height="true" :show-module-name="false"></vue-html5-editor>
        </el-form-item>
        <el-form-item>
          <el-button type="primary" @click="onSubmit2('form')">下一步</el-button>
          <el-button @click="backstep()">返回</el-button>
        </el-form-item>
      </div>
      <div :class="active==2?'form-step show':'form-step '">

      </div>
    </el-form>
  </div>
</template>
<script>
import http from '../../assets/js/http'
import fomrMixin from '../../assets/js/form_com'
export default {
  data() {
    return {
      url: '',
      active: 0,
      form: {
        link: '',
        adid: '',
        is_quanping: '0',
        title: '',
        content: ''
      },
      id: null,
      adlist: [],
      rules: {
        link: [
          { required: true, message: '请输入原文链接' }
        ],
        adid: [
          { required: true, message: '请选择广告类型' }
        ]
      }
    }
  },
  methods: {
    onSubmit1(form) {
      _g.openGlobalLoading()
      this.$refs.form.validate((pass) => {
        if (pass) {
          this.apiPost('api/article/add', this.form).then((res) => {
            this.handelResponse(res, (data) => {
              // _g.toastMsg('success', '添加成功')
              // console.log(res.data.id)
              // router.push({ path: '/article/add/' + res.data.id })
              this.form.title = res.data.title
              this.form.content = res.data.content
              this.id = res.data.id
              this.form.share_pic = res.data.cover
              this.form.share_desc = res.data.msg_desc
              this.form.userid = Lockr.get('userInfo').id
              if (this.active <= 2) {
                _g.closeGlobalLoading()
                this.active = this.active + 1
              }
            })
          })
        }
      })
    },
    updateContent(v) {
      this.form.content = v
    },
    onSubmit2(form) {
      _g.openGlobalLoading()
      this.$refs.form.validate((pass) => {
        if (pass) {
          this.form.id = this.id
          this.apiPost('api/article/save', this.form).then((res) => {
            this.handelResponse(res, (data) => {
              // console.log(data)
              // _g.toastMsg('success', '添加成功')
              // console.log(res.data.id)
              router.push({ path: '/article/infonn/' + this.id })
              // if (this.active <= 2) {
              //   _g.closeGlobalLoading()
              //   this.active = this.active + 1
              // }
            })
          })
        }
      })
    },
    backstep() {
      if (this.active > 0) {
        this.active = this.active - 1
      }
    },
    init() {
      this.apiGet('api/article/adlist/' + Lockr.get('userInfo').id).then((res) => {
        this.handelResponse(res, (data) => {
          this.adlist = res.data
          _g.closeGlobalLoading()
        })
      })
    }
  },
  created() {
    this.form.link = this.$route.query.url
    this.init()
  },
  mixins: [http, fomrMixin]
}
</script>
<style lang="scss" scoped>
  .el-steps{ margin-bottom: 20px; }
  .edit{ background-color: #fff; padding: 15px; min-height: 100%; height: 100%;
    .title{ text-align: center;  margin-bottom: 15px; color: #000; font-size: 18px; }
    .form-step{ display: none;
      &.show{ display: block; }
    }
  }
  .el-form-item__label{ width: 4em!important; }
</style>
