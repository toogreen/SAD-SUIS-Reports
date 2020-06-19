<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$_POST['lname'];
$_POST['lclass'];

echo $lclass;
echo "&nbsp;";
echo $lname;
echo "&nbsp;";

$query="INSERT INTO lusers VALUES ('', '$lname','$lclass')";
mysql_query($query);
echo "Record saved";
mysql_close();
?>
<br><br>
<A href="index.php?edit=0<!? echo $editvar; ?>&logged=1">Click here to continue</A>
</td>
</tr>
</table>
</center>
