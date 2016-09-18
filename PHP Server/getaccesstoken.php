<?php
/*
获取微信access_token
*/

//$appid = "wx5d649f3295ce323a";
//$app_secret = "a17ecddd3fb0699814fce90fa6376b8e";

define('appid', 'wx5d649f3295ce323a');
define('app_secret', 'a17ecddd3fb0699814fce90fa6376b8e');

//$access_taken_json = file_get_contents($url);
//$access_taken_arr = json_decode($access_taken_json, true);
//$access_token = $access_taken_arr["access_token"];
//print_r($access_taken_arr);
//echo $access_token;


function get_access_token() {

    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".appid."&secret=".app_secret;
    //初始化
    $ch = curl_init();
    //设置选项，包括URL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_USERAGENT, 1);
    curl_setopt($ch, CURLOPT_ENCODING, "gzip");
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    //执行并获取HTML文档内容
    $output = curl_exec($ch);
    //释放curl句柄
    curl_close($ch);
    //打印获得的数据
    //print_r($output);
    $access_taken_arr = json_decode($output, true);
    $access_token = $access_taken_arr["access_token"];
    //print_r($access_taken_arr);
    return $access_token;
}


