<?php
namespace app\api\controller;
use com\Sign;
use app\common\controller\Common;
use think\Request;

class Jsdk extends Common
{
	// public function index()
	// {
	// 	$url = input('url');
	// 	$Jsdk = model('Jsdk');
	// 	$Jsdk->appId = 'wxb8fe07bca5490fbf';
	// 	$Jsdk->appSecret = 'd9ca5fffe2e7c665929696a8ee4d9365';
  //   // $Jsdk->appId = 'wx6aa8d9793dc17c68';
  //   // $Jsdk->appSecret = '7a718e830d4b2193e6e635eb0536cf7b';
	// 	$Jsdk->url = $url;
	// 	$signPackage = $Jsdk->getSignPackage();
	// 	//   $this->appId = $appId;
	// 	//   $this->appSecret = $appSecret;
	// 	//   $this->url = $url;
	// 	// $jssdk = new JSSDK("wx6aa8d9793dc17c68", "7a718e830d4b2193e6e635eb0536cf7b",$url);//按照自己的公众号填写
	// 	// $signPackage = $jssdk->GetSignPackage();
	// 	// // var_dump($signPackage);
	// 	$tmp=array ('appId'=>$signPackage["appId"],'timestamp'=>$signPackage["timestamp"],'nonceStr'=>$signPackage["nonceStr"],'signature'=>$signPackage["signature"],'url'=>$signPackage["url"]);
	//
	// 	return resultArray(['data' => $tmp]);
	// 	// $callback = $_GET['callback'];
	// 	// echo $callback.'('.$tmp.')';
	// 	// exit;
	// }

	public function index()
	{
		$url = urldecode(input('url'));
		$Sign = new Sign ();
		$signPackage = $Sign->getsign($url);
		return resultArray(['data' => $signPackage]);
	}
}


?>
