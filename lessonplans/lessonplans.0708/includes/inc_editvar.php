<? 
$editvar=1;
$spacing="2";
$sub="2007-2008 - ";
$delete="<img src='images/delete.png' width='16' height='16' border='0' alt=''>";
$epic="<img src='images/edit.png' width='16' height='16' border='0' alt=''>";
$view="<img src='images/view.png' width='16' height='16' border='0' alt=''>";
$lesson_obj="Learning objectives";
$lesson_res="Teaching Resources / Homework";
$lesson_time="Time/Lesson";
$lesson_content="Content / Concepts";
$lesson_inter="Interaction";
$lesson_diff="Differentiation";
$lesson_eval="Teacher's constructive self-evaluation";
$targets="false";

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
		$bgcolor="#E4E4E4";
		$pword='<img src="images/print.png" width="26" height="26" border="0" alt="">';
		$border="0";
		$cs="2";
		$btop="Back to top";
		$width="80%";
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
$targ1=mysql_result($hresult,$h,"targ1");
$targ2=mysql_result($hresult,$h,"targ2");
$targ3=mysql_result($hresult,$h,"targ3");
++$h;
}
mysql_close();
?>
