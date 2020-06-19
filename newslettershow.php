<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
  <title>: : Shanghai United International School : :</title>
 <script type="text/JavaScript">
<!--

function toggleLayer(whichLayer)
{
if (document.getElementById)
{
// this is the way the standards work
var style2 = document.getElementById(whichLayer).style;
style2.display = style2.display? "":"block";
}
else if (document.all)
{
// this is the way old msie versions work
var style2 = document.all[whichLayer].style;
style2.display = style2.display? "":"block";
}
else if (document.layers)
{
// this is the way nn4 works
var style2 = document.layers[whichLayer].style;
style2.display = style2.display? "":"block";
}
}

function showhide(oSelect)
{
var oDiv = document.getElementById('form2a'), data = oSelect.options[oSelect.selectedIndex].value;
if (data == "0")
oDiv.style.display = 'block';
if (data == "1")
oDiv.style.display = 'none';
}


//-->
</script>
  <link href="suis_adminstyles.css" media="screen" rel="Stylesheet" type="text/css">
   <style>


  a:link, a:visited {
    color: #039;
  }

  a:hover {
    color: #fff;
  }

  #Header {
    background-color: #84AECD;
  }

  #Header h1 {
    color: #444;
  }

  #Header h3, #Header h3 a:link, #Header h3 a:visited {
    color: #FFFFFF;
  }

  #Header h3 a:hover {
    color: #000;
    background-color: #FFF;
  }

  #Header h3 a.current:link, #Header h3 a.current:visited {
    color: #444;
  }

  #Header h3 a.current:hover {
    color: #444;
  }

  #Header h1 a:link, #Header h1 a:visited {
    color: #444;
    text-decoration: none;
  }

  #Header h1 a:hover {
    color: #444;
  }

  #Header h2 {
    color: #FFFFFF;
  }

  #Header h2 a:link, #Header h2 a:visited {
    color: #FFFFFF;
    text-decoration: none;
  }

  #Header h2 a:hover {
    color: #FFFFFF;
  }

  #Tabs a:link, #Tabs a:visited {
    background-color: #999;
    color: #FAC0A4;
    border: 1px solid #84AECD;
    border-bottom: 1px solid #999;
	font-size: 12px;
	padding-bottom: 2px;
  }

  #Tabs a:link.current, #Tabs a:visited.current {
    color: #333;
  }

  #Tabs a:hover {
    color: #000;
    background-color: #FFF;
    border-bottom: 1px solid #FFF;
  }

  #Tabs li#AdminTab a:link, #Tabs li#AdminTab a:visited {
    color: #FFFFFF;
    border-bottom: 1px solid #84AECD;
    text-decoration: underline;
  }

  #Tabs li#AdminTab a:hover {
    color: #444;
  }

  #Tabs li#AdminTab a.current {
    color: #444;
    text-decoration: none;
  }
</style>
</head>
<body>

<div class="Container">
 <div id="ContentFrame">
 <div id="Statusbar">
 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><img src="img/suis_logo.GIF" border='0'></td>
    <td valign="bottom" align="right"><div id="StatusRight"> Logged in : <b>{LOGINNAME}</b> | <a href="logout.php" title="Log-out and remove the cookie from your machine">Log-out</a> 
      </div></td>
  </tr>
</table>

	    
	</div>
		<div id="Header">
      <h1>: : Student administration desk : :</h1>
      <br>
		<!-- TABS -->
		 
      <ul id="Tabs">
        <li><a href="student.php">Student</a></li>
        <li><a href="attendance.php">Attendance</a></li>
        <li><a href="comments.php">Comments</a></li>
        <li><a href="ps_sessions.php">Psychologist Session</a></li>
        <li><a href="payment.php">Payment</a></li>
        <li><a href="transport.php">Transportation</a></li>
        <li><a href="classrooms.php">Classrooms</a></li>
        <li><a href="newsletter.php">Newsletter</a></li>
        <li><a href="parentsaccounts.php">Accounts</a></li>
        <li><a href="setup.php">Setup</a></li>
      </ul>

  </div>

   
 {CONTENT}
</div>
</div>
</body></html>