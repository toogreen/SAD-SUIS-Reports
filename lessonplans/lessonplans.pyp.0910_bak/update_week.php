<center>
<table width="100%" height="100%">
<tr>
<td align="middle">
<?
include("includes/inc_editvar.php");
include("includes/connect_db.php");

$query="UPDATE week SET wid='$ud_wid', wuid='$ud_wuid', wdate='$ud_wdate', b1='$ud_b1', b1a='$ud_b1a', b1b='$ud_b1b', b2='$ud_b2', b2a='$ud_b2a', b3='$ud_b3', b3a='$ud_b3a', b3b='$ud_b3b', b3c='$ud_b3c',c1='$ud_c1', c2='$ud_c2', d1='$ud_d1', d2='$ud_d2', d2a='$ud_d2a', d2b='$ud_d2b', d2c='$ud_d2c', d2d='$ud_d2d', d3='$ud_d3', d3a='$ud_d3a', d3b='$ud_d3b', d3c='$ud_d3c'  WHERE wid='$ud_wid'";
mysql_query($query);
echo "Record updated";
mysql_close();
//header( 'Location: http://suis.com.cn/lessonplans.pyp/lesson.php?edit=0&luid=$luid&lname=$lname&wid=$ud_wid' ) ;
echo "<br><br><A href='lesson.php?edit=0&luid=$luid&lname=$lname&wid=$ud_wid'>Go back</A></td></tr></table></center>";
?>