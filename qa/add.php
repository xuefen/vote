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
            <div id="calc"></div>
            当前人气数：
            <script>
                var syns = 10;
                for(var i=0;i<syns;i++){
                    document.write('<div><font color="red" id="count'+i+'"></font></div>');
                }
            </script>
        </div>
    
        <div id="error">
        </div>
        <script>
            $(function(){
                var count = 0;
                function addVote(m){
                    var i = parseInt(m);
                    $.ajax({
                        'dataType':'json',
                        'url':'qa.php?'+i,
                        'type':'get',
                        'success':function(data){
                            var $ = jQuery;
                            if(data.done){
                                count+=1;
                                $("#calc").html(count);
                                if(data.num)
                                    $("#count"+i).html(data.num);
                                
                            }
                            if(data.error){
                                if($("#error div").length>10){
                                    $("#error").html("");
                                }
                                 $("<div>"+data.error+"</div>").appendTo("#error");
                            }
                            //setTimeout(function(){
                            addVote(i);
                            //},1000)
                        },
                        'error':function(data){
                            if($("#error div").length>10){
                                $("#error").html("");
                            }
                            $("<div>"+data+"</div>").appendTo("#error");
                            //setTimeout(function(){
                            addVote(i);
                            //},1000)
                        }
                    });
                }
                for(var i=0;i<syns;i++){
                    //setTimeout(function(){
                    addVote(i);
                    //},i*1000)
                }
            })
        </script>
    </body>
</html>