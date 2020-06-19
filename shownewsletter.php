<?php
include("functions.php");
include("config.php");
require("class.phpmailer.php");


dbConnect ('');
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
  <title>: : Shanghai United International School : :</title>
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
<br>
<table width="600" border="0" align="center" cellpadding="1" cellspacing="1">
  <tr>
    <td bgcolor="#999999"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="59%" bgcolor="#FFFFFF"><img src="img/suis_logo.GIF" border='0'></td>
        <td width="41%" align="right" valign="bottom" bgcolor="#FFFFFF">&nbsp;</td>
      </tr>
      <tr>
        <td colspan="2" bgcolor="#84AECD">&nbsp;</td>
      </tr>
      <tr>
        <td height="69" colspan="2" bgcolor="#FFFFFF"><table width="95%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td>
			  <?PHP
			  
			  	if(!isset($_GET[e])) {
			  
			  		echo("Invalid page. Can not load the newsletter from the database. ");
			  	
				} else {
					
					$get = mysql_query("SELECT * FROM newsletter WHERE newsletter_id='$_GET[e]'");	
					if(mysql_num_rows($get) > "0") {
					
						$getarray = mysql_fetch_array($get);
						extract($getarray);
					
						echo("<br><br>$newsletter_txt<br><br>");
												
					}	
				}
			  ?>
			  </td>
            </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
</table>
<br>
</body></html>