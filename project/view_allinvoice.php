<? 
/*
if($d){
include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	$sql="DELETE from invoice where invoiceNo='$invoiceNo'";
  // echo $sql;
   mysql_query($sql);

	$sql="DELETE from invoiceadv where invoiceNo='$invoiceNo'";
  // echo $sql;
   mysql_query($sql);

	$sql="DELETE from invoicedetail where invoiceNo='$invoiceNo'";
  // echo $sql;
   mysql_query($sql);


 echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=./index.php?keyword=view+invoice\">";
 exit;
}
*/
?>
<form>
INVOICE STATUS:
<input type="radio" name="status" value="1" <? if($s==1) echo ' CHECKED ';?> onclick="window.location.href='index.php?keyword=view+all+invoice&s=1'" />Submitted
<input type="radio" name="status" value="2" <? if($s==2) echo ' CHECKED ';?> onclick="window.location.href='index.php?keyword=view+all+invoice&s=2'"/>Complete
<input type="radio" name="status" value="3" <? if($s==3) echo ' CHECKED ';?> onclick="window.location.href='index.php?keyword=view+all+invoice&s=3'"  />All
</form>
<? 
if($s==1) echo "All Submitted Invoice List<br> ";
if($s==2) echo "All Receive Complete Invoice List<br> ";
if($s==3) echo "All Invoice List<br> ";
?>
<table align="center" width="95%" class="vendorTable" border="1">
 <tr>
  <td class="vendorAlertHd_small">Invoice No</td>
   <td class="vendorAlertHd_small" width="100">Invoice Date</td>   
   <td class="vendorAlertHd_small">Invoice Type</td>   
   <td class="vendorAlertHd_small">Invoice Amount</td>
   <td class="vendorAlertHd_small">Retention</td>   
   <td class="vendorAlertHd_small">Tax</td>   
   <td class="vendorAlertHd_small">VAT</td>   
   <td class="vendorAlertHd_small">Net Receivable</td>   
 </tr>
 
<? include("./includes/config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);
	
	
	$sql="SELECT * from project  ORDER by pcode DESC";
	//echo $sql;
	$sqlQ1=mysql_query($sql);
	while($p=mysql_fetch_array($sqlQ1)){

	$sql="SELECT * from invoice WHERE invoiceLocation ='$p[pcode]'" ;
	//echo $sql."<br>";
	if($s!=3)$sql.="  AND invoiceStatus='$s' ";
	$sql.=" ORDER by invoiceLocation,invoiceDate ASC";
	 echo "<br>$sql<br>";
	$sqlQ=mysql_query($sql);	
	$r=mysql_num_rows($sqlQ);
	if($r<=0) continue;
	?>	
	<tr class="vendorAlertHdt" >
		<td colspan="9" align="left"><? echo '['.$p[pcode].'] '.$p[pname];?></td>
	</tr>
	<? 
	while($in=mysql_fetch_array($sqlQ)){
	?>
	 <tr <? if($in[invoiceNo]==$invoiceNo) echo "bgcolor=#FFFFCC";?> >
	   <td><? if($in[invoiceType]==2){?><a href="./index.php?keyword=view+all+invoice&s=<? echo $s;?>&invoiceNo=<? echo $in[invoiceNo];?>"><? echo $in[invoiceNo];?></a><? }
	    else { echo $in[invoiceNo];}?>
		<? if($in[invoiceStatus]=='2') echo "<font color='#009933'>[Complete ".invoiceCompleteDate($in[invoiceNo]).' ]</font>';?> 
		</td>	   
	   <td align="center"><? echo myDate($in[invoiceDate]);?></td>	   		
	   <td align="right"><? echo viewInvoiceType($in[invoiceType]);?></td>	   
	   <td align="right"><? echo number_format($in[subInvoice],2);?></td>	   
	   <td align="right"><font class="outs">(<? echo number_format($in[retention],2);?>)</font></td>	  
	   <td align="right"><font class="outs">(<? echo number_format($in[tax],2);?>)</font></td>	
	   <td align="right"><font class="outs">(<? echo number_format($in[vat],2);?>)</font></td>	   	   	
	   <td align="right"><? echo number_format($in[invoiceAmount],2);?></td>	      
	 </tr>
	 <tr>
	 <? $total+=$in[invoiceAmount];} //while in?>
<? if($total){?>	 
<tr class="vendorAlertHd_lite" >
 <td colspan="9" align="right">Total <? echo number_format($total,2); $total=0;?></td>
</tr>
<tr>
 <td colspan="9" align="right" height="15"></td>
</tr>

	 <? }//total?>
<?	 }//while p?>

</table>


<br><br><br>
<? if($invoiceNo) {?>
<form name="as" action="./project/invoice.sql.php?invoiceNo=<? echo $invoiceNo?>" method="post">
<table width="100%" border="1" bordercolor="#999999" cellpadding="0"  cellspacing="0" style="border-collapse:collapse">
<tr bgcolor="#DDDDDD">
  <th height="30"> IOW CODE</th>
  <th> Description</th>  
  <th> Total Qty</th>    
  <th> Invoice Qty</th>    
  <th> Rate</th>    
  <th> Amount</th>    
</tr>
<?

include("config.inc.php");
$db = mysql_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS);
	mysql_select_db($SESS_DBNAME,$db);

	$sql="SELECT * FROM `invoicedetail` WHERE invoicedetail.invoiceNo='$invoiceNo' ";
	//echo $sql;
$sqlrunp= mysql_query($sql);
$i=1;
while($in=mysql_fetch_array($sqlrunp)){
$sql1="SELECT * FROM iow WHERE iowId=$in[iowId]";
$sql1q=mysql_query($sql1);
$iow=mysql_fetch_array($sql1q);
?>
<tr>
  <td bgcolor="#eeeeee"> <? echo $iow[iowCode];?></td>
  <td> <? echo $iow[iowDes];?></td>

  <td align="right"> <? 
  if($iow[iowUnit]!='L.S' AND $iow[iowUnit]!='LS' AND $iow[iowUnit]!='l.s' AND $iow[iowUnit]!='l.s')   
   {echo $iow[iowQty]; }?>
    <? echo $iow[iowUnit];?></td>
  <td align="right"> <? echo invoicedQty($iow[iowId])?></td>    
  <td align="right"> <? echo number_format($iow[iowPrice],2);?> </td>
  <td align="right"> <?  $amount=$in[qty]*$in[rate];
  echo number_format($amount,2);?></td>    
</tr>
<? $i++;
$totalAmount=$totalAmount+$amount;
$amount=0;
}?>
<tr>
 <td align="right" colspan="7" bgcolor="#FFCCCC"><? echo number_format($totalAmount,2);?></td>
</tr>
</table>
</form>
<? }?>
<table>
  <tr> 
    <td>Sales Code:</td>
	<td>6100000 INCOME FROM COMPLETED JOBS</td>
  </tr>
  <tr> 
    <td>Accounts Receivable Code:</td>
	<td>5000000 SUNDRY DEBTORS</td>
  </tr>

</table>
