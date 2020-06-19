<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "setup.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	

	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>