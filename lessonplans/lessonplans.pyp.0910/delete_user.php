<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="DELETE FROM lusers WHERE luid='$luid'";
$query2="DELETE FROM week WHERE wuid='$luid'";
mysql_query($query);
mysql_query($query2);
echo "Record deleted";
mysql_close();

echo "<br><br><A href='index.php?luid=$luid&edit=$editvar&logged=1'>Reload</A></td></tr></table></center>";
?>