<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "setupmain.htm",
		"form" => "user_edit_form.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$this_user_id = $_POST[this_user_id];
						$this_user_realname = $_POST[this_user_realname];
						$this_user_uid = $_POST[this_user_uid];
						$this_user_pwd = $_POST[this_user_pwd];
						$this_user_email = $_POST[this_user_email];
						$level = $_POST[level];
						
			
	if($this_user_id == "") {
					
								
	//security check .. the user that has been submitted can not have the status of a superuser
		$check = mysql_query("SELECT is_superadmin FROM user WHERE user_id = '$this_user_id'");
		$getarray = mysql_fetch_array($check);
		if($getarray[is_superadmin] == "1") {
			message("Can not update this profile", "setup.php");
			exit();
		}
		
	//check if the username is taken already (sorry no real form check here)
		$checkuid = mysql_query("SELECT COUNT(*) AS isscho FROM user WHERE uid='$this_user_uid'");
		$getarray = mysql_fetch_array($checkuid);
		
		if($getarray[isscho] > "0") {
				message("This username is already taken", "user-edit.php");
				exit();
		}
		
		
		}
		
					
													
			//--------------------- set query -------------------------
						
						$set = "user_realname = '$this_user_realname',
								uid = '$this_user_uid',
								pwd = '$this_user_pwd',
								level = '$level',
								user_email = '$this_user_email'";
								
				
						
			//-------------------------- Update ------------------------------ 
			
			
				if($this_user_id != "") {
					$update = mysql_query("UPDATE user SET $set WHERE user_id='$this_user_id'");
					
					message("User updated","setup.php?t=user");
					exit();		
					
	
			//---------------------------- Input new -------------------------------- 				
			
				} else {
				
					$insert = mysql_query("INSERT INTO user SET $set");
					
					message("User successfully created","setup.php?t=user");
					exit();			
				}
			
			
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {
		
		
		/*------------------------------------ Get all nlevel  ----------------------------*/
		
			$nations_array = array();
				$get = mysql_query("SELECT * FROM user_level");
		
				if(mysql_num_rows($get) > "0"){
					while($getarray = mysql_fetch_array($get)){
					extract($getarray);
						$levels_array[$level_id] .= "$level_name";
					}
				}
				
				
		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[user_id] != ""){
			
		
			
			//security check .. the user that has been submitted can not have the status of a superuser
				$check = mysql_query("SELECT is_superadmin FROM user WHERE user_id = '$_GET[user_id]'");
				$getarray = mysql_fetch_array($check);
				if($getarray[is_superadmin] == "1") {
					message("Can not update this profile", "setup.php");
					exit();
				}
		
		
				$get = mysql_query("SELECT user_id AS this_user_id, user_realname, user_email, uid AS thisuseruid, pwd AS thisuserpwd, level 
									FROM user WHERE user_id='$_GET[user_id]'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
	
						
						//General
						$t->set_var("USERID","$this_user_id");	

						$t->set_var("USERREALNAME", $user_realname);	
						$t->set_var("USEREMAIL", $user_email);	
						$t->set_var("USERUID", $thisuseruid);
						$t->set_var("USERPWD", $thisuserpwd);		
						$t->set_var("LEVELDROP", dropdown($levels_array,"level","$level","no"));

						
					}
					
		/*------------------------------- Create new student profile ----------------------------------*/

		
			} else {
			
			
						//General
						$t->set_var("USERID","$this_user_id");	

						$t->set_var("USERREALNAME", $user_realname);	
						$t->set_var("USEREMAIL", $user_email);	
						$t->set_var("USERUID", $thisuseruid);
						$t->set_var("USERPWD", $thisuserpwd);		
						$t->set_var("LEVELDROP", dropdown($levels_array,"level","$level","no"));	
	

				

			} // if isset $stud_id
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>