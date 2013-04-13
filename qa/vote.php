<?php
error_reporting(0);
?>
<html>
    <head>
        <title></title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="http://www.ffmore.com/source/jquery-1.6.1.min.js"> </script>
        <!--<script src="http://127.0.0.1/jq.js"> </script>-->
    </head>
    <body>
        <div>
            投票数：
            <div id="calc"></div>
             
            <script>
                var syns = 20;
//                for(var i=0;i<syns;i++){
//                    document.write('<div><font color="red" id="count'+i+'"></font></div>');
//                }
            </script>
        </div>
        <?php if ($_SERVER[HTTP_HOST] != 'www.ffmore.com' && $_SERVER['HTTP_HOST'] != 'test') { ?>
            <iframe src="http://www.ffmore.com/log/vote.php?m=<?php echo $_GET['m'] ? $_GET['m'] : 0 ?>" width="600" height="300" border="noborder"></iframe>
        <?php } ?>
        <div id="error">
        </div>
        <script>
            $(function(){
                var count = 0;
                function addVote(m){
                    var i = parseInt(m);
                    $.ajax({
                        'dataType':'json',
                        'url':'postVote.php?m=<?php echo $_GET['m'] ? $_GET['m'] : 0 ?>&'+i,
                        'type':'get',
                        'success':function(data){
                            var $ = jQuery;
                            if(data.done){
                                count+=1;
                                $("#calc").html(count);
                            }
                            if(data.error){
                                if($("#error div").length>100){
                                    $("#error").html("");
                                }
                                $("<div>"+data.error+"</div>").appendTo("#error");
                            }
                            addVote(i);
                        },
                        'error':function(data){
                            if($("#error div").length>100){
                                $("#error").html("");
                            }
                            $("<div>"+data+"</div>").appendTo("#error");
                            addVote(i);
                        }
                    });
                }
                for(var i=0;i<syns;i++){
                    addVote(i);
                }
            })
        </script>
    </body>
</html>