<template>
  <div class="articleinfo">
    <div class="title">
      {{title}}
    </div>
    <div id="meta_content" class="rich_media_meta_list">
      <span class="rich_media_meta rich_media_meta_nickname" id="profileBt"><a href="javascript:void(0);" id="js_name">{{gongzhonghao}}</a></span>
      <em id="publish_time" class="rich_media_meta rich_media_meta_text">{{addtime}}</em>
    </div>
    <div class="content" v-html="content"></div>
  </div>
</template>
<script>
import http from '../../assets/js/http'
export default {
  data: () => ({
    url: null,
    title: '',
    gongzhonghao: '',
    addtime: '',
    content: ''
  }),
  methods: {
    init() {
      let data = {
        url: this.$route.query.url
      }
      this.apiPost('api/articlereadn', data).then((res) => {
        this.title = res.data.title
        this.content = res.data.content
        this.gongzhonghao = res.data.gongzhonghao
        this.addtime = _g.dealArticleTime(res.data.addtime)
        _g.closeGlobalLoading()
      })
    }
  },
  created() {
    this.init()
  },
  mixins: [http]
}
</script>
<style lang="scss">
  .articleinfo{ background-color: #fff; min-height: 100%;  padding: 20px 16px 12px; width: calc(100% - 32px);
    .title{ font-size: 22px; line-height: 1.4; margin-bottom: 14px;  color: #333;}
    .rich_media_meta_list{ margin-bottom: 22px; line-height: 20px;
      em { font-style: normal; font-style: normal; }
      a{ color: #576b95; }
      .rich_media_meta { display: inline-block; vertical-align: middle; margin: 0 10px 10px 0; font-size: 15px; -webkit-tap-highlight-color: rgba(0,0,0,0); }
      .rich_media_meta_text { color: rgba(0,0,0,0.3); }
    }
    .content { overflow: hidden; color: #333; font-size: 17px; word-wrap: break-word; -webkit-hyphens: auto; -ms-hyphens: auto; hyphens: auto; text-align: justify;
      p{ clear: both; min-height: 1em; padding: 0; margin: 0; }
      img{ height: auto!important; max-width: 100%!important; width: auto!important; margin: 0 auto; display: block; }
    }

  }
</style>
