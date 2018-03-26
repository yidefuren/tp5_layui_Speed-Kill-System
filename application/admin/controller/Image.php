<?php

namespace app\admin\controller;



use think\Exception;

class Image {
    public function upload(){
        $file = request()->file('file');
        $info = $file->validate(['ext'=>'jpg,png'])->move( 'uploads');
        if($info){
            // 成功上传后 获取上传信息
            return json(['code' => 0, 'img'=> $info->getSaveName()]);
        }else{
            throw new Exception($file->getError());
        }
    }

    public function test(){
        echo 'aa';
    }
}