<? 
$editvar=1;
$spacing="2";
$sub="2008-2009 - SUIS UOI/English Weekly PLANNER";
$delete="<img src='images/delete.png' width='16' height='16' border='0' alt=''>";
$epic="<img src='images/edit.png' width='16' height='16' border='0' alt=''>";
$view="<img src='images/view.png' width='16' height='16' border='0' alt=''>";
$logo="<a href='http://suis.com.cn'><img src='images/logo.png' border=0></a>";
$line="<img src='images/graypixel.gif' width='100%' height='1'>";
$user_class="Class";
$user_name="Grade";

// PYP PLANNER TABLE VARIABLES
$t_a1="ACTIVITIES"; $t_a2="TRANSDISCIPLINARY SKILLS / ATTITUDES"; $t_a3="<b>ASSESSMENT";
$t_b0="<b>UOI</b><br>Learner Profile and Attitude for the week"; $t_b1="UOI"; $t_b1a="Central Idea"; $t_b1b="Activities"; $t_b2="Transdisciplinary Skills"; $t_b2a="Attitudes"; $t_b3="Reflection"; $t_b3a="Formative"; $t_b3b="Summative"; $t_b3c="Homework";
$t_c0="Desired Outcomes"; $t_c1="UOI"; $t_c2="English";
$t_d0="English"; $t_d1="Activities"; $t_d2="Skills"; $t_d2a="Reading"; $t_d2b="Writing"; $t_d2c="Speaking"; $t_d2d="Listening"; $t_d3="Assessment"; $t_d3a="Formative"; $t_d3b="Summative"; $t_d3c="Homework";

$targets="false";
$leftw="30%"; 	//DEFINE LEFT COLUMN WIDTH ON MAIN PAGE
$wc1="10%"; 		//DEFINE WIDTH OF FIRST COL
$wc2="30%"; 		//DEFINE WIDTH OF SECOND COL
$wc3="30%"; 		//DEFINE WIDTH OF THIRD COL
$wc4="30%"; 		//DEFINE WIDTH OF FOURTH COL
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
