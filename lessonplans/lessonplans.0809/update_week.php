<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="UPDATE week SET wid='$ud_wid', wuid='$ud_wuid', wdate='$ud_wdate', targ1='$ud_targ1', targ2='$ud_targ2', targ3='$ud_targ3' WHERE wid='$ud_wid'";
mysql_query($query);
echo "Record updated";
mysql_close();
?>
<br><br>
<A href="lesson.php?edit=<? echo $editvar; ?>&luid=<? echo ($luid);?>&lname=<?echo ($lname);?>&wid=<?echo ($ud_wid);?>">Go back</A>
</td>
</tr>
</table>
</center>