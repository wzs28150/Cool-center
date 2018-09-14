<template>
	<div></div>
</template>
<script>
export default {
  created() {
    // console.log(this.$route.query.name)
    document.title = '刷新中...'
    if (this.$route.query.name) {
      if (this.$route.query.id) {
        router.replace({ name: this.$route.query.name, params: { id: this.$route.query.id }})
      } else {
        router.replace({ name: this.$route.query.name })
      }
    } else {
      console.log('refresh fail')
    }
  }
}
</script>
