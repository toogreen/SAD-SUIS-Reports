<?php 
include("../../login.php");
include("includes/inc_editvar.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<head>
<title><?echo($sub);?> Lesson Plans - Teachers list</title>
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
?>

<center>
<h1><?echo($sub);?> SUIS Lesson Plans</h1>

<!-- EDIT or NOT STARTS HERE -->
	<table WIDTH="80%">
		<tr>
			<td>
    			<div align="right"><font size="0" color="#FF0000"><A href="index.php?edit=<? echo ($ego);?>&luid=<? echo ($luid);?>"><? echo ($etext);?></A></font></div>
			</td>		
		</tr>   
   </table>
<!-- EDIT or NOT ENDS HERE -->

<!--BIG WRAP TABLE STARTS HERE -->
<table WIDTH="80%" border="<? echo ($border);?>" cellspacing="<? echo ($cs);?>" bgcolor="#000000">
  <tr>
    <td bgcolor="#000000">
<!--MAIN TABLE STARTS HERE-->
<table WIDTH="100%" border="<? echo ($border);?>" cellspacing="<? echo ($cs);?>" bgcolor="#FFFFFF">
<tr>
<td valign="top" !width="<? echo ($leftw);?>">

<!-- <center><a href="../lessonplans.pyp.0809/index.php?logged=<?echo ($logged); ?>"><font color="red">Class Teahers, click here to jump to the PYP PLANNER</font></a><center>
 -->
<br><br>

<!-- SMALL TABLE WITH LOGO STARTS HERE-->
<table border="0">
<tr>
<td><a href="http://suis.com.cn"><img src="images/logo.png" border=0></a></td>
<td>

<!-- ADD A NEW USER STARTS HERE -->	
<?
if ($new=="1") {
?>
<form action="insert_user.php" method="post">
<table border="0">
<tr>
<td>Subject and grade:  </td>
<td><input type="text" name="lclass" value="" size="20">(ex.: Chinese, G3)</td>
</tr>
<tr>
<td>Teacher's Name:  </td>
<td><input type="text" name="lname" value="" size="20"></td>
</tr>
<tr>
<td></td>
<td><input type="Submit" value="add me!"></td>
</tr>
</table>
</form>
<? 
} 
?>
<!-- ADD A NEW USER ENDS HERE -->

</td>
</tr></TABLE>
<!-- SMALL TABLE WITH LOGO STOPS HERE-->  
</td>
<td !width="<? echo ($rightw); ?>" valign="top">


<?
if ($new=="") {
?>
<!--- choose class and stuff here --->

<!-- USERS TABLE STATS HERE -->


<!--- LOOP TABLE HERE -->
<table border="0"  !align="middle" cellpadding="2" !bgcolor="black">

<!-- INVITE TO ADD NEW USER STARTS HERE --
<tr>
<td colspan="3">
<center>
<i><font size="2">To add a subject,</font>
<a href="index.php?new=1&logged=<? echo($logged); ?>&edit=1">click here</a></i>
</center>
</td>
</tr>
-- INVITE TO ADD NEW USER STOPS HERE -->

<tr>
<td><b><h3>Subject & Grade</h3></b></td>
<td>/</td>
<td><b><h3>Teacher</h3></b>
<!-- INVITE TO ADD NEW USER STARTS HERE -->
<?
if ($edit=="1") {
?>
<td>
<nobr><a href="index.php?new=1&edit=1">ADD NEW&nbsp;<img src="images/add.png" border=0 align="top"></a></nobr>
</td>
<? 
} 
?>
<!-- INVITE TO ADD NEW USER STOPS HERE -->

</td>
</tr>
<?
// START LOOP FOR THE UNIT
$i=0;
$l1=$num; //this is a runaround hack because the next loop won't take $num for some reason
while ($i < $l1) {
$luid=mysql_result($result,$i,"luid");
$lname=mysql_result($result,$i,"lname");
$lclass=mysql_result($result,$i,"lclass");
?>
<tr>
<td>
<a href="week.php?luid=<? echo($luid); ?>"><? echo($view); ?></a>&nbsp;

<? echo($lclass); ?></td>
<td></td>
<td><? echo($lname); ?>

<!-- FOR Editing/Removing A USER STARTS -->
<? 
if ($edit=="1") {

echo "&nbsp;&nbsp;<a href='user_update.php?luid=$luid'><font color='#E53232'>$epic</font></a>&nbsp;&nbsp;";
?>
<!-- DISABLED this following DELETE FONCTION FOR SAFETY REASONS (Do not want people to delete other ppl) <a href="delete_user.php?luid=<? echo($luid); ?>&edit=<? echo($editvar); ?>"><img src="images/delete.png" width="16" height="16" border="0" alt=""><!/a>
--->
<? 
}
?>
<!-- FOR Editing/Removing A USER ENDS -->

</td>
</tr>
<tr><td colspan="3"><img src="images/graypixel.gif" width="100%" height="1"></td></tr>


<? 
++$i;
}
?>


</table>
</td>
</tr>




</table>
<!-- USERS TABLE STOPS HERE -->
<?
} else {
}
?>
<!-- MAIN TABLE STOPS HERE -->
<?
mysql_close();
?>
<!-- INSERT HIDDEN CONTENT ENDS -->


</tr></td>
</table>
<!-- BIG WRAP TABLE STOPS HERE -->
</table>
</center>
<? include("includes/footer.php"); ?>
</body>
</html>
