<SCRIPT LANGUAGE="JavaScript" SRC="./js/CalendarPopup.js"></SCRIPT>
<SCRIPT language=JavaScript>document.write(getCalendarStyles());</SCRIPT>
<div class="dialog">
<form name="gl" action="./index.php?keyword=htrial+balance" method="post">

<table  width="600" align="center" border="0" class="blue" >
 <tr bgcolor="#CCCCFF">
 <td align="right" valign="top" height="30" colspan="4"><font class='englishheadblack'>trial balance</font></td>
</tr>
 <tr>
 	<SCRIPT LANGUAGE="JavaScript">
	var now = new Date();
	var cal = new CalendarPopup("testdiv1");
    	cal.showNavigationDropdowns();
		cal.setWeekStartDay(6); // week is Monday - Sunday
		//cal.addDisabledDates(null,formatDate(now,"yyyy-MM-dd"));
		cal.setCssPrefix("TEST");
		cal.offsetX = 0;
		cal.offsetY = 0;

	</SCRIPT>

  <tr>
	   <td >Project: </td>
	   <td colspan="3">
 <select name="pcode" size="1">
	  <option value="0">Select Project</option>  
	  <option value="1">ALL BFEW</option>  	  
	<? 
	include("config.inc.php");
	$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
		
	$sqlp = "SELECT * from `project` order by pcode ASC";
	//echo $sqlp;
	$sqlrunp= mysqli_query($db, $sqlp);
	
	 while($typel= mysqli_fetch_array($sqlrunp))
	{
	 echo "<option value='".$typel[pcode]."'";
	 if($pcode==$typel[pcode]) echo "SELECTED";
	 echo ">$typel[pcode]--$typel[pname]</option>  ";
	 }
	 ?>
	</select>
	</td>
	</tr>
    <td>From </td>
      <td><input type="text" maxlength="10" name="fromDate" value="<? echo $fromDate;?>" > <a id="anchor" href="#"
   onClick="cal.select(document.forms['gl'].fromDate,'anchor','dd/MM/yyyy'); return false;"
   name="anchor" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
    <td>To </td>
      <td><input type="text" maxlength="10" name="toDate" value="<? echo $toDate;?>" > <a id="anchor2" href="#"
   onClick="cal.select(document.forms['gl'].toDate,'anchor2','dd/MM/yyyy'); return false;"
   name="anchor2" ><img src="./images/b_calendar.png" alt="calender" border="0"></a>
      </td>
 </tr>
 <tr><td colspan="4" align="center"><input type="button" name="go" value="Go" onClick="gl.submit();"></td></tr>
</table>

<input type="hidden" name="ck" value="1">
</form>
</div>
<br>
<br>
<br>
<? if($pcode=='1') include('htrialBalanceAll.php');
else {?>

<?  if($fromDate AND $toDate){?>

<table  align="center" width="98%" class="ablue" border="1">
 <tr >
	<td class="ablueAlertHd_small">Account ID</td>   
	<td class="ablueAlertHd_small">Description</td>  
	<td class="ablueAlertHd_small">Account Type</td>       
	<td class="ablueAlertHd_small">Debit Amount</td>   
	<td class="ablueAlertHd_small">Credit Amount</td> 
 </tr>
 <? 
 $fromDate=formatDate($fromDate,'Y-m-j');
 $toDate=formatDate($toDate,'Y-m-j');  
 $db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
 ?>
 
<?  $sql="select * from `accounts` ORDER by accountID ASC";
$i=1;
//echo $sql;
$sqlq=mysqli_query($db, $sql);
while($re=mysqli_fetch_array($sqlq)){
if($re[accountID]=='2401000'){
  $mat_totalPaidAmount =mat_vanPayment($fromDate,$toDate,$pcode);
  $mat_TotalReceive= mat_po_Receive($fromDate,$toDate,$pcode);  
  $balance=$mat_TotalReceive-$mat_totalPaidAmount;
//  echo "<br>**$balance=$mat_TotalReceive-$mat_totalPaidAmount;**<br>";
  }//2401000
elseif($re[accountID]=='2402000'){
  $balance= eqCurrentPayable($pcode,$fromDate,$toDate);
//  echo "$balance<br>";
//  exit;
 }
elseif($re[accountID]=='2403000'){
   $sub_totalPaidAmount =sub_vanPayment($fromDate,$toDate,$pcode);
   $sub_TotalReceive=sub_po_Receive($fromDate,$toDate,$pcode);  
   $balance=$sub_TotalReceive-$sub_totalPaidAmount;
 } 
elseif($re[accountID]=='2404000'){ $balance=wagesPayable($pcode,$fromDate,$toDate); }
elseif($re[accountID]=='2405000'){;  }
elseif($re[accountID]=='3301000' AND $pcode=='004'){ $balance =total_equipment_value($fromDate,$toDate,$pcode); }//3301000
elseif($re[accountID]=='3601000' AND $pcode=='000'){ $balance =total_furniture_value($fromDate,$toDate,$pcode); }//3601000
elseif($re[accountID]=='3900000' AND $pcode=='000'){ $balance =total_tools_value($fromDate,$toDate,$pcode);  }//3904000
elseif($re[accountID]=='3804000'){  $balance =total_officetools_value($fromDate,$toDate,$pcode); }//3804000  

elseif($re[accountID]=='4701000'){  $balance=store_stock_rate($fromDate,$toDate,$pcode);  }
elseif($re[accountID]=='4800000') $balance=current_Inventory_intransit($fromDate,$toDate,$pcode);
elseif($re[accountID]=='5000000') $balance=accountReceivable($pcode,$fromDate,$toDate);
elseif($re[accountID]=='5501000'){	$balance=balance_hcash($pcode, $fromDate,$toDate);	}
elseif($re[accountID]=='5502000'){	$balance=cashonHand($pcode,$fromDate,$toDate,'2');	}
elseif($re[accountID]>='5101001' AND $re[accountID]<='5301000'){
	if($re[accountID]=='5201000' AND $pcode=='000'){ 	$balance=salaryAdvance_balance($fromDate,$toDate);}
	else{  $balance=balance_t4($pcode,$re[accountID],$fromDate,$toDate);}
}
elseif($re[accountID]>='5601001' AND $re[accountID]<='5609011'){$balance=balance_bank($pcode,$re[accountID],$fromDate,$toDate);}

elseif($re[accountID]=='6100000'){ 	$balance=completedAmount($pcode,$fromDate,$toDate);} 
elseif($re[accountID]=='6425000'){ 	$balance=balance_6425000($pcode,$fromDate,$toDate); } 
elseif($re[accountID]=='6430000'){ 	$balance=balance_6430000($pcode,$fromDate,$toDate); } 
elseif($re[accountID]=='6435000'){ 	$balance=balance_6435000($pcode,$fromDate,$toDate); } 
elseif($re[accountID]=='6801000'){$balance=total_mat_directissueAmount_date($pcode, $fromDate,$toDate); }
elseif($re[accountID]=='6802000') {  $balance=total_eq_direct_issueAmount_date($pcode, $fromDate,$toDate);
}
elseif($re[accountID]=='6803000'){	$balance=sub_po_directReceive($pcode,$fromDate,$toDate); }  
elseif($re[accountID]=='6804000'){ $balance=wagesCostofsales($pcode,$fromDate,$toDate);}  
elseif($re[accountID]=='6901000'){ 	$balance=total_salaryAmount_date($pcode, $fromDate,$toDate);}  
elseif($re[accountID]=='6902000'){ 	$balance=$wages_TotalReceive-$wagesDirectTotalCost; }  
elseif($re[accountID]=='6902010'){   $balance=total_mat_indirectissueAmount_date($pcode, $fromDate,$toDate); }  
elseif($re[accountID]=='6903000'){   $balance=sub_po_indirectReceive($pcode,$fromDate,$toDate); } 
elseif($re[accountID]=='6903010'){ $balance=0;  }
else {  $balance=total_exAmount_date($pcode, $fromDate,$toDate,$re[accountID]);}  

//echo $re[accountID].'='.$balance.'<br>';	

if($re[accountType]=='0' OR $re[accountType]=='1' OR $re[accountType]=='2' OR $re[accountType]=='3' OR $re[accountType]=='4' OR $re[accountType]=='5' OR $re[accountType]=='23' OR $re[accountType]=='24'){
if($balance>0)$drAmount1=abs($balance);
	  else $crAmount1=abs($balance);	
}
else if($re[accountType]=='5' OR $re[accountType]=='8' OR $re[accountType]=='10' OR $re[accountType]=='21' ){
	if($balance<0)$drAmount1=abs($balance);
	  else $crAmount1=$balance;
}
?>
<tr >
	<td><? echo "$re[accountID]";?></td>
	<td><? echo accountName($re[accountID]);?></td>
	<td><? echo viewAccountType($re[accountID]);?></td> 
	<td align="right"><? if($drAmount1){echo number_format($drAmount1,2); $drAmount+=$drAmount1;$drAmount1=0; $balance=0;}?></td>
	<td align='right'><? if($crAmount1){echo number_format($crAmount1,2); $crAmount+=$crAmount1;$crAmount1=0; $balance=0;}?></td>
</tr>

<? }//while?>

<tr  class="ablueAlertHd_small">
 <td colspan="3"></td>
 <td align="right"><?  echo number_format($drAmount,2);?></td>
 <td align="right"><? echo number_format($crAmount,2);?></td>
</tr>  
</table>

<? }?>
<? }//else pcode?>
<div id=testdiv1 style="VISIBILITY: hidden; POSITION: absolute; BACKGROUND-COLOR: white; layer-background-color: white"></div>