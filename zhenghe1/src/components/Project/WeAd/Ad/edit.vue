<template>
  <div class="m-l-50 m-t-30 w-500">
    <el-form ref="form" :model="form" :rules="rules" label-width="130px">
      <el-form-item label="广告标题" prop="ad_title">
        <el-input v-model.trim="form.ad_title" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="广告链接" prop="ad_link">
        <el-input v-model.trim="form.ad_link" class="h-40 w-200" placeholder="（包含：http://）"></el-input>
      </el-form-item>
      <el-form-item label="联系电话" prop="adtelnumber">
        <el-input v-model.trim="form.adtelnumber" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="联系QQ" prop="adqqnumber">
        <el-input v-model.trim="form.adqqnumber" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="一键导航" prop="adlbs">
        <el-input v-model.trim="form.adlbs" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="广告图片" >
        (尺寸：最大宽度740px;宽高比7:2)
      </el-form-item>
      <el-form-item label="广告一">
        <el-upload
          :action="uploadUrl"
          :on-preview="viewPic"
          :on-remove="handleRemove"
          :on-success="uploadSuccess"
          :on-error="uploadFail"
          :limit="1"
          :on-exceed="handleExceed"
          :data="{item: 'ad_img'}"
          :file-list="fileList['ad_img']"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过2m</div>
        </el-upload>
      </el-form-item>
      <el-form-item label="广告二">
        <el-upload
          :action="uploadUrl"
          :on-preview="viewPic"
          :on-remove="handleRemove"
          :on-success="uploadSuccess"
          :on-error="uploadFail"
          :limit="1"
          :on-exceed="handleExceed"
          :data="{item: 'ad_img_one'}"
          :file-list="fileList['ad_img_one']"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过2m</div>
        </el-upload>
      </el-form-item>
      <el-form-item label="广告三">
        <el-upload
          :action="uploadUrl"
          :on-preview="viewPic"
          :on-remove="handleRemove"
          :on-success="uploadSuccess"
          :on-error="uploadFail"
          :limit="1"
          :on-exceed="handleExceed"
          :data="{item: 'ad_img_two'}"
          :file-list="fileList['ad_img_two']"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过2m</div>
        </el-upload>
      </el-form-item>
      <el-form-item label="二维码">
        <el-upload
          :action="uploadUrl"
          :on-preview="viewPic"
          :on-remove="handleRemove"
          :on-success="uploadSuccess"
          :on-error="uploadFail"
          :limit="1"
          :on-exceed="handleExceed"
          :data="{item: 'erweima'}"
          :file-list="fileList['erweima']"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过2m</div>
        </el-upload>
      </el-form-item>
      <el-form-item label="全屏图">
        <el-upload
          :action="uploadUrl"
          :on-preview="viewPic"
          :on-remove="handleRemove"
          :on-success="uploadSuccess"
          :on-error="uploadFail"
          :limit="1"
          :on-exceed="handleExceed"
          :data="{item: 'quanping'}"
          :file-list="fileList['quanping']"
          list-type="picture">
          <el-button size="small" type="primary">点击上传</el-button>
          <div slot="tip" class="el-upload__tip">只能上传jpg/png文件，且不超过2m</div>
        </el-upload>
      </el-form-item>
      <el-form-item label="全屏广告链接" prop="ad_link2">
        <el-input v-model.trim="form.ad_link2" class="h-40 w-200" placeholder="（包含：http://）"></el-input>
      </el-form-item>
      <el-form-item label="公众号名称" prop="wechat_name">
        <el-input v-model.trim="form.wechat_name" class="h-40 w-200"></el-input>
      </el-form-item>
      <el-form-item label="公众号链接" prop="wechat_url">
        <el-input v-model.trim="form.wechat_url" class="h-40 w-200" placeholder="输入公众号关注链接"></el-input>
      </el-form-item>
      <el-form-item label="官网链接" prop="wechat_url">
        <el-input v-model.trim="form.home_url" class="h-40 w-200" placeholder="输入官网链接"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button type="primary" @click="add()" :loading="isLoading">提交</el-button>
      </el-form-item>
    </el-form>
    <preview ref="preview" :url="propsImg"></preview>
  </div>
</template>
<style >
  .el-upload-dragger{ height: auto; }
</style>
<script>
import http from '../../assets/js/http'
import preview from './preview.vue'
import fomrMixin from '../../assets/js/form_com'

export default {
  data () {
    return {
      isLoading: false,
      fileList: [],
      propsImg: '',
      form: {
        ad_title: '',
        ad_link: '#',
        adtelnumber: '',
        adqqno: '',
        adlbs: '',
        ad_link2: '',
        wechat_name: '',
        wechat_url: '',
        ad_img: '',
        home_url: ''
      },
      id: '',
      uploadUrl: '',
      rules: {
        SYSTEM_NAME: [
          { required: true, message: '请输入系统名称' }
        ],
        LOGIN_SESSION_VALID: [
          { required: true, message: '请输入登录有效期' },
          { type: 'number', message: '请输入数字' }
        ]
      }
    }
  },
  methods: {
    add () {
      this.$refs.form.validate((pass) => {
        if (pass) {
          this.isLoading = !this.isLoading
          this.apiPut('admin/ad/', this.id, this.form).then((res) => {
            this.handelResponse(res, (data) => {
              _g.toastMsg('success', '提交成功')
              this.isLoading = !this.isLoading
              setTimeout(() => {
                this.goback()
              }, 1500)
            }, () => {
              this.isLoading = !this.isLoading
            })
          })
        }
      })
    },
    uploadSuccess (res, file, fileList) {
      this.form[res.data.item] = res.data.file
      console.log(this.form)
      let data = {
        name: '图片',
        url: axios.defaults.baseURL + '/' + res.data.file
      }
      // if (this.fileList.length) {
      //   this.fileList[0] = data
      // } else {
      //   this.fileList.push(data)
      // }.
      this.fileList[res.data.item] = data
    },
    uploadFail (err, res, file) {
      console.log('err = ', _g.j2s(err))
      console.log('res = ', _g.j2s(res))
    },
    handleRemove (file, fileList) {
      console.log('file = ', file)
      console.log('fileList = ', fileList)
    },
    handleExceed (files, fileList) {
      this.$message.warning('请先删除当前选的图片再上传！')
    },
    viewPic () {
      this.propsImg = this.fileList[0].url
      this.$refs.preview.open()
    },
    init () {
      this.apiGet('admin/ad/' + this.id).then((res) => {
        this.handelResponse(res, (data) => {
          _g.closeGlobalLoading()
          this.form.ad_title = data.ad_title
          this.form.ad_link = data.ad_link
          this.form.adtelnumber = data.adtelnumber
          this.form.adqqnumber = data.adqqnumber
          this.form.adlbs = data.adlbs
          this.form.ad_link2 = data.ad_link2
          this.form.wechat_name = data.wechat_name
          this.form.wechat_url = data.wechat_url
          if (data.ad_img) {
            let img = axios.defaults.baseURL + '/' + data.ad_img
            this.fileList['ad_img'] = [{ name: data.ad_img, url: img }]
            this.form.ad_img = data.ad_img
          }
          if (data.ad_img_one) {
            let img = axios.defaults.baseURL + '/' + data.ad_img_one
            this.fileList['ad_img_one'] = [{ name: data.ad_img_one, url: img }]
            this.form.ad_img_one = data.ad_img_one
          }
          if (data.ad_img_two) {
            let img = axios.defaults.baseURL + '/' + data.ad_img_two
            this.fileList['ad_img_two'] = [{ name: data.ad_img_two, url: img }]
            this.form.ad_img_two = data.ad_img_two
          }
          if (data.erweima) {
            let img = axios.defaults.baseURL + '/' + data.erweima
            this.fileList['erweima'] = [{ name: data.erweima, url: img }]
            this.form.erweima = data.erweima
          }
          if (data.quanping) {
            let img = axios.defaults.baseURL + '/' + data.quanping
            this.fileList['quanping'] = [{ name: data.quanping, url: img }]
            this.form.quanping = data.quanping
          }
        })
      })
    }
  },
  created () {
    this.id = this.$route.params.id
    this.uploadUrl = axios.defaults.baseURL + '/admin/upload'
    this.init()
  },
  components: {
    preview
  },
  mixins: [http, fomrMixin]
}
</script>
