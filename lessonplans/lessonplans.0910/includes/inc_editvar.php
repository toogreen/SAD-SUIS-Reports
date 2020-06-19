<? 
$editvar=1;
$spacing="2";
$sub="2009-2010 - Subject teachers Weekly PLANNER";
$delete="<img src='images/delete.png' width='16' height='16' border='0' alt=''>";
$epic="<img src='images/edit.png' width='16' height='16' border='0' alt=''>";
$view="<img src='images/view.png' width='16' height='16' border='0' alt=''>";
$logo="<a href='http://suis.com.cn'><img src='images/logo.png' border=0></a>";
$line="<img src='images/graypixel.gif' width='100%' height='1'>";
$user_class="Subject, Grade";
$user_name="Teacher";

// PYP PLANNER TABLE VARIABLES
$t_a1="PYP Lesson Planner"; $t_a2="Subject, Grade:"; $t_a3="Subject Focus";
$t_b0="Week starting: "; $t_b1="Subject, Grade:"; $t_b1a="Week #"; $t_b1b="Theme"; $t_b2="UOI"; $t_b2a="Central Idea"; $t_b3="Resources"; $t_b3a="Inquiry Focus"; $t_b3b="Desired Outcomes"; $t_b3c="Possible Questions";
$t_c0=""; $t_c1="Grouping Strategies"; $t_c2="Skills and Concepts";
$t_d0=""; $t_d1="Reflection on Activities"; $t_d2="Prior Knowledge"; $t_d2a="Activities"; $t_d2b="Vocabulary"; $t_d2c="Skills"; $t_d2d="Learning Objectives"; $t_d3="Follow up"; $t_d3a=""; $t_d3b=""; $t_d3c="";

$targets="false";
$leftw="30%"; 	//DEFINE LEFT COLUMN WIDTH ON MAIN PAGE
$wc1="5%"; 		//DEFINE WIDTH OF FIRST COL
$wc2="10%"; 		//DEFINE WIDTH OF SECOND COL
$wc3="10%"; 		//DEFINE WIDTH OF THIRD COL
$wc4="10%"; 		//DEFINE WIDTH OF FOURTH COL
$bcol="30"; 		//DEFINE SIZE OF BOX COLS
$blcol="40";		//DEFINE SIZE OF EMBED LARGE BOX COLS
$blrow="6";		//DEFINe SIZE OF HIGHER BOXES
$brow="2"; 		//DEFINE SIZE OF BOX ROWS
$cbg="ffffff"; 		//DEFINE Cells Background color
$cprop=" bgcolor='$cbg' valign='top'";

// $print='<img src="images/print.png" width="26" height="26" border="0" alt="">';
if ($print==1) {
		$bgcolor="#FFFFFF";
		$pword="";
		$border="1";
		$cs="0";
		$etext="";
		$btop="";
		$width="100%";
		$margin="0";
	} else  {
		$bgcolor="#E4E4E4"; // background
		$pword='<img src="images/print.png" width="26" height="26" border="0" alt="">';
		$border="1";
		$cs="0";
		$btop="Back to top";
		$width="90%";
		$margin="15";
}
if ($edit==$editvar AND $print<>1) {
		$etext="Back to read-only mode";
		$ego="0";
	} else if ($print<>1) {
		$etext='<img src="images/edit.png" width="16" height="16" border="0" alt="">';
		$ego="1";
}


//Get the user info all the time
// GET DATA FOR TABLE USERS
include("connect_db.php");
$query="SELECT * FROM lusers WHERE luid='$luid'";
$result=mysql_query($query);
$num=mysql_numrows($result);

// START LOOP FOR THE USERS
$i=0;
$l1=$num; //this is a runaround because the next loop won't take $num for some reason
while ($i < $l1) {
$luid=mysql_result($result,$i,"luid");
$lname=mysql_result($result,$i,"lname");
$lclass=mysql_result($result,$i,"lclass");
++$i;
}
//Get the week info all the time
// GET DATA FOR WEEK
$hquery="SELECT * FROM week WHERE wid='$wid'";
$hresult=mysql_query($hquery);
$hnum=mysql_numrows($hresult);

// START LOOP FOR WEEK
$h=0;
while ($h < $hnum) {
$wid=mysql_result($hresult,$h,"wid");
$wuid=mysql_result($hresult,$h,"wuid");
$wdate=mysql_result($hresult,$h,"wdate");

++$h;
}
mysql_close();
?>
