<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="DELETE FROM lusers WHERE luid='$luid'";
$query2="DELETE FROM week WHERE wuid='$luid'";
$query3="DELETE FROM lesson WHERE luser='$luid'";
$query4="DELETE FROM act WHERE auid='$luid'";
mysql_query($query);
mysql_query($query2);
mysql_query($query3);
mysql_query($query4);
echo "Record deleted";
mysql_close();
?>
<br><br>
<A href="index.php?luid=<? echo ($luid); ?>&edit=<?echo($editvar);?>&logged=1">Reload</A>
</td>
</tr>
</table>
</center>