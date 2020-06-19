<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?

include("includes/connect_db.php");

$query="UPDATE lusers SET lname='$ud_lname', lclass='$ud_lclass' WHERE luid='$ud_luid'";
mysql_query($query);

echo $ud_lname;
echo "'s";
echo "&nbsp;";
echo $ud_lclass;
echo "&nbsp;";

echo "Record updated";
mysql_close();
?>
<br><br>
<A href="index.php?logged=1">Go back</A>
</td>
</tr>
</table>
</center>
