<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="DELETE FROM week WHERE wid='$wid'";
$query2="DELETE FROM lesson WHERE week='$wid'";
mysql_query($query);
mysql_query($query2);
echo "Record deleted";
mysql_close();

echo "<br><br><A href='week.php?luid=$luid&edit=$editvar'>Reload</A></td></tr></table></center>";
?>