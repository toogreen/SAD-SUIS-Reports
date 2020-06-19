<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"content" => "mysetup.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
	
					$this_user_pwd = $_POST[this_user_pwd];
					$this_user_email = $_POST[this_user_email];
											
					
					  										
			//-------------------------- Update ------------------------------ 
			
					$thisisme = $_SESSION[user_id];
					$update = mysql_query("UPDATE user SET pwd = '$this_user_pwd', user_email = '$this_user_email' WHERE user_id='$thisisme'");
					
					session_unregister("pwd");
					
					$pwd = $this_user_pwd;
					session_register("pwd");
					
					message("Update ok","index.php");
					exit();		
								
					
			
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {
		
				$thisisme = $_SESSION[user_id];
				

				$get = mysql_query("SELECT user_email, uid AS thisuseruid, pwd AS thisuserpwd FROM user WHERE user_id='$thisisme'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
		
						//General
						$t->set_var("USEREMAIL", $user_email);	
						$t->set_var("THISUSERUID", $thisuseruid);
						$t->set_var("USERPWD", $thisuserpwd);		

						
					}
					
		/*------------------------------- Create new student profile ----------------------------------*/


			
		} // if isset $submit
			


		$t->parse(CONTENT, "content");		
		$t->pparse(MAIN, "body");
		
	
	
?>