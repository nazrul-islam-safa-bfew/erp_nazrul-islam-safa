
<?php
require("common.php");
CreateConnection();

$txt_meter=$_POST['txtmeter'];
$create_date=date("Y-m-d");

$item_insert="INSERT INTO equipment_meter_type(meter_type,created_date)VALUES ('$txt_meter','$create_date')";
$execute=mysqli_query($db, $item_insert);


if($execute==true)
{
echo("$txt_meter has been successfully added to the database.");
}
else
{
echo("$txt_meter Exist...Please Enter Different Meter Type.");
}

?>










<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Successful</title>
</head>




<body>
<p>&nbsp;</p>
<p>&nbsp;</p>
<table width="400" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="2"><div align="center">
      <p>&nbsp;</p>
    </div></td>
  </tr>
  <tr>
    <td width="291"><div align="center"><a href="EquipmentMeterSetup.php">BACK</a></div></td>
        <td width="435"><div align="center"><a href="javascript:window.close()">CLOSE </a></div></td>

  </tr>
</table>
</body>
</html>
