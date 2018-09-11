const commonFn = {
  j2s(obj) {
    return JSON.stringify(obj)
  },
  shallowRefresh(name, id) {
    if (id) {
      router.replace({ path: '/refresh', query: { name: name, id: id }})
    } else {
      router.replace({ path: '/refresh', query: { name: name }})
    }
  },
  closeGlobalLoading() {
    setTimeout(() => {
      store.dispatch('showLoading', false)
    }, 0)
  },
  openGlobalLoading() {
    setTimeout(() => {
      store.dispatch('showLoading', true)
    }, 0)
  },
  cloneJson(obj) {
    return JSON.parse(JSON.stringify(obj))
  },
  toastMsg(type, msg) {
    switch (type) {
      case 'normal':
        bus.$message(msg)
        break
      case 'success':
        bus.$message({
          message: msg,
          type: 'success'
        })
        break
      case 'warning':
        bus.$message({
          message: msg,
          type: 'warning'
        })
        break
      case 'error':
        bus.$message.error(msg)
        break
    }
  },
  clearVuex(cate) {
    store.dispatch(cate, [])
  },
  getHasRule(val) {
    const moduleRule = 'admin'
    let userInfo = Lockr.get('userInfo')
    if (userInfo.id == 1) {
      return true
    } else {
      let authList = moduleRule + Lockr.get('authList')
      return _.includes(authList, val)
    }
  },
  convertDateFromString(dateString) {
    if (dateString) {
      var arr1 = dateString.split(' ')
      var sdate = arr1[0].split('-')
      var date = new Date(sdate[0], sdate[1] - 1, sdate[2])
      return date
    }
  },
  dealArticleTime(ct) {
    let todayDate = Date.parse(new Date()) / 1000
    let showDate = ''
    if (ct >= todayDate) {
      showDate = '今天'
    } else if (ct >= todayDate - 60 * 60 * 24) {
      showDate = '昨天'
    } else if (ct >= todayDate - 2 * 60 * 60 * 24) {
      showDate = '前天'
    } else if (ct >= todayDate - 3 * 60 * 60 * 24) {
      showDate = '3天前'
    } else if (ct >= todayDate - 4 * 60 * 60 * 24) {
      showDate = '4天前'
    } else if (ct >= todayDate - 5 * 60 * 60 * 24) {
      showDate = '5天前'
    } else if (ct >= todayDate - 6 * 60 * 60 * 24) {
      showDate = '6天前'
    } else if (ct >= todayDate - 2 * 7 * 60 * 60 * 24) {
      showDate = '1周前'
    } else if (ct >= yearDate) {
      var tmp = publish_time.split('-')
      showDate = parseInt(tmp[1]) + '月' + parseInt(tmp[2]) + '日'
    }
    return showDate
  }
}

export default commonFn
