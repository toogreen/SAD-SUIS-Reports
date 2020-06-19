<?php 
include("../../login.php");
include("includes/inc_editvar.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title><?echo($sub);?> - Weeks list</title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css">
<STYLE TYPE="text/css">
     P.breakhere {page-break-before: always}
</STYLE>
</head>
<body bgcolor="<? echo($bgcolor); ?>" leftmargin="15" topmargin="15" marginwidth="15" marginheight="15">
<a name="top"></a>

<?

// GET DATA FOR TABLE WEEK
include("includes/connect_db.php");
$query="SELECT * FROM week WHERE wuid='$luid' ORDER BY wdate DESC";
$result=mysql_query($query);
$num=mysql_numrows($result);

echo "<center>";

// TITLE BEGIN 
echo "<div align='center'><font size='4' face='Verdana, Arial, Helvetica, sans-serif'><b>$sub for $lclass</b></font><br><br></div>";
// TITLE END

// EDIT or NOT STARTS HERE 
echo "<table WIDTH='80%'><tr><td>";
echo "<div align='right'><font size='0' color='#FF0000'><A href='week.php?edit=$ego&luid=$luid'>$etext</A></font></div>";
echo "</td></tr></table>";
// EDIT or NOT ENDS HERE 


// BIG WRAP TABLE STARTS HERE
echo "<table WIDTH='80%' border='$border' cellspacing='$cs' bgcolor='#000000'><tr><td bgcolor='white'>";
    
    
// MAIN TABLE STARTS HERE
echo "<table WIDTH='100%' border='$border' cellspacing='$cs'><tr><td valign='top' width='50%'>";

// WEEKS TABLE STARTS HERE
echo "<table border='0'><tr><td width='200'><b><h3><nobr>Week of:</nobr></h3></b></td></tr>";


// START LOOP FOR THE WEEK
$i=0;
$l1=$num; //this is a runaround because the next loop won't take $num for some reason
while ($i < $l1) {
$wid=mysql_result($result,$i,"wid");
$wuid=mysql_result($result,$i,"wuid");
$wdate=mysql_result($result,$i,"wdate");

echo "<tr><td>";

// LINK TO VIEW ENTRY IN DETAILS
echo "<a href='lesson.php?luid=$luid&wid=$wid'>$view&nbsp;$wdate</a>";



// FOR REMOVING A WEEK STARTS 
if ($edit=="1") {
echo "<a href='lesson.php?luid=$luid&wid=$wid&edit=1'>$epic</a>&nbsp;";
echo "<a href='delete_week.php?wid=$wid&luid=$luid&edit=$editvar'><img src='images/delete.png' width='16' height='16' border='0' alt=''></a>";
}
// FOR REMOVING A WEEK ENDS 

echo "</td></tr>";

++$i;
}

echo "</table>";

// USERS TABLE STOPS HERE

echo "</td><td width='50%' valign='top'>";
echo "<b>Add a new week here:<br><br></b>";

// ADD WEEK PLANNER STARTS HERE 		
echo "<form action='insert_week.php' method='post'>";
echo "<input type='hidden' name='wuid' value='$luid'>";
echo "<input type='hidden' name='luid' value='$luid'>";

echo "<table><tr><td>Week of:</td>";
?>
<td><input type='text' name='wdate' value="<? echo date("Y-m-d"); ?>" size='20'></td></tr><tr><td></td>
<?
echo "<td><input type='Submit' value='Add week'></td>";
echo "</tr></table></form>";
// ADD WEEK PLANNER STOPS HERE  

echo "</td></tr></TABLE>";
// MAIN TABLE STOPS HERE

mysql_close();

echo "</tr></td></table>";

// BIG WRAP TABLE STOPS HERE 
echo "</center>";

include("includes/footer.php"); 
?>
</body>
</html>
