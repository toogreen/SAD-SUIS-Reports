<?php include("includes/inc_editvar.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<table>
<head>
<title><?echo($sub);?> lesson plans</title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="<? echo($bgcolor); ?>" leftmargin="15" topmargin="15" marginwidth="15" marginheight="15">
<a name="top"></a>


<!-- TITLE BEGIN -->
<div align="center"><font size='4' face='Verdana, Arial, Helvetica, sans-serif'><b><?echo($sub);?> lesson plans for <?echo($lname);?></b></font><br><br></div>
<!-- TITLE END -->


<!--PROCEDURES SECTION BEGIN-->
<!--BIG WRAP TABLE STARTS HERE -->
<table WIDTH="<? echo ($width);?>" align="middle" border="<? echo ($border);?>" cellspacing="<? echo ($cs);?>" bgcolor="#000000">
  <tr>
    <td bgcolor="#000000">
<table width="100%">
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="10%"><strong><? echo($lesson_time); ?></strong></td>
    <td width="80%"><strong><? echo($lesson_content); ?></strong></td>
    <td width="10%"><strong><? echo($lesson_inter); ?></strong></td>
   </tr>
<!--LOOP ACTIVITIES START HERE-->

<?
// GET DATA FOR PROCEDURES
include("includes/connect_db.php");
$jquery="SELECT * FROM act WHERE aid='$aid'";
$jresult=mysql_query($jquery);
$jnum=mysql_numrows($jresult);

//START LOOP FOR PROCEDURES
$j=0;
while ($j < $jnum) {
$lid=mysql_result($jresult,$j,"lid");
$own=mysql_result($jresult,$j,"own");
$proc=mysql_result($jresult,$j,"proc");
$inter=mysql_result($jresult,$j,"inter");
?>
<form action="update_act.php" method="post">
<input type="hidden" name="ud_aid" value="<? echo($aid);?>">
<input type="hidden" name="ud_lid" value="<? echo($lid);?>">
<input type="hidden" name="id" value="<? echo($id);?>">
<input type="hidden" name="wid" value="<? echo($wid);?>">
<input type="hidden" name="luid" value="<? echo($luid);?>">

    <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="10%"><textarea cols="10" rows="8" name="ud_own"><? echo($own);?></textarea></td>
    <td width="80%"><textarea cols="80" rows="8" name="ud_proc"><? echo($proc);?></textarea></td>
    <td width="10%"><textarea cols="10" rows="8" name="ud_inter"><? echo($inter);?></textarea></td>
    </tr>
<!--LOOP ACTIVITIES STOPS HERE-->

<?
++$j;
}

?>

<!--PROCEDURES SECTION ENDS HERE-->           

   	
</table>
</td></tr></table>
<!--BIG WRAP TABLE STOPS HERE -->
<!--PROCEDURES MAIN TABLE STOPS HERE-->  
<br>	
<div align="center"><input type="Submit" value="Update this learning procedure!"></div>
</form>
<br><br>

</body>
</html>
