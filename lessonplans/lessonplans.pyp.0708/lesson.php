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
echo "<td width='$wc1' $cprop></td>"; // A0
echo "<td width='$wc2' $cprop><b>$t_a1</b></td>"; // A1
echo "<td width='$wc3' $cprop><b>$t_a2</b></td>"; // A2
echo "<td width='$wc4' $cprop><b>$t_a3</b></td>"; // A3 
echo "</tr>";

// SECOND ROW
echo "<tr>";

// B0
echo "<td width='$wc1' $cprop>$t_b0</td>";   // NEW COLUMN

// B1
echo "<td width='$wc2' $cprop>";  // NEW COLUMN
echo "<b>$t_b1</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='2' name='ud_b1'>$b1</textarea>";  	}else{ 	echo ($b1); }
echo "<br>";
///B1

// B1a
echo "<br><b>$t_b1a</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='2' name='ud_b1a'>$b1a</textarea>";  	}else{ 	echo ($b1a); }
echo "<br>";
///B1a

// B1b
echo "<br><b>$t_b1b</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$blrow' name='ud_b1b'>$b1b</textarea>";  	}else{ 	echo ($b1b); }
///B1b

// END OF B1 CELL
echo "</td><br>"; 


// B2
echo "<td width='$wc3' $cprop>";  // NEW COLUMN
echo "<b>$t_b2</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$blrow' name='ud_b2'>$b2</textarea>";  	}else{ 	echo ($b2); }
echo "<br>";
///B2

// B2a
echo "<br><b>$t_b2a</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$blrow' name='ud_b2a'>$b2a</textarea>";  	}else{ 	echo ($b2a); }
echo "<br></td>"; 
///B2a

// B3
echo "<td width='$wc4' $cprop>"; // NEW COL
echo "<b>$t_b3</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_b3'>$b3</textarea>";  	}else{ 	echo ($b3); }
echo "<br>";
///B3

// B3a
echo "<br><b>$t_b3a</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_b3a'>$b3a</textarea>";  	}else{ 	echo ($b3a); }
echo "<br>";
///B3a

// B3b
echo "<br><b>$t_b3b</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_b3b'>$b3b</textarea>";  	}else{ 	echo ($b3b); }
echo "<br>";
///B3b

// B3c
echo "<br><b>$t_b3c</b><br>"; 
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_b3c'>$b3c</textarea>";  	}else{ 	echo ($b3c); }
echo "</td>"; 
///B3c

// END OF SECOND ROW
echo "</tr>";

// THIRD ROW 
echo "<tr>";
echo "<td width='$wc1' $cprop><b>$t_c0</b></td>";   // C0 NEW COLUMN
echo "<td colspan='3' rowspan='1' $cprop>";

// EMBEDDED TABLE IN ROW 3
echo "<table width='100%' border='0' cellpadding='0' cellspacing='0' bordercolor='#000000' bgcolor='#ffffff'>";
echo "<tr>";
// C1 
echo "<td width='46%' $cprop>"; // NEW COLUMN
echo "<b>$t_c1</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_c1'>$c1</textarea>";  	}else{ 	echo ($c1); }
echo "</td>"; 
/// C1

//SPACER COL TO ADD SPACE BETWEEN C1 AND C2
echo "<td width='8%'>&nbsp;</td>"; // NEW COLUMN

// C2
echo "<td width='46%' $cprop>"; // NEW COLUMN
echo "<b>$t_c2</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$blcol' rows='$brow' name='ud_c2'>$c2</textarea>";  	}else{ 	echo ($c2); }
echo "</td>"; 
/// C2

// END OF EMBED TABLE 
echo "</tr></table></td></tr>";


// FOURTH ROW
echo "<tr>";

// D0
echo "<td width='$wc1' $cprop>"; // NEW COLUMN
echo "<b>$t_d0</b></td>"; 
/// D0

// D1 
echo "<td width='$wc2' $cprop>"; // NEW COLUMN
echo "<b>$t_d1</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='22' name='ud_d1'>$d1</textarea>";  	}else{ 	echo ($d1); }
echo "</td>"; 
// D1

// D2
echo "<td width='$wc3' $cprop>"; // NEW COLUMN
echo "<b>$t_d2</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='2' name='ud_d2'>$d2</textarea>";  	}else{ 	echo ($d2); }
echo "<br>";

// D2a
echo "<br><b>$t_d2a</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='2' name='ud_d2a'>$d2a</textarea>";  	}else{ 	echo ($d2a); }
echo "<br>";
/// D2a

// D2b
echo "<br><b>$t_d2b</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='2' name='ud_d2b'>$d2b</textarea>";  	}else{ 	echo ($d2b); }
echo "<br>";
/// D2b

// D2c
echo "<br><b>$t_d2c</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='2' name='ud_d2c'>$d2c</textarea>";  	}else{ 	echo ($d2c); }
echo "<br>";
/// D2c

// D2d
echo "<br><b>$t_d2d</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='2' name='ud_d2d'>$d2d</textarea>";  	}else{ 	echo ($d2d); }
echo "<br>";
/// D2d

echo "</td>"; 
/// END OF D2 


// D3
echo "<td width='$wc4' $cprop>"; // NEW COLUMN
echo "<b>$t_d3</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_d3'>$d3</textarea>";  	}else{ 	echo ($d3); }
echo "<br>";
/// D3

// D3a
echo "<br><b>$t_d3a</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_d3a'>$d3a</textarea>";  	}else{ 	echo ($d3a); }
echo "<br>";
/// D3a

// D3b
echo "<br><b>$t_d3b</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_d3b'>$d3b</textarea>";  	}else{ 	echo ($d3b); }
echo "<br>";
/// D3b

// D3c
echo "<br><b>$t_d3c</b><br>";
if ($edit==$editvar) { echo "<textarea cols='$bcol' rows='$brow' name='ud_d3c'>$d3c</textarea>";  	}else{ 	echo ($d3c); }
/// D3c

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
