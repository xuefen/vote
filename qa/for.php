<?php
$questions = include('question.php');
$a = array();
foreach ($questions as $k=>$v){
    $a[] = array($k,$v);
}
$qa = file_put_contents("ques_arr.php", "<?php\nreturn ".  var_export($a,TRUE).";");