<?php
set_time_limit(0);
error_reporting(0);
$map_addr = array(
    '48a52a51',//天明
    '55a52a53',//M
    );
$vid = isset($_GET['m'])&&isset($map_addr[$_GET['m']])?$map_addr[$_GET['m']]:$map_addr[0];

$url = 'http://www.lkshijia.com/Radio&vote.asp?VoTeid='.$vid;

$ques = include('ques_arr.php');
$ques_ans = $ques[rand(0, 49)];unset($ques);
$url .= '&wencheck='.urlencode($ques_ans[1]);
$url .= '&wendan='.urlencode($ques_ans[0]);
$url .= '&submit='.urlencode("提+交");
//echo $url;exit;
$ch = curl_init($url);
$agent_arr = array(
    'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E)',
    'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4',
    'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E)',
    'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4',
    'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E)',
    'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4',
    'Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 6.1; Trident/5.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; InfoPath.3; .NET4.0C; .NET4.0E)',
    'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4',
    'Mozilla/5.0 (Windows NT 6.1; rv:15.0) Gecko/20100101 Firefox/15.0.1 FirePHP/0.7.1'
    );
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
    "Accept-Charset:GBK,utf-8;q=0.7,*;q=0.3",
    "Accept-Encoding:gzip,deflate,sdch",
    "Accept-Language:zh-CN,zh;q=0.8",
    "Connection:keep-alive",
    "Cookie:ASPSESSIONIDCQASSCSQ=" . getRandK(24)."; ZhruNum=2; ZhiRuiId=327; ZhiRuiTime=2012%2D11%2D16+11%3A19%3A04",
    "Host:www.lkshijia.com",
    "Referer:http://www.lkshijia.com/Radio&vote.asp?VoTeid=".$vid,
    "User-Agent:".$agent_arr[rand(0, 8)],
    "X-FORWARDED-FOR:" . getRandIp(),
    "REMOTE_ADDR:" . getRandIp(),
    'CLIENT-IP:' . getRandIp(),//'CLIENT_IP:203.129.72.215'
     )
);

curl_setopt($ch, CURLOPT_REFERER, 'http://www.lkshijia.com/Radio&vote.asp?VoTeid='.$vid);
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
    //echo $data;exit;
    if(preg_match("/投票成功/", $data)){
        echo json_encode(array('done'=>true));
    }else{
        if(preg_match("/请回答正确的答/", $data)){
            file_put_contents("b.txt", file_get_contents("b.txt").'|'.$ques_ans[0]);
        }
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