<? include("../includes/session.inc.php");
if($loginUname){?>
 <? 
 include("../includes/config.inc.php");
if($d){
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
$sql=mysql_query("SELECT * FROM porder WHERE posl='$posl'");
while($s=mysql_fetch_array($sql)){
$vendor = "DELETE FROM poschedule  WHERE poid='$s[poid]'";
//echo $vendor;
$sqlr= mysql_query($vendor);

}	
$vendor = "DELETE FROM porder  WHERE posl='$posl'";
//echo $vendor;
$sqlr= mysql_query($vendor);

$vendor1 = "DELETE FROM popayments  WHERE posl='$posl'";
//echo $vendor;
$sqlr1= mysql_query($vendor1);

$vendor1 = "DELETE FROM pcondition  WHERE posl='$posl'";
//echo $vendor1;
$sqlr1= mysql_query($vendor1);
}
else{  
include("../includes/myFunction.php");

$todat=todat();
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
$vendor = "UPDATE porder SET status='1',dat='$todat' WHERE posl='$posl'";
//echo $vendor;
$sqlr= mysql_query($vendor);

$po="SELECT sum(qty*rate) as amount from porder where posl = '$posl'";
$poq=mysql_query($po);
$por=mysql_fetch_array($poq);
$totalAmount=ceil($por[amount]);
	$sqlpo = "INSERT INTO popayments(popID, posl, acctPayable,totalAmount,receiveAmount, paidAmount)"."
	 VALUES ('','$posl','2400000','$totalAmount','','')";
	//echo $sqlpo;
	$sqlQuerypo = mysql_query($sqlpo);

}
echo "Your Information is Updating.......";
echo"<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=purchase+order+report&s=0\">";
}
?>
