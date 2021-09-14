<? include("../../includes/session.inc.php");
if($loginUname){
 include("../../includes/config.inc.php");

$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	 
	
$vendor = "DELETE FROM poscheduletemp  WHERE posl='$posl'";
//echo $vendor;
 mysql_query($vendor);

$vendor = "DELETE FROM poschedule  WHERE posl='$posl'";
//echo $vendor;
 mysql_query($vendor);

$vendor = "DELETE FROM pordertemp  WHERE posl='$posl'";
//echo $vendor;
mysql_query($vendor);

$vendor = "DELETE FROM porder  WHERE posl='$posl'";
//echo $vendor;
mysql_query($vendor);

$vendor1 = "DELETE FROM popaymentstemp  WHERE posl='$posl'";
//echo $vendor;
 mysql_query($vendor1);
$vendor1 = "DELETE FROM popayments  WHERE posl='$posl'";
//echo $vendor;
 mysql_query($vendor1);

$vendor1 = "DELETE FROM pconditiontemp  WHERE posl='$posl'";
//echo $vendor1;
 mysql_query($vendor1);
$vendor1 = "DELETE FROM pcondition  WHERE posl='$posl'";
//echo $vendor1;
 mysql_query($vendor1);
 
 echo "Purchase Order deleted";
 echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../../index.php?keyword=purchase+order+report&s=$status\">";
}?>
