<?php include("includes/inc_editvar.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title><?echo($sub);?></title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css">
<STYLE TYPE="text/css">
     P.breakhere {page-break-before: always}
</STYLE>
</head>
<body bgcolor="<? echo($bgcolor); ?>" leftmargin="15" topmargin="15" marginwidth="15" marginheight="15">
<a name="top"></a>

<?

// GET DATA FOR TABLE USERS
include("includes/connect_db.php");
$query="SELECT * FROM lusers ORDER BY lclass ASC";
$result=mysql_query($query);
$num=mysql_numrows($result);

echo "<center><h1>$sub</h1>";
?>
<!-- EDIT or NOT STARTS HERE --
	<table WIDTH="80%">
		<tr>
			<td>
    			<div align="right"><font size="0" color="#FF0000"><A href="index.php?edit=<? echo ($ego);?>&luid=<? echo ($luid);?>&			logged=1"><? echo ($etext);?></A></font></div>
			</td>		
		</tr>   
   </table>
-- EDIT or NOT ENDS HERE -->

<!--BIG WRAP TABLE STARTS HERE -->
<?

echo "<table WIDTH='$width' border='$border' cellspacing='$cs' bgcolor='#000000'><tr><td bgcolor='#000000'>";

// MAIN TABLE STARTS HERE
echo "<table WIDTH='100%' border='$border' cellspacing='$cs' bgcolor='#FFFFFF'><tr><td valign='top' width='$leftw'>";

// PASSWORD IF ENDS 

// INSERT HIDDEN CONTENT BEGIN


// SMALL TABLE WITH LOGO STARTS HERE
echo "<table border='0' width='1%'><tr>";
echo "<td width='1%'> $logo</td>";

// RIGHT COLUMN STARTS HERE
echo "<td>";
// ADD A NEW USER STARTS HERE 

if ($new=="1") {
echo "<form action='insert_user.php' method='post'>";
echo "<table border='0'><tr><td>$user_name</td>";
echo "<td><select name='lname' size='1'>";
echo "<option value='1'>Grade 1</option>";
echo "<option value='2'>Grade 2</option>";
echo "<option value='3'>Grade 3</option>";
echo "<option value='4'>Grade 4</option>";
echo "<option value='5'>Grade 5</option>";
echo "</select>";
echo "</td><tr><td>$user_class  </td>";
echo "<td><input type='text' name='lclass' value='' size='20'>(ex.: 1A)</td>";
echo "</tr><tr><td></td>";
echo "<td><input type='Submit' value='add me!'></td>";
echo "</tr></table>";
echo "</form>";
} 
// ADD A NEW USER ENDS HERE

echo "</td></tr></TABLE>";
// SMALL TABLE WITH LOGO STOPS HERE

echo "</td><td width='$rightw' valign='top' align='left'>";

if ($new=="") {

// choose class and stuff here
// USERS TABLE STATS HERE 
// LOOP TABLE HERE
echo "<table border='0' cellpadding='2' !bgcolor='black'><tr><td><b><h3>$user_name</h3></b></td><td>/</td><td><b><h3>$user_class</h3></b>";

// INVITE TO ADD NEW USER STARTS HERE 
if ($edit=="1") {

echo "<td><nobr><a href='index.php?new=1&edit=1'>ADD NEW&nbsp;<img src='images/add.png' border=0 align='top'></a></nobr></td>";
} 

// INVITE TO ADD NEW USER STOPS HERE
echo "</td></tr>";

// START LOOP FOR THE UNIT
$i=0;
$l1=$num; //this is a runaround hack because the next loop won't take $num for some reason
while ($i < $l1) {
$luid=mysql_result($result,$i,"luid");
$lname=mysql_result($result,$i,"lname");
$lclass=mysql_result($result,$i,"lclass");

echo "<tr><td><a href='week.php?luid=$luid'>$view</a>&nbsp;Grade $lname</td><td> - </td><td valign='bottom'>$lclass";

// FOR Editing/Removing A USER STARTS 
if ($edit=="1") {
//echo "";
//echo "&nbsp;&nbsp;<a href='user_update.php?luid=$luid'><font color='#E53232'>$epic</font></a>&nbsp;&nbsp;";

//DISABLED this following DELETE FONCTION FOR SAFETY REASONS (Do not want people to delete other ppl)---> 
echo "<a href='delete_user.php?luid=$luid&edit=$editvar'>$delete</a>";
}
// FOR Editing/Removing A USER ENDS

// SPACER
echo "</td></tr><tr><td colspan='3'>$line</td></tr>";

++$i;
}

echo "</table></td></tr></table>";

//  USERS TABLE STOPS HERE 

} else {
}

// MAIN TABLE STOPS HERE 

mysql_close();

// INSERT HIDDEN CONTENT ENDS


// PASSWORD FORM ENDS

echo "</tr></td></table>";
// BIG WRAP TABLE STOPS HERE 
echo "</table></center>";

// FOOTER
include("includes/footer.php"); 
?>
</body>
</html>