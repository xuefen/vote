<?php

set_time_limit(0);
error_reporting(0);

function getRandK($k) {
    $str = "";
    for ($i = 0; $i < $k; $i++)
        $str .= rand(1, 24);
    return $str;
}

//echo json_encode(array('done'=>true,'num'=>2222));exit;
//function m_request() {
$a = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
$error = $num = "";
$map_addr = array(
    'http://tp.lkshijia.com/Vote_Show.asp?InfoId=48a52a51&ClassId=25&Topid=0',//天明
    'http://tp.lkshijia.com/Vote_Show.asp?InfoId=52a52a50&ClassId=28&Topid=0',//M
	'http://tp.lkshijia.com/Vote_Show.asp?InfoId=52a53a51&ClassId=28&Topid=0',//李宁
     'http://tp.lkshijia.com/Vote_Show.asp?InfoId=54a55a51&ClassId=29&Topid=0'
    );
$mate_url = isset($_GET['m'])&&isset($map_addr[$_GET['m']])?$map_addr[$_GET['m']]:$map_addr[0];

//echo json_encode(array('done'=>true,'num'=>'13456'));exit;
for ($k = 0; $k < 7; $k++) {
    //echo $a{$r1}.$a{$r2}.$a{r3}.$a{r4}.$a{r5}.$a{r6};exit;
    $ch = curl_init($mate_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Charset:GBK,utf-8;q=0.7,*;q=0.3",
        "Accept-Encoding:gzip,deflate,sdch",
        "Accept-Language:zh-CN,zh;q=0.8",
        "Connection:keep-alive",
        "Cookie:ASPSESSIONIDCQASSCSQ=DOILDHADNCOAMK" . getRandK(10),
        "Host:tp.lkshijia.com",
        "Referer:http://tp.lkshijia.com/index.asp?Page=9",
        "User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4"
            )
    );
    curl_setopt($ch, CURLOPT_REFERER, 'http://tp.lkshijia.com/index.asp?Page=8');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);

    //代理
    //  curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL,true);
    // 	curl_setopt($ch, CURLOPT_PROXYTYPE,CURLPROXY_HTTP);
    // 	curl_setopt($ch, CURLOPT_PROXYTYPE,4);
    // 	curl_setopt($ch, CURLOPT_PROXYTYPE,5);
    //  curl_setopt($ch, CURLOPT_PROXY, "127.0.0.1");
    //  curl_setopt($ch, CURLOPT_PROXYPORT, "8087");
    //  curl_setopt($ch, CURLOPT_TIMEOUT_MS, 200);
    $data = curl_exec($ch);
    if (!$data) {
        $curl_errno = curl_errno($ch);
        $curl_error = curl_error($ch);
        $error .= "cURL Error ($curl_errno): $curl_error<br/>";
    }
    curl_close($ch);

    if (preg_match('/<font\scolor\=red>(\d+)<\/font>&nbsp;&nbsp;&nbsp;&nbsp;/', $data, $matches)) {
        $num .= $matches[1] . "&nbsp;";
    } elseif ($data && strlen($data) < 200) {
        $error .= iconv("gb2312", "utf-8", $data)."<br/>";
    }else{
        $error .= "unknow error <br/>";
    }
    usleep(10);
}

echo json_encode(array('done' => true, 'num' => $num, 'error' => $error));

