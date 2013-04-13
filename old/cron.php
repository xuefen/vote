<?php
if(isset($_GET['stop'])){
    file_put_contents("stop.txt", "isstoped");
    exit(0);
}
set_time_limit(0);
ignore_user_abort();
function getRandK($k) {
    $map = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    for ($str = "",$i = 0; $i < $k; $i++)
        $str .= $map[rand(0, 25)];
    return $str;
}
while(true){
    if(is_file('stop.txt')){
        exit(0);
    }
    $ch = curl_init("http://tp.lkshijia.com/Vote_Show.asp?InfoId=52a52a50&ClassId=28&Topid=0");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        "Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
        "Accept-Charset:GBK,utf-8;q=0.7,*;q=0.3",
        "Accept-Encoding:gzip,deflate,sdch",
        "Accept-Language:zh-CN,zh;q=0.8",
        "Connection:keep-alive",
        "Cookie:ASPSESSIONIDCQASSCSQ=DOILDHADNCO" . getRandK(13),
        "Host:tp.lkshijia.com",
        "Referer:http://tp.lkshijia.com/index.asp?Page=9",
        "User-Agent:Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.4 (KHTML, like Gecko) Chrome/22.0.1229.94 Safari/537.4"
            )
    );
    curl_setopt($ch, CURLOPT_REFERER, 'http://tp.lkshijia.com/index.asp?Page=8');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
 
    $data = curl_exec($ch);
    if ($data) {
        if (preg_match('/<font\scolor\=red>(\d+)<\/font>&nbsp;&nbsp;&nbsp;&nbsp;/', $data, $matches)) {
             file_put_contents("num.txt", $matches[1]);
        }
    }
    curl_close($ch);
    usleep(10);
}