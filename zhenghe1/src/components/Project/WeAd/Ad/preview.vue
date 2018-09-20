<template>
  <el-dialog ref="dialog" :visible.sync="visible" :close-on-press-escape="true" :close-on-click-modal="true" custom-class="bg-wh tx-c box-shadow-none">
    <img :src="url" class="img">
  </el-dialog>
</template>
<style scope>
.box-shadow-none {
  box-shadow: 0 1px 3px rgba(0,0,0,0);
}
img{ width: 100%; }
</style>
<script>
export default {
  props: ['url'],
  data () {
    return {
      visible: false
    }
  },
  methods: {
    open () {
      this.visible = true
      this.$refs.dialog.open()
    }
  }
}
</script>
