<template>
	<div class="m-l-50 m-t-30 w-500">
		<el-form ref="form" :model="form" :rules="rules" label-width="130px">
			<el-form-item label="模型名称" prop="title">
				<el-input v-model.trim="form.title"  ></el-input>
			</el-form-item>
			<el-form-item label="表名" prop="name">
				<el-input v-model.trim="form.name" ></el-input>
			</el-form-item>
			<el-form-item label="列表页字段" prop="listfields">
				<el-input v-model.trim="form.listfields" ></el-input>
			</el-form-item>
			<el-form-item label="详述" prop="description">
        <el-input type="textarea" v-model.trim="form.description" ></el-input>
			</el-form-item>
			<el-form-item label="新建表字段">
				<el-radio v-for="item in groupOptions" v-model.trim="form.emptytable" :label="item.id" >{{item.title}}</el-radio>
			</el-form-item>
			<el-form-item>
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
  import http from '../../../assets/js/http'
  import fomrMixin from '../../../assets/js/form_com'

  export default {
    data() {
      return {
        isLoading: false,
        form: {
          title: '',
          name: '',
          listfields: '*',
          description: '',
          emptytable: 0
        },
        orgsOptions: [],
        groupOptions: [
          { 'id': 1, 'title': '空表字段' },
          { 'id': 0, 'title': '普通文章表字段' }
        ],
        rules: {
          title: [
            { required: true, message: '请输入模型名称' }
          ],
          name: [
            { required: true, message: '请输入模型表名' }
          ],
          emptytable: [
            { required: true, message: '请选择新建表字段类型' }
          ]
        }
      }
    },
    methods: {
      add(form) {
        // console.log('res = ', _g.j2s(this.form))
        this.$refs.form.validate((pass) => {
          if (pass) {
            this.isLoading = !this.isLoading
            this.apiPost('admin/module', this.form).then((res) => {
              this.handelResponse(res, (data) => {
                _g.toastMsg('success', '添加成功')
                _g.clearVuex('setUsers')
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
    created() {
      _g.closeGlobalLoading()
    },
    mixins: [http, fomrMixin]
  }
</script>
