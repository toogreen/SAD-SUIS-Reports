<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="INSERT INTO act VALUES ('', '$lid','$luid', '$wid', '$own', '$proc', '$inter')";
mysql_query($query);
echo "Record saved";
mysql_close();
?>
<br><br>
<A href="lesson.php?id=<? echo ($luid); ?>&luid=<? echo ($luid); ?>&wid=<? echo ($wid); ?>&edit=<?echo($editvar);?>#<? echo($lid);?>">Click here to continue</A>
</td>
</tr>
</table>
</center>
