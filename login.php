<?php
include("functions.php");
include("config.php");

session_start();

$submitlogin = $_POST[submitlogin];


/*---------------------------------- Er ist angemeldet ---------------------------*/

if(isset($_SESSION['uid'])) {

	dbConnect ();

	$uid = $_SESSION[uid];
	$pwd = $_SESSION[pwd];
		
	//check user from db
	$get = mysql_query("SELECT COUNT(*) AS isuser FROM user WHERE uid='$uid' AND pwd='$pwd'");
	$getarray = mysql_fetch_array($get);
	
	if($getarray[isuser] == "0"){

  		session_unregister("uid");
  		session_unregister("pwd");
		echo("invalid login");
		exit;
	} 
	
}

	

/*---------------------------------- Er meldet sich an ---------------------------*/

if(isset($submitlogin)){

	dbConnect ();

	$uid = $_POST[uid];
	$pwd = $_POST[pwd];
	
	session_register("uid"); 
	session_register("pwd"); 
	
	//check user from db
	$get = mysql_query("SELECT user_id, uid, pwd, lastlogin, level AS mylevel FROM user WHERE uid='$uid' AND pwd='$pwd'");

	if(mysql_num_rows($get) == "0"){
	
  		session_unregister("uid");
  		session_unregister("pwd");
  		session_unregister("mylevel");		
		echo("invalid login");
		exit;
	} else {
		$getarray = mysql_fetch_array($get);
		extract($getarray);
		session_register("lastlogin"); 
		session_register("user_id"); 
		session_register("mylevel"); 
		
		
		//update die lastlogin scheisse
		$update = mysql_query("UPDATE user SET lastlogin=now() WHERE uid='$uid'");
	}
	

}

/*---------------------------------- Er ist noch nicht angemeldet -----------------------*/

if(!isset($_SESSION['uid'])) {
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"><head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8"><title>Shanghai United International school login</title>
  <link href="suis_adminstyles.css" media="screen" rel="Stylesheet" type="text/css"></head>
	<body class="login" onLoad="document.forms[0].elements[0].focus();">
	<div class="Container">
	  <div id="LogoBox" class="white"></div>
	  
  <div id="Dialog">Shanghai United International School login
    <form action="<?PHP echo($PHP_SELF);?>" method="post">
      <dl>
        <dt>Username:</dt>
        <dd> 
          <input name="uid" id="username" type="text">
        </dd>
        <dt>Password: </dt>
        <dd> 
          <input name="pwd" id="username" type="password">
        </dd>
        <dd> 
          <input name="submitlogin" type="submit" id="submitlogin" value="Sign in">
        </dd>
      </dl>
  </form>
</div>
  </div>
</body></html>
<?php
exit;
} 

?>