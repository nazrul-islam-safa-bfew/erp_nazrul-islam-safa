<?php 
include("common.php");

//echo("$test");
//-------------Retreiving session initiated at NewWorkWorder.php..........//
session_start();
$work_order_id=$_SESSION['workorder_id'];
//echo"$work_order_id";


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Work Worder ( #<?php echo"$work_order_id"; ?>) - PM Entry Form</title>

<!-- For Creting the Equipment Session ID by calling server.php file  -->
<script src="script.js" type="text/javascript"></script>
<!--    END -->
<script language="javascript">
/*function openpopup(){
var centerWidth=(screen.width/2)-(300/2);
var centerHeight=(screen.height/2)-(300/2);
winpops=window.open("AddPartsUsed.php","","height=230,width=500,top="+centerHeight+",left="+centerWidth+",toolbar=0,location=0,directories=0,status=0,scrollbars=0,menubar=0,resizable=0,");
}
*/

//--------------------------This Function Will be run when the page is loaded---------------
function addLoadEvent(func) {
  var oldonload = window.onload;
  if (typeof window.onload != 'function') {
    window.onload = func;
  } else {
    window.onload = function() {
      if (oldonload) {
        oldonload();
      }
      func();
    }
  }
}

addLoadEvent(function() {
var counter='<?php echo $_GET['count']; ?>';
if(counter==1)
{
document.form1.selectID.disabled=true;
}

});

//-------------------------------------END-------------------------------------------------------

//---------------------------Validating Form Input--------------------
function validate1(frm)
{
if(frm.selectID.value=="")
{
alert("Please Select PM Task.");
frm.selectID.focus();
return false;
}
return true
}


function goAdd(frm)
{
if(validate1(frm)==true)
{
document.form1.hidField.value=1;
document.form1.submit();
}
}

//---------------------------Disable the Combo After Selection--------------------
function goDisable()
{
//-----------For checking which function is call form which form------------------

document.form1.hidEquipment.value=1;
var chk_id=document.form1.hidEquipment.value;

//......................creating the combo's object to make it desable.........................
obj=document.getElementById("selectID");
obj.disabled=true;
//--------------------storing combo value to create the session.............
pmTask=document.getElementById("selectID").value;

//----------------------------Loading the server.php page to initiate the session for the PM Task
//var element = document.getElementById('answer');
xmlhttp.open("GET", 'server.php?chk_id=' + chk_id + '&pmTask=' + pmTask);
//xmlhttp.onreadystatechange = function() {
//if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
//element.value=xmlhttp.responseText;
//}
//}
 xmlhttp.send(null);
}
//---------------------------------------END--------------------------


//-------Tracking Rows OndbClick Event---Which fetch the information corresponding to the row------

function goClick(m)
{
document.form1.hidPartNo.value=m;
//alert(document.form1.hidPartNo.value);
document.form1.hidField.value=2;
document.form1.submit();

}


//-------Tracking Rows OndbClick Event(of Labor Section)---Which fetch the information corresponding to the row------

function goClick1(m)
{
document.form1.hidLaborid.value=m;
//alert(m);
document.form1.hidField.value=6;
document.form1.submit();

}

//----------------------------Tracking Cancle Button OnClick Event-----------------------
function goCancel()
{
document.form1.hidField.value=4;
document.form1.submit();
}

//----------------------------Tracking Save Buttons OnClick Event and seving the record----------------------

//-------------------------Validating Form Imput & Then Save & Exit------------------------------

function validate(form1)
{
if(form1.selectID.value=="")
{
alert("Cannot Save The Record.You Should Add PM Task Befere Saving the Record.");
form1.selectID.focus();
return false;
}
else if(form1.txt_part_cost.value=="")
{
alert("Cannot Save The Record.You Should add atlest one part.");
//form1.txt_part_cost.focus();
return false;
}
else if(form1.txt_total_cost.value=="")
{
alert("Cannot Save The Record.You Should add atlest one part.");
//form1.txt_part_cost.focus();
return false;
}
return true;
}


function doFinish(form1)
{
if(validate(form1)==true)
{
document.form1.hidField.value=3;
document.form1.submit();
}
}

//----For Labor Section(Add Button Click)
function goAddLabor(frm)
{
if(validate1(frm)==true)
{
document.form1.hidField.value=5;
document.form1.submit();
}
}


</script>

</head>

<body>
					
					<?php 
					session_start();
					$PMServiceID=$_SESSION['pm_service_id'];
					echo $PMServiceID;
					?>
					
<form action="NewWorkWorder_Add_PM_EntryMedium.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <p>
    <input name="hidField" type="hidden" id="hidField" />
    <input name="hidPartNo" type="hidden" id="hidPartNo" />
    <input name="hidEquipment" type="hidden" id="hidEquipment" />
    <input name="hidLaborid" type="hidden" id="hidLaborid" />
  </p>
  <table width="767" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#CCCCCC">
    
    <tr bgcolor="#33CC33">
      <td colspan="4" bgcolor="#33CC33"> Work Order (#<?php echo"$work_order_id"; ?>) - PM Entry </td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="142" bgcolor="#FF99FF">PM Task </td>
      <td colspan="3"><select name="selectID" id="selectID" onchange="goDisable()">
        <option value="" selected="selected"></option>
        <?php  
								
														
														CreateConnection();
								
														$rs="SELECT  pm_service_id,pm_service_name FROM add_pm_service";
																			
														$result = mysqli_query($db, $rs);
														while ($name_row = mysql_fetch_row($result)) {
														$pm_service_id=$name_row[0];
														$pm_service_name=$name_row[1];
	echo"<option value='$pm_service_id'"; if($pm_service_id==$PMServiceID) echo ' SELECTED '; echo">$pm_service_name</option>";		
														}
														
																
														
														
									?>
      </select></td>
      <td width="109">Parts</td>
      <td colspan="2"><?php //for calculating total parts cost for  a PM task
							  	
								CreateConnection();
								$qry="SELECT part_extended_cost FROM new_work_order_part_used WHERE work_order_id='$work_order_id' AND pm_service_id='$PMServiceID'";
							  	
								$qryexecute=mysqli_query($db, $qry);
								
								while($rs=mysql_fetch_row($qryexecute))
								{
									$cost=$rs[0];
									$ext_cost=$ext_cost+$cost;
								}
								
							  ?>
          <input name="txt_part_cost" type="text" id="txt_part_cost" value="<?php echo"$ext_cost"; ?>" size="15" READONLY/>      </td>
      <td width="96">&nbsp;</td>
      <td width="90">&nbsp;</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
      <td colspan="3">&nbsp;</td>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr bgcolor="#FF99FF">
      <td width="96">Labor
        <?php //for calculating total Labor cost for  a PM task
							  	
								CreateConnection();
								$qry1="SELECT lobor_cost FROM new_work_order_pm_labor_used WHERE work_order_id='$work_order_id' AND pm_service_id='$PMServiceID'";
							  	
								$qryexecute1=mysqli_query($db, $qry1);
								
								while($rs1=mysql_fetch_row($qryexecute1))
								{
									$cost1=$rs1[0];
									$ext_cost_labor=$ext_cost_labor+$cost1;
								}
								
							  ?>
      </td>
      <td colspan="3"><label><a href="javascript:NewCal('pm_date','yyyymmdd','true',12)"></a>      </label>        
      <a href="javascript:NewCal('pm_date','yyyymmdd','true',12)">
      <input name="txt_labor_cost" type="text" id="txt_labor_cost" value="<?php echo"$ext_cost_labor"; ?>" size="15" READONLY/>
      </a></td>
      <td>Total</td>
      <td colspan="2">
	  <?php 
	  //...........calculating total cost(parts+labor) for a PM Task..........
	  $total_part_labor=$ext_cost+$ext_cost_labor;
	  ?>
	  <input name="txt_total_cost" type="text" id="txt_total_cost" value="<?php echo"$total_part_labor"; ?>" size="15" READONLY/></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
  </table>
  <br />
  <table width="767" align="center" cellpadding="0" cellspacing="0" >
    <tr bgcolor="#33CC33" style="border:dotted">
      <td width="154">Psrts Used </td>
      <td width="204" bgcolor="#33CC33">&nbsp;</td>
      <td width="103">&nbsp;</td>
      <td width="124">&nbsp;</td>
      <td width="180">&nbsp;</td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td>Part #</td>
      <td>Name</td>
      <td>Used</td>
      <td>Cost</td>
      <td>Extended</td>
    </tr>
    			
											<?php 
												
												CreateConnection();
												$qry="SELECT part_num,part_name,part_quantity,part_unit_cost,part_extended_cost FROM new_work_order_part_used WHERE work_order_id='$work_order_id' AND pm_service_id='$PMServiceID'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$part_num=$rs[0];
								$part_name=$rs[1];
								$part_quantity=$rs[2];
								$part_unit_cost=$rs[3];
								$part_extended_cost=$rs[4];
																								
								echo"<tr bgcolor=#FF99FF ondblclick='goClick($part_num)'>
								
									<td>$part_num</td>
									<td>$part_name</td>
									<td>$part_quantity</td>
									<td>$part_unit_cost</td>
									<td>$part_extended_cost</td>
									</tr>";
								
								}
							


											?>
				
    <tr bgcolor="#CCCCCC">
      <td><label>
        <input type="button" name="Button" value="  Add  " onclick="goAdd(form1)" />
      </label></td>
      <td><label></label></td>
      <td><label></label></td>
      <td bgcolor="#CCCCCC"><div align="right">Total</div></td>
      <td bgcolor="#CCCCCC"><label>
                              
        <div align="right">
          <input name="txt_part_total" type="text" id="txt_part_total" size="15" value="<?php echo"$ext_cost"; ?>" READONLY/>
        </div>
      </label></td>
    </tr>
  </table>
<br />
  <table width="767" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="156">Labor Used </td>
      <td width="202">&nbsp;</td>
      <td width="104">&nbsp;</td>
      <td width="125">&nbsp;</td>
      <td width="178">&nbsp;</td>
    </tr>
    <tr bgcolor="#CCCCCC">
      <td>Technisian</td>
      <td>Description of Work </td>
      <td>Rate</td>
      <td>Hours</td>
      <td>Extended</td>
    </tr>
    												
												<?php 
												
												CreateConnection();
												$qry="SELECT emp_id,desc_of_work,emp_labor_rate,work_hour,lobor_cost FROM new_work_order_pm_labor_used WHERE work_order_id='$work_order_id' AND pm_service_id='$PMServiceID'";
												
												
												$qryexecute=mysqli_query($db, $qry);
							
							while($rs=mysql_fetch_row($qryexecute))
							{
								$emp_id=$rs[0];
								$desc_of_work=$rs[1];
								$emp_labor_rate=$rs[2];
								$work_hour=$rs[3];
								$lobor_cost=$rs[4];
								
								//retreiving employee name from add_new_employee table based on $emp_Name value
								$qry1="SELECT name FROM employee WHERE empId='$emp_id'";
								$qryexecute1=mysqli_query($db, $qry1);
								$employe_name=mysql_result($qryexecute1,0,0);
																								
								echo"<tr bgcolor=#FF99FF ondblclick='goClick1($emp_id)'>
								
									<td>$employe_name</td>
									<td>$desc_of_work</td>
									<td>$emp_labor_rate</td>
									<td>$work_hour</td>
									<td>$lobor_cost</td>
									</tr>";
								
								}
							


											?>
				

													
    <tr bgcolor="#CCCCCC">
      <td bgcolor="#CCCCCC"><label>
        <input type="button" name="Submit4" value="  Add  " onclick="goAddLabor(form1)"/>
      </label></td>
      <td><label></label></td>
      <td><label></label></td>
      <td bgcolor="#CCCCCC"><div align="right">Total</div></td>
      <td bgcolor="#CCCCCC"><div align="right">
        <input name="txt_part_total2" type="text" id="txt_part_total2" size="15" value="<?php echo"$ext_cost_labor"; ?>" READONLY/>
      </div></td>
    </tr>
  </table>
 <br />
  <table width="767" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr bgcolor="#33CC33">
      <td width="35">&nbsp;</td>
      <td width="209"><center>
      </center></td>
      <td width="330"><center>
        <input name="BSave" type="button" id="BSave" onclick="doFinish(form1)" value="     Save Record      "/>
      </center></td>
      <td width="193">&nbsp;</td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</form>
</body>
</html>
