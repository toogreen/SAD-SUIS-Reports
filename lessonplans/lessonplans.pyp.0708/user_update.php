<?php include("includes/inc_editvar.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<table>
<head>
<?
echo "<title>$sub $user_name and $user_class information</title>";
?>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="<? echo($bgcolor); ?>" leftmargin="15" topmargin="15" marginwidth="15" marginheight="15">
<a name="top"></a>

<?
// TITLE BEGIN
echo "<div align='center'><font size='4' face='Verdana, Arial, Helvetica, sans-serif'><b>$sub $user_name and $user_class information for $lname and $lclass</b></font><br><br></div>";
// TITLE END

// BIG WRAP TABLE STARTS HERE
echo "<table !WIDTH='$width' align='middle' border='$border' cellspacing='$cs' bgcolor='#000000'><tr><td bgcolor="#000000">";

// INNER TABLE
echo "<table WIDTH='100%'><tr valign='top' bgcolor='#FFFFFF'>";
echo "<td width='50%'><strong>$lesson_class</strong></td>";
echo "<td width='50%'><strong>$lesson_name</strong></td>";
echo "</tr>";

// LOOP ACTIVITIES START HERE

// GET DATA FOR USER
include("includes/connect_db.php");
$jquery="SELECT * FROM lusers WHERE luid='$luid'";
$jresult=mysql_query($jquery);
$jnum=mysql_numrows($jresult);

//START LOOP FOR USERS FOUND
$j=0;
while ($j < $jnum) {
$luid=mysql_result($jresult,$j,"luid");
$lname=mysql_result($jresult,$j,"lname");
$lclass=mysql_result($jresult,$j,"lclass");

echo "<form action='update_user.php' method='post'>";
echo "<input type='hidden' name='ud_luid' value='$luid'>";
echo "<tr valign='top' bgcolor='#FFFFFF'>"; 
echo "<td width='50%'>Class <br><textarea cols='20' rows='1' name='ud_lclass'>$lclass</textarea></td>";
echo <td width='50%'>Grade <br><textarea cols='20' rows='1' name='ud_lname'>$lname</textarea></td>";
echo "</tr>"
// LOOP ACTIVITIES STOPS HERE

++$j;
}

?>      

   	
</table>
</td></tr></table>
<!--BIG WRAP TABLE STOPS HERE -->
<!--PROCEDURES MAIN TABLE STOPS HERE-->  
<br>	
<div align="center"><input type="Submit" value="Update"></div>
</form>
<br><br>

</body>
</html>
