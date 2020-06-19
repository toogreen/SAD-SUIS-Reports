<? 
$editvar=1;
$spacing="2";
$sub="";
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
?>
