<?
include("../includes/session.inc.php");
include("../includes/config.inc.php");
include_once("../includes/myFunction.php");
include_once("../includes/myFunction1.php");
include_once("../includes/accFunction.php");
include_once("../includes/empFunction.inc.php");
include_once("../includes/eqFunction.inc.php");
include_once("../includes/subFunction.inc.php");
include_once("../includes/matFunction.inc.php");
include_once('../includes/vendoreFunction.inc.php');

// echo "<center><h1>Under construction</h1></center>";
// print_r($_POST);
// exit;

$toDate=todat();
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);

if (!$db){
   die('Please try later..' );
}


mysqli_query($db, "SET AUTOCOMMIT=0");
mysqli_query($db, "START TRANSACTION");

//$hcash_balance=balance_hcash('000', '2006-07-01',$toDate);
/*
$scash_balance=cashonHand($exfor,'2006-07-01',$toDate,'2');
//echo "$exfor ==$toDate==$scash_balance";
if($scash_balance<=0) {
echo wornMsg("No balance in site office cash!");
echo "<a href='../index.php?keyword=site+payments&w=$w'><--Go Back</a>";
exit;
}

if($scash_balance<=0) {

//echo "$hcash_balance < $total";
echo wornMsg( "STOP!!! You cannot spend from negative balance");
 echo "<a href='../index.php?keyword=site+payments&w=$w'><--Go Back</a>";
 exit;
 }
*/
?>
<? 
$paymentSL=generatePaymentSL($w,$loginProject,$paymentDate);

?>
<?
$paymentDate1=formatDate($paymentDate,"Y-m-d");
$db = mysqli_connect($SESS_DBHOST, $SESS_DBUSER,$SESS_DBPASS,$SESS_DBNAME);
	
$edate = formatDate($edate,"Y-m-d");
if($POpayment){
for($i=1;$i<$n;$i++){
//$remainAmount=popaymentReamin(${posl.$i});

if($loginProject!='000'){${remainAmount.$i}= ${currentPayable.$i};}

  if(${amountPaid.$i}>0 AND ${amountPaid.$i}<=${remainAmount.$i}){

	 $amount=0;
   $reff=${posl.$i};
   $temp=vendorName($vid);
   $paidTo=$temp[vname];
	 //$paidTo=$vid;
   $amount=${amountPaid.$i};
		
    $sqlv="INSERT into vendorpayment (vpid,vid,paymentSL,posl,paidAmount,paymentDate) ".
	" VALUES('',$vid,'$paymentSL','${posl.$i}','$amount','$paymentDate1')";
// 	echo '<br>'.$sqlv.'******<br>';
// 		exit;
	mysqli_query($db, $sqlv);
	$ro=mysqli_affected_rows($db);
	if($ro>0){
	$sql1 = "UPDATE popayments SET paidAmount=paidAmount+$amount WHERE posl='${posl.$i}'";
	//echo $sql1.'<br>';
	$sqlQuery = mysqli_query($db, $sql1);
	$totalAmount+=${amountPaid.$i};
	}//ro
	}//if
 }//for


  $paidAmount=$totalAmount;
 if($paidAmount > 0){
  $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
	$qqf=mysqli_query($db, $query);
}
// 	echo $query;
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);}
}//if $POprepayment

if($POprepayment){
for($i=1;$i<$n;$i++){
$amountPaid_i_0=${amountPaid.$i};
if($amountPaid_i_0>0){
	$amount=0;
   $reff=${posl.$i};
   $temp=vendorName($vid);
   $paidTo=$temp[vname];
   $paidAmount=${amountPaid.$i};

//insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);
 $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);

	$amount=popaymentPaid(${posl.$i})+${amountPaid.$i};
	$sql1 = "UPDATE popayments SET paidAmount='$amount' WHERE posl='${posl.$i}'";
	//echo $sql1.'<br>';
	$sqlQuery = mysqli_query($db, $sql1);

	$totalAmount+=${amountPaid.$i};
	}//if
 }//for


}//if $POprepayment

/* if Apply to Expencess*/
if($calculate){
for($i=1;$i<=2;$i++){
	${exitemCode0.$i}=${exitemCode1.$i}.'-'.${exitemCode2.$i}.'-'.${exitemCode3.$i};
   }
 }
if($cashPurchase && $paidTo){
for($i=1;$i<$n;$i++){
$poqty_i_0=$_POST['poqty'.$i];
 if($poqty_i_0){
	$amount=0;
//	$paidAmount=$paidAmount+${examount.$i};
$sql="select * from porder where poid=${poqty.$i} AND status=1";
// echo "$sql<br>";
$sqlq=mysqli_query($db, $sql);
$r=mysqli_fetch_array($sqlq);

	${cpunitPrice.$i}=round(${examount.$i}/$r[qty],2);
	$sqlitem1 = "INSERT INTO `storet$exfor` (rsid,itemCode, receiveQty,currentQty, rate, paymentSL, reference, remark,todat)".
	"VALUES ('','$r[itemCode]', '$r[qty]','$r[qty]', '${cpunitPrice.$i}', '$paymentSL', '$r[posl]', '$remark', '$paymentDate1')";
		echo $sqlitem1;
	$queryecpstoret= mysqli_query($db, $sqlitem1);
	mysqli_query($db, "UPDATE porder set status=2 where poid=${poqty.$i}");
	$paidAmount+=round(${cpunitPrice.$i}*$r[qty],2);
   }//$cpquantity.$i
 }//for
// echo $paidAmount;
 if($paidAmount > 0)
 {
	 //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);
	 $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
	// echo $query;
	$qqfecppurchase=mysqli_query($db, $query);
 }
}//if
if($expencess && $paidTo){
	if($account1=="6909000" || $account1=="7036000" || $fuelType){
// 		if($paymentDate1>'2016-12-31')exit;
		//202
	$sql="";
	$equipment_fuelArray=explode("_",$equipment_fuel);
				
		$equipment_fuelArray[2]=$_POST[fuelType];
		$fuelTypeCheck=item2itemCode4Eq(null,$equipment_fuelArray[2]) ? true : false;
		if(!$fuelTypeCheck){ // lubricant oil type account code changed & km should be empty
			$account1="7036000";
			$mKm="";
			$fuelTypePass=true;
		}elseif(!$mKm && $fuelTypeCheck){ // fuel type should contain has km/hour
			$fuelTypePass=false;
		}else
			$fuelTypePass=true;
		
	if(is_eq_can_consumtion($equipment_fuelArray[0],$equipment_fuelArray[1],$fuelType)){
	 $paymentSL=generatePaymentSL(2,$loginProject,$paymentDate);
		$sql="insert into accEqConsumption (eqID,gl,qty,km,edate,amount,eqItemCode,uItemCode) values ('$equipment_fuelArray[0]','$paymentSL','$fQty','$mKm','$paymentDate1','$examount1','$equipment_fuelArray[1]','$fuelType')";		
		}else{
			echo "<br><h1>Fuel Type error.</h1>";
			exit;
		}
		$q=mysqli_query($db,$sql);

		if(mysqli_affected_rows($db)<1){
			echo "<br><h1>Error while saving item.</h1>";
			exit;
		}
		$qqtID=mysqli_insert_id($db);
		
$equIpmentArr=itemDes($equipment_fuelArray[1]);
if($equIpmentArr)$equIpmentDes="SL#$qqtID, ".$equIpmentArr[des]." EQ. #".$equipment_fuelArray[1].$equipment_fuelArray[0].", Consum.:".$mKm.", Qty.:".$fQty;
	}

// 	==================================================================== cash purchase =================================================
	
for($i=1;$i<=2;$i++){
$examount_i_0=${examount.$i};
  if($examount_i_0>0){
	  if($loginProject=='000'){
			$sqlitem1 = "INSERT INTO `ex130` (exID,exDescription, exgl,examount,paymentSL,exDate,account)".
		 "VALUES ('','${exdes.$i}', '${account.$i}-$exfor','${examount.$i}', '$paymentSL','$paymentDate1','$account')";
		 }
	  else{
			$sqlitem1 = "INSERT INTO `ex130` (exID,exDescription, exgl,examount,paymentSL,exDate,account)".
		 "VALUES ('','${exdes.$i}', '${account.$i}-$loginProject','${examount.$i}', '$paymentSL','$paymentDate1','$account')";
		}
		//echo $sqlitem1.'<br>';
		$querycpex= mysqli_query($db, $sqlitem1);
		$paidAmount+=${examount.$i};
   }
 }//for

if($paidAmount>0){
		$paidTo.=$paidTo ? "; ".$equIpmentDes : $equIpmentDes;
 // insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);
 		$query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
		$qqfcppurchase=mysqli_query($db, $query);
 }
// ==================================================================== cash purchase ==========================================================
//$w='';
}//if
exit;

if($cashTransfer){
  if($examount>0){
		$sqlitem1 = "INSERT INTO `ex130` (exID,exDescription, exgl,examount,paymentSL,exDate,account)".
	 "VALUES ('','$exdes', '$ct_to_account','$examount', '$paymentSL','$paymentDate1','$ct_from_account')";
	//echo $sqlitem1.'<br>';
		$queryctex= mysqli_query($db, $sqlitem1);
		$paidAmount=$examount;
   }
  if($paidAmount > 0){
   //insertPurchase($paymentSL,$paymentDate1, $paidTo, $ct_from_account,$exfor,$paidAmount, $reff,$loginProject);
   	$query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
  	$qqfctpurchase=mysqli_query($db, $query);
  }//$paidAmount
}
?>

<?

if($salaryPay){

if($w=='5'){
//echo "salaryPay: $salaryPay";
$salarymonth="$year-$month-01";
//echo "n: ".$n;
for($i=1;$i<$n;$i++){
  if(${ch.$i}){
		


		$kk=${sal.$i};
		$pp=${prr.$i};
		
         $amount1=round(${acc1.$i},2)>0 ? round(${acc1.$i},2) : 0;
         $amount2=${acc2.$i}>0 ? round(${acc2.$i},2) : 0;

// 		echo "<br>Size fo: ".sizeof($kk);

	     for($j=0;$j<sizeof($kk);$j++)
			 {
   //echo "<br>CH:".${ch.$i};
	    // echo '>>>>>>>>>>>>>>>>'.$kk[$j].'>>>>>>>>>>>>>>>><br>';
      $amount=round($kk[$j],2);
			 
		 
		  //echo "<br>${empId.$i}==$amount=$kk[$j];$j<br>";
		  $glCode="6901000-".$pp[$j];
				
     if($amount1>0 && $amount>0){
			
			 if($amount>=$amount1)$payAmount=$amount1;
			 if($amount<$amount1)$payAmount=$amount;
			 
			 $sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
			VALUES ('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$payAmount','$paymentSL','$paymentDate1','$account')";
			//echo '<br>'.$sqlitem1.'<br>#1';
			$query= mysqli_query($db, $sqlitem1);
			if(mysqli_affected_rows($db)>0)	$paidAmount+=$payAmount;
			 
			 			 $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$payAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);
			 
		if($amount<$amount1)$amount1-=$amount; //amount2 = amount2 - amount
		else $amount1=0;
			 
			}
				 
     if($amount2>0 && $amount>0){	
			 
			 if($amount>=$amount2)$payAmount=$amount2;
			 if($amount<$amount2)$payAmount=$amount;
			 
// 			 echo "<br>Size fo: ".sizeof($kk); exit;
			 $paymentSL1=generatePaymentSL($w,$loginProject,$paymentDate); 
			 $sqlitem2 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
			VALUES ('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$payAmount','$paymentSL1','$paymentDate1','$account1')";
			//echo '<br>'.$sqlitem2.'<br>#2';
			$query_2= mysqli_query($db, $sqlitem2);
			if(mysqli_affected_rows($db)>0)	$paidAmount+=$payAmount;
			 
			 $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL1','$paymentDate1', '$paidTo', '$account1','$exfor','$payAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);
										
											 if($amount<$amount2)$amount2-=$amount; //amount2 = amount2 - amount
			 								 else $amount2=0;
			}		
				 
		}//for
	if(${adAmount.$i}>0 && $amount==$amount1+$amount2)updateSalaryAdv(${empId.$i},${designation.$i},${reff.$i},$paymentSL,${adAmount.$i},$salarymonth,$paymentDate1);
	 /* UPDATE termination*/
	   $sql22="UPDATE employee set status='-2' where empId='${empId.$i}' AND status='-1' and MONTH('$salarymonth')=MONTH(jobTer) ";
  	  mysqli_query($db, $sql22);

   }//if(${ch.$i})
 }//for

	/* if($paidAmount > 0 && 1==2) //switch off this
  {
  print "257";
  //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);//stop by salma
  print $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";

$qqf=mysqli_query($db, $query);

  }*/
}//w==5
elseif($w=='51'){ 
//echo "salaryPay: $salaryPay";
$salarymonth="$year-$month-01";
//echo "n: ".$n;
for($i=1;$i<$n;$i++){
$the_ch_i_0=${ch.$i};
  if($the_ch_i_0){

        $kk=${sal.$i};
		$pp=${prr.$i};

		//echo "<br>Size fo: ".sizeof($kk);

	     for($j=0;$j<sizeof($kk);$j++){
   //echo "<br>CH:".${ch.$i};
	    // echo '>>>>>>>>>>>>>>>>'.$kk[$j].'>>>>>>>>>>>>>>>><br>';
          $amount=round($kk[$j],2);
		  $glCode="2404000-".$pp[$j];
     if($amount>0){
			$sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,
			amount,paymentSL,pdate,account)
		    VALUES('','${empId.$i}','${designation.$i}','$salarymonth','$glCode',
			'$amount','$paymentSL','$paymentDate1','$account')";
			//echo '<br>'.$sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
			if(mysqli_affected_rows($db)>0)	$paidAmount+=$amount;
			}		
		}//for
	if(${adAmount.$i}>0)updateSalaryAdv(${empId.$i},${designation.$i},${reff.$i},$paymentSL,${adAmount.$i},$salarymonth,$paymentDate1);
	 /* UPDATE termination*/
	  $sql22="UPDATE employee set status='-2' where empId='${empId.$i}' AND status='-1' and MONTH('$salarymonth')=MONTH(jobTer) ";
  	  mysqli_query($db, $sql22);

   }//if(${ch.$i})
 }//for
  if($paidAmount > 0)
  {
	//insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);
	$query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
  $qqf=mysqli_query($db, $query);
  }
}//w==51
  

}//ifif($salaryPay)

?>
<?
if($wagesPay){
//echo "salaryPay: $salaryPay";
$paidAmount=0;
$salarymonth="$year-$month-01";
//echo "n: ".$n;
for($i=1;$i<$n;$i++){
$ch_i_1=${ch.$i};
  if($ch_i_1)
		{
			$glCode="2404000-".$loginProject;

			$sqlitem1 = "INSERT INTO `empsalary` (id,empId,designation,month,glCode,amount,paymentSL,pdate,account)
			VALUES ('','${ch.$i}','${designation.$i}','$salarymonth','$glCode',
			'${currentPayable.$i}','$paymentSL','$paymentDate1','$account')";
// 			echo '<br>'.$sqlitem1.'<br>';
			$query= mysqli_query($db, $sqlitem1);
             $r=mysqli_affected_rows($db);
			 if($r>0){
				 $paidAmount=$paidAmount+${currentPayable.$i};
		     //echo "paidAmount=$paidAmount<br>";
				 $r=0;
			 }
		}
		 /* UPDATE termination*/
	  $sql22="UPDATE employee set status='-2' where empId='${empId.$i}' AND status='-1' and MONTH('$salarymonth')=MONTH(jobTer) ";
  	  mysqli_query($db, $sql22);
 }//for
 if($paidAmount > 0){
 //echo "AAAAAAAAAAAAAAAA";
 //insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);
 $query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
$qqf=mysqli_query($db, $query);
// echo $query;
 }
 $paidAmount=0;
// 	exit;
}//if wagesPay

?>

<?
if($adsalaryPayment){
$paidAmount=0;
	for($i=1;$i<$n;$i++){
		$ch_i_2=${ch.$i};
		if($ch_i_2){
				$sql="UPDATE empsalaryad set status=2,pdate='$paymentDate1',account='$account',paymentSl='$paymentSL' 
				WHERE id=${ch.$i}";
				//echo $sql.'<br>';
				$sqlq=mysqli_query($db, $sql);
				$paidAmount+=${approvedAmount.$i};
			}//if(${ch.$i})
	}
 if($paidAmount > 0)
 {
	//insertPurchase($paymentSL,$paymentDate1, $paidTo, $account,$exfor,$paidAmount, $reff,$loginProject);
	$query="INSERT INTO purchase (prId, paymentSL, paymentDate, paidTo, account,exFor, paidAmount, reff,location)".
  "VALUES ('','$paymentSL','$paymentDate1', '$paidTo', '$account','$exfor','$paidAmount', '$reff','$loginProject')";
  $qqf=mysqli_query($db, $query);
}

}
if($querycpex and $qqfcppurchase)
{
	mysqli_query($db, "COMMIT;");
}
elseif($queryctex and $qqfctpurchase)
{
	mysqli_query($db, "COMMIT;");
}
elseif($queryecpstoret and $qqfecppurchase)
{
	mysqli_query($db, "COMMIT;");
}
else
{        
	mysqli_query($db, "COMMIT;");
}

echo "YOUR INFORMATION IS SAVING PLEASE WAIT....";
echo "<meta HTTP-EQUIV=\"refresh\" CONTENT=\"1; URL=../index.php?keyword=site+payments&w=$w&year=$year&month=$month&vid=$vid&exfor=$exfor\">";
exit;
?>