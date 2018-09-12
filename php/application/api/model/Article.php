<?php
// +----------------------------------------------------------------------
// | Description: 用户
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\api\model;

use think\Db;
use app\api\model\Common;
use QL\QueryList;
class Article extends Common
{
  protected $name = 'info';

  public function getArticleList($url)
  {
    $rules = [
        'title' => ['.txt-box h3','text'],
        'image' => ['.img-box img','src'],
        'author' => ['.account','text'],
        'info' => ['.txt-info','text'],
        'href' => ['.txt-box h3 a','href']
    ];

    $data = QueryList::Query($url,$rules)->getData(function($item){
      return $item;
    });
    return $data;
  }
  public function createData($param)
  {
    try {
      // 添加文章
			$this->data($param)->allowField(true)->save();
			return $this->id;
		} catch(\Exception $e) {
			$this->error = '添加失败';
			return false;
		}
  }
  public function getArticleById($id='')
  {
    $data = $this->get($id);
    // dump($data);
    if (!$data) {
        $this->error = '暂无此数据';
        return false;
    }
    $url = $data['link'];
    $rules = [
        'title' => ['.rich_media_title','text'],
        'content' => ['.rich_media_content ','html'],
        'gongzhonghao' => ['.rich_media_meta_list a','text'],
        'addtime' => ['.rich_media_meta.rich_media_meta_text','text']
    ];
    $data = QueryList::Query($url,$rules)->data;
    $content = QueryList::Query($url,$rules)->getHtml();
    $data = $data[0];
    preg_match ( '/var\s+msg_cdn_url\s*=\s*"([^\s]*)"/', $content, $result );
    $data ['cover'] = 'http://'.$_SERVER['HTTP_HOST'].'/api/base/imgproxy?1=1&siteid=1&url='.$result [1];
    preg_match ( '/var\s+round_head_img\s*=\s*"([^\s]*)"/', $content, $result );
    $data ['round_head_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/api/base/imgproxy?1=1&siteid=1&url='.$result [1];
    preg_match ( "/s?__biz=(.*)&mid=/i", $url, $result );
    $data ['bizId'] = $result [1]; // 公众号BizId
    preg_match ( '/var\s+msg_desc\s*=\s*"([^\s]*)"/', $content, $result );
    $data ['msg_desc'] = $result [1]; // 公众号文章摘要
    $data['content'] = str_replace("data-src=\"https://mmbiz.qpic.cn/","style=\"width:100%;height:auto\" src=\"http://".$_SERVER['HTTP_HOST']."/api/base/imgproxy?1=1&siteid=1&url=https://mmbiz.qpic.cn/",$data['content']);
    $data['content'] = str_replace("data-src=\"https://v.qq.com/","src=\"https://v.qq.com/",$data['content']);
    $data['content'] = str_replace("data-cover=\"","data-cover=\"http://".$_SERVER['HTTP_HOST']."/api/base/imgproxy?1=1&siteid=1&url=",$data['content']);
    $data['id'] = $id;
    return $data;
  }

  public function getmeArticleById($id='')
  {
    $data = $this->get($id);
    if (!$data) {
        $this->error = '暂无此数据';
        return false;
    }
    return $data;
  }

  public function getArticleByUrl($url='')
  {
    $rules = [
        'title' => ['.rich_media_title','text'],
        'content' => ['.rich_media_content ','html'],
        'gongzhonghao' => ['.rich_media_meta_list a','text'],
        'addtime' => ['.rich_media_meta.rich_media_meta_text','text']
    ];
    $data = QueryList::Query($url,$rules)->data;
    $content = QueryList::Query($url,$rules)->getHtml();
    $data = $data[0];
    preg_match ( '/var\s+ct\s*=\s*"([^\s]*)"/', $content, $result );
    $data ['addtime'] = $result [1]; // 公众号发布的时间戳
    preg_match ( '/var\s+msg_cdn_url\s*=\s*"([^\s]*)"/', $content, $result );
    $data ['cover'] = 'http://'.$_SERVER['HTTP_HOST'].'/api/base/imgproxy?1=1&siteid=1&url='.$result [1];
    preg_match ( '/var\s+round_head_img\s*=\s*"([^\s]*)"/', $content, $result );
    $data ['round_head_img'] = 'http://'.$_SERVER['HTTP_HOST'].'/api/base/imgproxy?1=1&siteid=1&url='.$result [1];
    preg_match ( "/s?__biz=(.*)&mid=/i", $url, $result );
    $data ['bizId'] = $result [1]; // 公众号BizId
    preg_match ( '/var\s+msg_desc\s*=\s*"([^\s]*)"/', $content, $result );
    $data ['msg_desc'] = $result [1]; // 公众号文章摘要
    $data['content'] = str_replace("data-src=\"https://mmbiz.qpic.cn/","style=\"width:100%;height:auto\" src=\"http://".$_SERVER['HTTP_HOST']."/api/base/imgproxy?1=1&siteid=1&url=https://mmbiz.qpic.cn/",$data['content']);
    $data['content'] = str_replace("data-src=\"https://v.qq.com/","src=\"https://v.qq.com/",$data['content']);
    $data['content'] = str_replace("data-cover=\"","data-cover=\"http://".$_SERVER['HTTP_HOST']."/api/base/imgproxy?1=1&siteid=1&url=",$data['content']);
    $data['id'] = $id;
    return $data;
  }
  public function updateArticleById($param, $id='')
  {
    $checkData = $this->get($id);
    if (!$checkData) {
        $this->error = '暂无此数据';
        return false;
    }
    $adinfo = Db::name('ad')->where('id', $checkData['adid'])->find();
    // dump($adinfo);
    $param['adpic'] = $adinfo['ad_img'];
    $param['adpic_one'] = $adinfo['ad_img_one'];
    $param['adpic_two'] = $adinfo['ad_img_two'];
    $param['addtime'] = date('Y-m-d H:i:s',time());
    $param['adlink'] = $adinfo['ad_link'];
    $param['telnum'] = $adinfo['adtelnumber'];
    $param['qqnum'] = $adinfo['adqqnumber'];
    $param['gongzhonghao'] = $adinfo['wechat_name'];
    $param['qrcode'] = $adinfo['erweima'];
    $param['url2'] = $adinfo['ad_link2'];
    $param['quanping'] = $adinfo['quanping'];
    $param['quanping2'] = $adinfo['quanping2'];
    $param['gzurl'] = $adinfo['wechat_url'];
    $param['home_url'] = $adinfo['home_url'];
    $this->startTrans();
    try {
        $this->allowField(true)->save($param, ['id' => $id]);
        // 减文章数 广告数
        Db::name('member')->where('id', $param['userid'])
        ->update([
            'anums'  => Db::raw('anums-1'),
            'adnums' => Db::raw('adnums-1'),
        ]);
        $this->commit();
        return true;
    } catch (\Exception $e) {
        $this->rollback();
        $this->error = '编辑失败';
        return false;
    }
  }

  public function getDataById($id='')
  {
    $data = $this->get($id);
    if (!$data) {
        $this->error = '暂无此数据';
        return false;
    }
    return $data;
  }

  public function addNum($id='')
  {
    $checkData = $this->get($id);
    if (!$checkData) {
        $this->error = '暂无此数据';
        return false;
    }
    $this->startTrans();
    try {
      $this->where('id',$id)->setInc('share_num');
      $this->commit();
      return true;
    } catch (\Exception $e) {
      $this->rollback();
      $this->error = '分享失败';
      return false;
    }
  }
}
