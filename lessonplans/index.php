<?php 
include("includes/inc_editvar.php"); 
include("../login.php");
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

<center>
<h1>SUIS Lesson Plans</h1>

<!--BIG WRAP TABLE STARTS HERE -->
<table WIDTH="80%" border="<? echo ($border);?>" cellspacing="<? echo ($cs);?>" bgcolor="#000000">
  <tr>
    <td bgcolor="#000000">
<!--MAIN TABLE STARTS HERE-->
<table WIDTH="100%" border="<? echo ($border);?>" cellspacing="<? echo ($cs);?>" bgcolor="#FFFFFF">
<tr>
<td valign="top" !width="<? echo ($leftw);?>">

<center>

<div align="center">

<h2><strong><font color="#0000FF">2009-2010</font></strong></h2>
<a href="lessonplans.0910/index.php">Subjects</a>&nbsp;|&nbsp;<a href="lessonplans.pyp.0910/index.php">Class Teachers (PYP)</a>
</div>

<br><br>

<?php
$past=$_GET["past"];
if ($past==1) {
?>

<h2><strong><font color="#BFBFBF"><a href="?past=0">Hide Archives<img src="images/hide.gif" width="11" height="11" border="0" alt=""></a></font></strong></h2>

<h2><strong><font color="#0000FF">2008-2009</font></strong></h2>
<a href="lessonplans.0809/index.php">Subjects</a>&nbsp;|&nbsp;<a href="lessonplans.pyp.0809/index.php">Class Teachers (PYP)</a>
</div>


<h2><strong><font color="#0000FF">2007-2008</font></strong></h2>
<a href="lessonplans.0708/index.php">Subjects</a>&nbsp;|&nbsp;<a href="lessonplans.pyp.0708/index.php">Class Teachers (PYP)</a>

<br>

<?php } else { ?>
	<font color="#BFBFBF">Display Previous Years Archives <a href="?past=1"><img src="images/show.gif" width="11" height="11" border="0" alt=""></font></a> 	
<?php } ?>


<br>

</center>
</td>
</tr></td>
</table>
<!-- BIG WRAP TABLE STOPS HERE -->
</table>
<br><br>
<a href="/students/index.php">Back to students database</a> --  OR  --  <a href="/students/logout.php">LOGOUT completely</a>

</center>
</body>
</html>
