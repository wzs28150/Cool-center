<template>
  <div class="me">
    <div class="info">
      <div class="photo">
        <i class="fa fa-user"></i>
      </div>
      <div class="name">
        {{name}}
      </div>
      <div class="time">
        剩余文章:{{anums}}&nbsp;&nbsp;&nbsp;&nbsp;天数:{{beizhu1}}天
      </div>
    </div>
    <div class="list">
      <ul>
        <li><router-link to="/me/list">我发布的 <i class="el-icon-arrow-right"></i></router-link></li>
        <!-- <li><router-link to="/foo">系统介绍 <i class="el-icon-arrow-right"></i></router-link></li>
        <li><router-link to="/foo">修改密码 <i class="el-icon-arrow-right"></i></router-link></li> -->
        <li><router-link to="/foo">联系客服 <i class="el-icon-arrow-right"></i></router-link></li>
        <li><a @click="logout">退出登录 <i class="el-icon-arrow-right"></i></a></li>
      </ul>
    </div>
  </div>
</template>
<script>
import http from '../../assets/js/http'
export default {
  data() {
    return {
      name: '',
      anums: 0,
      beizhu1: null
    }
  },
  methods: {
    logout() {
      this.$confirm('确认退出吗?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消'
      }).then(() => {
        _g.openGlobalLoading()
        let data = {
          authkey: Lockr.get('authKey'),
          sessionId: Lockr.get('sessionId')
        }
        this.apiPost('admin/base/logout', data).then((res) => {
          _g.closeGlobalLoading()
          this.handelResponse(res, (data) => {
            Lockr.rm('menus')
            Lockr.rm('authKey')
            Lockr.rm('rememberKey')
            Lockr.rm('authList')
            Lockr.rm('userInfo')
            Lockr.rm('sessionId')
            Cookies.remove('rememberPwd')
            _g.toastMsg('success', '退出成功')
            setTimeout(() => {
              router.replace('/')
            }, 1500)
          })
        })
      }).catch(() => {

      })
    }
  },
  created() {
    _g.closeGlobalLoading()
    let info = Lockr.get('userInfo')
    this.name = info.username
    this.anums = info.anums
    let date2 = _g.convertDateFromString(info.beizhu1)
    let date1 = new Date()
    let date3 = date2.getTime() - date1.getTime()
    this.beizhu1 = Math.floor(date3 / (24 * 3600 * 1000))
    // console.log(date1)
  },
  mixins: [http]
}
</script>
<style lang="scss" scoped>
  .me{
    .info{ background-color: #409eff; padding: 20px 0; color: #fff; text-align: center;
     .photo{ width: 60px; height: 60px; background-color: #fff;  border-radius: 100%;  text-align: center;  line-height: 60px; margin: 0 auto;  color: #ccc; font-size: 20px; margin-bottom: 10px; box-shadow: 0 0 5px #eee; }
     .name{ text-align: center; font-size: 18px; letter-spacing: 2px; }
     .time{ font-size: 14px; font-weight: normal; }
    }
    .list{
      ul{
        li{ background-color: #fff; line-height: 3em; height: 3em;  margin-bottom: 1px;
          a{ display: block; padding: 0 15px; color: #333; font-weight: normal;
            i{ float: right; display: block; line-height: 3em; color: #ccc; }
          }
        }
      }
    }
  }
</style>
