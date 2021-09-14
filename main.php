<?
//main
$loginDesignation = $_SESSION['loginDesignation'];
//echo $loginDesignation;exit; //Manager Planning & Control
echo "This is the main page"; 
 if($loginDesignation=='Task Supervisor'){
   include("./project/taskDailyReport.php");
 }
?>