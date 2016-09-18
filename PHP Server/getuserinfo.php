<?php
/**
 * Created by PhpStorm.
 * User: Tian
 * Date: 16/9/3
 * Time: 上午6:32
 */

require_once "getaccesstoken.php";

$access_token = get_access_token();
$user_images = [];

//$openid = "oesaKxEng6Ii6thnM10nJWvsLoWQ";
//$token = "N3qZBGnU0yOn-PB7g-JZl096zWqzGiZPNP4C_L7avR5akrFDumshr4Zwkbtezu0OyEcmbS90oCi83HeuUoj-4W0J7NM581QOePkFNG94QKkSvJ4yq5kfuMdfynSn3N63WFKhAAAQZE";

$openids = get_user_list($access_token);

for ($i=0; $i<3; $i++) {
    $openid = $openids[$i];
    $use_info = get_user_info($access_token, $openid);
    $user_image = substr($use_info, 0, strlen($str)-2)."/132";
    //echo $user_image;
    array_push($user_images, $user_image);
}

//print_r($user_images);
echo json_encode($user_images);

function get_user_info($access_token, $openid) {

    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
    //echo $url;
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
    $user_info_arr = json_decode($output, true);
    //print_r($user_info_arr);
    //echo $user_info_arr["headimgurl"];
    return ($user_info_arr["headimgurl"]);
}

function get_user_list($access_token) {

    $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$access_token;
    //echo $access_token;
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
    $user_list_arr = json_decode($output, true);
    return ($user_list_arr["data"]["openid"]);
    //$access_token = $access_taken_arr["access_token"];
    //print_r($access_taken_arr);
    //return $access_token;
}
