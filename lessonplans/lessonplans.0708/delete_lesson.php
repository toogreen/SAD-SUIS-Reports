<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="DELETE FROM lesson WHERE id='$id'";
$query2="DELETE FROM act WHERE lid='$id'";
mysql_query($query);
mysql_query($query2);
echo "Record deleted";
mysql_close();
?>
<br><br>
<A href="lesson.php?id=<? echo($id);?>&luid=<? echo ($luid); ?>&lname=<?echo($lname);?>&wid=<?echo($wid);?>&edit=<?echo($editvar);?>">Reload</A>
</td>
</tr>
</table>
</center>