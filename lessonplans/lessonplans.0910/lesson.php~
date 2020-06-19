<?php
include("../../login.php");
include("includes/inc_editvar.php"); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<?
echo "<table><head>";

echo "<title>$sub for $lclass</title>";
echo "<link href='includes/stylesheet.css' rel='stylesheet' type='text/css'>";
echo "<STYLE TYPE='text/css'>P.breakhere {page-break-before: always}</STYLE>";
echo "</head>";
echo "<body bgcolor='$bgcolor' leftmargin='$margin' topmargin='$margin' marginwidth='$margin' marginheight='$margin'>";
echo "<a name='top'></a>";

// GET DATA FOR WEEK
include("includes/connect_db.php");
$hquery="SELECT * FROM week WHERE wid='$wid'";
$hresult=mysql_query($hquery);
$hnum=mysql_numrows($hresult);

// START LOOP FOR WEEK
$h=0;
while ($h < $hnum) {
$wid=mysql_result($hresult,$h,"wid");
$wuid=mysql_result($hresult,$h,"wuid");
$wdate=mysql_result($hresult,$h,"wdate");
$b1=mysql_result($hresult,$h,"b1");
$b1a=mysql_result($hresult,$h,"b1a");
$b1b=mysql_result($hresult,$h,"b1b");
$b2=mysql_result($hresult,$h,"b2");
$b2a=mysql_result($hresult,$h,"b2a");
$b3=mysql_result($hresult,$h,"b3");
$b3a=mysql_result($hresult,$h,"b3a");
$b3b=mysql_result($hresult,$h,"b3b");
$b3c=mysql_result($hresult,$h,"b3c");
$c1=mysql_result($hresult,$h,"c1");
$c2=mysql_result($hresult,$h,"c2");
$d1=mysql_result($hresult,$h,"d1");
$d2=mysql_result($hresult,$h,"d2");
$d2a=mysql_result($hresult,$h,"d2a");
$d2b=mysql_result($hresult,$h,"d2b");
$d2c=mysql_result($hresult,$h,"d2c");
$d2d=mysql_result($hresult,$h,"d2d");
$d3=mysql_result($hresult,$h,"d3");
$d3a=mysql_result($hresult,$h,"d3a");
$d3b=mysql_result($hresult,$h,"d3b");
$d3c=mysql_result($hresult,$h,"d3c");


// TABLE FOR PRINT - EDIT START

echo "<table width='$width' align='middle' border='0'><TR>";
echo "<TD align='left' width='20%'><A href='lesson.php?print=1&luid=$luid&lname=$lname&wid=$wid'>$pword</A></TD>";

if ($print<> 1) {
echo "<TD align='middle' width='60%'><A href='week.php?&luid=$luid&wid=$wid&logged=1'>Go back to the weeks menu</A></TD>";
}
echo "<TD align='right' width='20%'><A href='lesson.php?edit=$ego&luid=$luid&wid=$wid'>$etext</A></TD>";
echo "</TR></table>";
//  TABLE FOR PRINT - EDIT STOPS

echo "<br>";

//  TITLE BEGIN
echo "<div align='center'><font size='4' face='Verdana, Arial, Helvetica, sans-serif' !color='white'><b>$sub for $lclass -  <nobr>week of ";

if ($edit==$editvar) {
echo	"<form action='update_week.php' method='post'>";
echo 	"<input type='hidden' name='ud_wid' value='$wid'>";
echo	"<input type='hidden' name='ud_wuid' value='$wuid'>";
echo 	"<input type='hidden' name='luid' value='$luid'>";
echo	"<input type='text' name='ud_wdate' value='$wdate' size='10'>";
	} else {
echo($wdate);
}
echo "</nobr></b></font></div>";
//  TITLE END


// MAIN TABLE BEGINS HERE
echo "<table WIDTH=$width align='middle' border='$border' cellspacing='$cs' bgcolor='#000000'><tr><td bgcolor='#000000'>";

// Inner table
echo "<table align='middle' width='100%' border='$border' cellpadding=5 cellspacing=$cs bordercolor='#000000' bgcolor='#FFFFFF'>";

// FIRST ROW
echo "<tr>";
echo "<td !width='$wc1' $cprop colspan='3'><b>$t_a1 for $lname</b></td>"; // A1
echo "<td width='$wc2' $cprop><b>$t_a3</b></td>"; // A3 
echo "</tr>";

// SECOND ROW
echo "<tr>";
// B0
echo "<td !width='$wc1' $cprop><b>$t_b0</b><br>$wdate </td>";
echo "<td !width='$wc2' $cprop><b>$t_b1</b><br>$lclass </td>";

// B1a
echo "<td><b>$t_b1a</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='1' rows='1' name='ud_b1a'>$b1a</textarea>";  	}else{ 	echo ($b1a); }
echo "</td>";
///B1a

// B1b
echo "<td rowspan='2'><b>$t_b1b</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$blrow' name='ud_b1b'>$b1b</textarea>";  	}else{ 	echo ($b1b); }
echo "</td></tr>";
///B1b


// THIRD ROW
echo "<tr>";

// B2
echo "<td width='$wc1' $cprop>";  // NEW COLUMN
echo "<b>$t_b2</b><br>"; 
echo "</td>"; 
echo "<td width='$wc2' $cprop colspan='2'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_b2'>$b2</textarea>";  	}else{ 	echo ($b2); }
echo "<br>";
///B2

// FOURTH ROW
echo "</td></tr><tr>";

// B2a
echo "<td>";
echo "<br><b>$t_b2a</b><br>"; 
echo "</td>"; 
echo "<td width='$wc1' $cprop colspan='2'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_b2a'>$b2a</textarea>";  	}else{ 	echo ($b2a); }
echo "<br></td>"; 
///B2a

// B3
echo "<td rowspan='3'><b>$t_b3</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$blrow' name='ud_b3'>$b3</textarea>";  	}else{ 	echo ($b3); }
echo "</td></tr>";
///B3

// B3a
echo "<tr><td>";
echo "<br><b>$t_b3a</b><br>"; 
echo "</td>"; 
echo "<td width='$wc1' $cprop colspan='2'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_b3a'>$b3a</textarea>";  	}else{ 	echo ($b3a); }
echo "<br></td>"; 
///B3a

// B3b
echo "<tr><td>";
echo "<br><b>$t_b3b</b><br>"; 
echo "</td>"; 
echo "<td width='$wc1' $cprop colspan='2'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_b3b'>$b3b</textarea>";  	}else{ 	echo ($b3b); }
echo "<br></td>"; 
///B3b

// FIFTH ROW
echo "</td></tr><tr>";

// B3c
echo "<td>";
echo "<br><b>$t_b3c</b><br>"; 
echo "</td>"; 
echo "<td width='$wc1' $cprop colspan='2'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_b3c'>$b3c</textarea>";  	}else{ 	echo ($b3c); }
echo "<br></td>"; 
///B3c

// C1
echo "<td rowspan='1'><b>$t_c1</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_c1'>$c1</textarea>";  	}else{ 	echo ($c1); }
echo "</td></tr>";
///C1

// SIXTH ROW
echo "</td></tr><tr>";

// C2
echo "<td>";
echo "<br><b>$t_c2</b><br>"; 
echo "</td>"; 
echo "<td width='$wc1' $cprop colspan='2'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_c2'>$c2</textarea>";  	}else{ 	echo ($c2); }
echo "<br></td>"; 
///C2

// D1
echo "<td rowspan='2'><b>$t_d1</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$blrow' name='ud_d1'>$d1</textarea>";  	}else{ 	echo ($d1); }
echo "</td></tr>";
///D1

// SEVENTH ROW
echo "</td></tr><tr>";

// D2
echo "<td>";
echo "<br><b>$t_d2</b><br>"; 
echo "</td>"; 
echo "<td width='$wc1' $cprop colspan='2'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_d2'>$d2</textarea>";  	}else{ 	echo ($d2); }
echo "<br></td>"; 
///D2

// EIGHTD ROW
echo "</td></tr><tr>";

// D2a
echo "<td colspan='4'>";
echo "<br><b>$t_d2a</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_d2a'>$d2a</textarea>";  	}else{ 	echo ($d2a); }
echo "<br></td>"; 
///D2a

// NINTH ROW
echo "</td></tr><tr>";

// D2b
echo "<td width='$wc1' colspan='2'>";
echo "<br><b>$t_d2b</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_d2b'>$d2b</textarea>";  	}else{ 	echo ($d2b); }
echo "<br></td>"; 
///D2b

// D2c
echo "<td width='$wc1' colspan='1'>";
echo "<br><b>$t_d2c</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_d2c'>$d2c</textarea>";  	}else{ 	echo ($d2c); }
echo "<br></td>"; 
///D2c

// D2d
echo "<td width='$wc1' colspan='2'>";
echo "<br><b>$t_d2d</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_d2d'>$d2d</textarea>";  	}else{ 	echo ($d2d); }
echo "<br></td>"; 
///D2d

// TENTH ROW
echo "</td></tr><tr>";

// D3
echo "<td>";
echo "<br><b>$t_d3</b><br>"; 
echo "</td>"; 
echo "<td width='$wc1' $cprop colspan='3'>";  // NEW COLUMN
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_d3'>$d3</textarea>";  	}else{ 	echo ($d3); }
echo "<br></td>"; 
///D3


echo "</td>"; 
///END OF D3

echo "</tr>";

// END OF INNER TABLE
echo "</table>";    

// END OF BACKGROUND TABLE
echo "</td></tr></table>";


// DISPLAY SUBMIT BUTTON
if ($edit==$editvar) { // IF EDIT MODE IS ON, SHOW BUTTON TO CHANGE DATE
echo "<div align='center'><input type='Submit' value='ADD / UPDATE'></div>";

// END OF FORM
echo "</form>";

	}
	++$h;
}	

// END SURROUNDING INVISIBLE TABLE
echo "</TD></TR></TABLE>";

// END OF PRINT TABLE UNKNOWN TABLE!!
echo "</td></tr></table>";



// TABLE FOR BOTTOM BACK TO TOP BEGINS:
echo "<table align='middle' width='$width' border='0'><TR>";
echo "<TD align='left'></TD>";
echo "<TD align='right'><a href='#top'>$btop</a></TD>";
echo "</TR></table>";
// TABLE FOR BOTTOMBACK TO TOP ENDS



// THIS IF IS TO PRINT PAGE BREAK IF THERE'S A NEXT UNIT - DISABLED / NOT NEEDED IN THIS VERSION
// if ($i<$l1-1){
//	echo "<P CLASS='breakhere'>";

//++$i;
// }
mysql_close();
?>
</body>
</html>
