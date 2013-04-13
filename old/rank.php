<meta charset="utf-8"/>
<?php
$str = file_get_contents("http://tp.lkshijia.com/index.asp?Page=9");
if(preg_match('/<td\salign\=\"left\">.*(<table[^>]+>.*<\/table>)/', $str,$matches)){
     echo iconv("gb2312","utf-8",$matches[1]);
}

