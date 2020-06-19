<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="INSERT INTO lesson VALUES ('', '$luser','$uname','$week','$day','$date','$textdate','$obj1','$obj2','$obj3','$mat','$stud','$eval')";
mysql_query($query);
echo "Record saved";
mysql_close();
?>
<br><br>
<A href="lesson.php?luid=<? echo ($luser); ?>&wid=<?echo($week);?>&edit=1">Click here to continue</A>
</td>
</tr>
</table>
</center>
