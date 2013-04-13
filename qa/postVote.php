<?php
set_time_limit(0);
error_reporting(0);
$map_addr = array(
    '48a52a51',//天明
    '55a52a53',//M
    );
$vid = isset($_GET['m'])&&isset($map_addr[$_GET['m']])?$map_addr[$_GET['m']]:$map_addr[0];

$url = 'http://tp.lkshijia.com/Radio&vote.asp?VoTeid='.$vid;

$ques = include('ques_arr.php');
$ques_ans = $ques[rand(0, 49)];unset($ques);
$url .= '&wencheck='.urlencode($ques_ans[1]);
$url .= '&wendan='.urlencode($ques_ans[0]);
$url .= '&submit='.urlencode("提+交");

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Charset:GBK,utf-8;q=0.7,*;q=0.3",
    "Accept-Encoding:gzip,deflate,sdch",
    "Accept-Language:zh-CN,zh;q=0.8",
    "Connection:keep-alive",
    "Cookie:ASPSESSIONIDCQASSCSQ=" . getRandK(24),
    "Host:tp.lkshijia.com",
    "Referer:http://tp.lkshijia.com/index.asp?Page=4",
    "User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4",
    "X-FORWARDED-FOR:" . getRandIp(),
    "REMOTE_ADDR:" . getRandIp(),
    'CLIENT-IP:' . getRandIp(),//'CLIENT_IP:203.129.72.215'
     )
);

curl_setopt($ch, CURLOPT_REFERER, 'http://tp.lkshijia.com/index.asp?Page=4');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

$data = curl_exec($ch);
if (!$data) {
    $curl_errno = curl_errno($ch);
    $curl_error = curl_error($ch);
    $error = "cURL Error ($curl_errno): $curl_error<br/>";
    echo json_encode(array('done'=>false,'error'=>$error));
} else {
    $data = iconv("gb2312", "utf-8", $data);
    if(preg_match("/投票成功/", $data)){
        echo json_encode(array('done'=>true));
    }else{
        echo json_encode(array('done'=>false,'error'=> htmlspecialchars($data)));
    }
}
curl_close($ch);

function getRandK($k) {
    $str = "";
    $map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($i = 0; $i < $k; $i++)
        $str .= $map[rand(0, 25)];
    return $str;
}

function getRandIp() {
    $ips_map = array(
                array('61.', array(162, 191)),
                array('61.', array(48, 55)),
                array('58.', array(192, 223)),
                array('58.', array(240, 254)),
                array('59.', array(32, 83)),
                array('60.', array(160, 191)),
                array('60.', array(194, 254)),
                array('60.', array(200, 223)),
            );
    $rm = $ips_map[rand(0, 7)];
    return $rm[0] . rand($rm[1][0],$rm[1][1]) . "." . rand(1, 254) . '.' . rand(1, 254);
}