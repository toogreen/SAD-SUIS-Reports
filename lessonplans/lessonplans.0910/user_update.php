<?php include("includes/inc_editvar.php"); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<table>
<head>
<title><?echo($sub);?> subject and grade information</title>
<link href="includes/stylesheet.css" rel="stylesheet" type="text/css">
</head>
<body bgcolor="<? echo($bgcolor); ?>" leftmargin="15" topmargin="15" marginwidth="15" marginheight="15">
<a name="top"></a>


<!-- TITLE BEGIN -->
<div align="center"><font size='4' face='Verdana, Arial, Helvetica, sans-serif'><b><?echo($sub);?> Subject and Grade information for <?echo($lname);?></b></font><br><br></div>
<!-- TITLE END -->


<!--PROCEDURES SECTION BEGIN-->
<!--BIG WRAP TABLE STARTS HERE -->
<table !WIDTH="<? echo ($width);?>" align="middle" border="<? echo ($border);?>" cellspacing="<? echo ($cs);?>" bgcolor="#000000">
  <tr>
    <td bgcolor="#000000">
<table WIDTH="100%">
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="50%"><strong><?echo($user_class);?></strong></td>
    <td width="50%"><strong><?echo($user_name);?></strong></td>
   </tr>
<!--LOOP ACTIVITIES START HERE-->

<?
// GET DATA FOR USER
include("includes/connect_db.php");
$jquery="SELECT * FROM lusers WHERE luid='$luid'";
$jresult=mysql_query($jquery);
$jnum=mysql_numrows($jresult);

//START LOOP FOR USERS FOUND
$j=0;
while ($j < $jnum) {
$luid=mysql_result($jresult,$j,"luid");
$lname=mysql_result($jresult,$j,"lname");
$lclass=mysql_result($jresult,$j,"lclass");
?>
<form action="update_user.php" method="post">
<input type="hidden" name="ud_luid" value="<? echo($luid);?>">

    <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="50%"><textarea cols="20" rows="1" name="ud_lclass"><? echo($lclass);?></textarea></td>
    <td width="50%"><textarea cols="20" rows="1" name="ud_lname"><? echo($lname);?></textarea></td>
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
<div align="center"><input type="Submit" value="Update"></div>
</form>
<br><br>

</body>
</html>
