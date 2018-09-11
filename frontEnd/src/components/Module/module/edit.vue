<template>
	<div class="m-l-50 m-t-30 w-500">
		<el-form ref="form" :model="form" :rules="rules" label-width="130px">
			<el-form-item label="模型名称" prop="title">
				<el-input v-model.trim="form.title"  ></el-input>
			</el-form-item>
			<el-form-item label="表名" prop="name">
				<el-input v-model.trim="form.name" :disabled="true"></el-input>
			</el-form-item>
			<el-form-item label="列表页字段" prop="listfields">
				<el-input v-model.trim="form.listfields" ></el-input>
			</el-form-item>
			<el-form-item label="详述" prop="description">
        <el-input type="textarea" v-model.trim="form.description" ></el-input>
			</el-form-item>
      <el-form-item>
				<el-button type="primary" @click="add()" :loading="isLoading">提交</el-button>
				<el-button @click="goback()">返回</el-button>
			</el-form-item>
		</el-form>
	</div>
</template>
<style>
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
        id: null,
        form: {
          title: '',
          name: '',
          listfields: '*',
          description: ''
        },
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
          ]
        }
      }
    },
    methods: {
      selectCheckbox() {
        let temp = false
        _(this.groupOptions).forEach((res) => {
          if (this.selectedGroups.toString().indexOf(res.else) > -1) {
            this.selectedIds.push(res.id)
          }
        })
        if (this.selectedIds.length) {
          this.form.groups = _.cloneDeep(this.selectedIds)
          temp = true
        }
        this.selectedIds = []
        return temp
      },
      add() {
        this.$refs.form.validate((pass) => {
          if (pass) {
            this.isLoading = !this.isLoading
            if (this.password) {
              this.form.password = this.password
            }
            this.apiPut('admin/module/', this.id, this.form).then((res) => {
              this.handelResponse(res, (data) => {
                _g.toastMsg('success', '修改成功')
                _g.clearVuex('setmodule')
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
      async getCompleteData() {
        this.apiGet('admin/module/' + this.id).then((res) => {
          this.handelResponse(res, (data) => {
            this.form.title = data.title
            this.form.name = data.name
            this.form.listfields = data.listfields
            this.form.description = data.description
          })
        })
      }
    },
    created() {
      this.id = this.$route.params.id
      this.getCompleteData()
    },
    mixins: [http, fomrMixin]
  }
</script>
