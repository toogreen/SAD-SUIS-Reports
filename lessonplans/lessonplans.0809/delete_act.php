<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="DELETE FROM act WHERE aid='$aid'";
mysql_query($query);
echo "Record deleted";
mysql_close();
?>
<br><br>
<A href="lesson.php?luid=<? echo ($luid); ?>&id=<?echo($id);?>&wid=<?echo($wid);?>&edit=1#<?echo($id);?>">Reload</A>
</td>
</tr>
</table>
</center>