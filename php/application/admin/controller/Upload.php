<?php
// +----------------------------------------------------------------------
// | Description: 图片上传
// +----------------------------------------------------------------------
// | Author: linchuangbin <linchuangbin@honraytech.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Request;
use think\Controller;

class Upload extends Controller
{
    public function index()
    {

        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: POST');
        header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
        $file = request()->file('file');
        // $param = input('item');
        $item = input('item');
        if (!$file) {
        	return resultArray(['error' => '请上传文件']);
        }

        $info = $file->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . DS . 'public/uploads');
        if ($info) {
            $data['file'] = 'uploads'. DS .$info->getSaveName();
            $data['item'] = $item;
            return resultArray(['data' => $data ]);
        }

        return resultArray(['error' =>  $file->getError()]);
    }
}
