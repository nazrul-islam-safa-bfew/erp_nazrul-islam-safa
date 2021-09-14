<?php
/* ---------------------------
 return Current date as Dhaka
------------------------------*/
function todat(){
//putenv ('TZ=Asia/Dacca');
date_default_timezone_set('Asia/Dhaka');
return date("Y-m-d");
}

function safeQuery($query){
    global $db; 
    //echo $sqlf
    $sqlrunf= mysqli_query($db,$query)
              or die("query failed:"
                     ."<li>errorno=".mysql_errno()
                     ."<li>error=".mysql_error()
                     ."<li>query=".$query
        ) ;
    return $sqlrunf;
    }

?>

