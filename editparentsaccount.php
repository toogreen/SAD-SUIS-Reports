<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "parentsaccounts.htm",
		"form" => "parentsaccountdetails.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);



	
	//---------------- Delete the account --------------------
	
		if(isset($_GET[deleteaccount])){
					
			$del = mysql_query("DELETE FROM parents_account WHERE account_id='$_GET[deleteaccount]'");
			$del = mysql_query("DELETE FROM parents_student_lookup WHERE parent_id='$_GET[deleteaccount]'");
			message("Account deleted", "parentsaccounts.php");
			exit();
		
		
		}
			
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {


		
	
						$account_id = $_POST[account_id];
						$acc_uid = $_POST[acc_uid];
						$acc_pwd = $_POST[acc_pwd];
						$acc_email = $_POST[acc_email];
						$newsletter_status = $_POST[newsletter_status];
				
						
								
			//--------------------- set query -------------------------
			
						$set = "acc_uid = '$acc_uid',
								acc_pwd = '$acc_pwd',
								acc_email = '$acc_email',
								newsletter_status = '$newsletter_status'";
								
				
													
			//-------------------------- input db ------------------------------ //
							
						
				if($account_id != "") {
					
						$update = mysql_query("UPDATE parents_account SET $set WHERE account_id='$account_id'");
						$msg = "Profile updated";
				
				} else {
					
						$update = mysql_query("INSERT INTO parents_account SET $set");
						$msg = "Profile created";	
						$account_id = mysql_insert_id();
											
				}

							
			//-------------------------- attach students ------------------------------ //
			
						$delete = mysql_query("DELETE FROM parents_student_lookup WHERE parent_id='$account_id'");
						
						
						if($_POST[acc_attachnewstudent] != "") {
						
							$acc_attachnewstudent_ex = explode(",",$_POST[acc_attachnewstudent]);
							foreach($acc_attachnewstudent_ex AS $key=>$element){
								$element = trim($element);
								if($element != ""){

									//check if the student does exist
									$check = mysql_query("SELECT stud_id FROM student WHERE stud_nb='$element'");
									$getarray = mysql_fetch_array($check);
									
									if(mysql_num_rows($check) == "1") {
									
										$insert = mysql_query("INSERT INTO parents_student_lookup 
																SET stud_id=$getarray[stud_id], parent_id=$_GET[account_id]"); 
									} else {
									
										$msg .= " <br>One ore more students could not be attached";
									}
						
								}
							}
						}
						
						
					message($msg, "parentsaccounts.php");
					exit();
					
				
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {

										
		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[account_id] != ""){
			
				$get = mysql_query("SELECT * FROM parents_account WHERE account_id='$_GET[account_id]'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
											
						$t->set_var("ACCOUNTID","$account_id");		
						$t->set_var("ACCUID","$acc_uid");			
						$t->set_var("ACCPWD","$acc_pwd");
						$t->set_var("ACCEMAIL","$acc_email");
						$t->set_var("NEWSLETTERSTATUS", dropdown($newsletterstatus_array,"newsletter_status","$newsletter_status","no"));

						
					}
					
				//and the attached students
				$get = mysql_query("SELECT parents_student_lookup.stud_id, student.stud_nb 
									FROM parents_student_lookup 
									LEFT JOIN student
									ON student.stud_id=parents_student_lookup.stud_id 
									WHERE parent_id='$_GET[account_id]'");
									
				if(mysql_num_rows($get) > "0"){
					while($getarray = mysql_fetch_array($get)){
						extract($getarray);
						$keywords .= "$stud_nb,";
					}
				$t->set_var("ACCATTACHSTUDENT", $keywords);
			} else {
				$t->set_var("ACCATTACHSTUDENT", "");		
			}
						
		/*------------------------------- Create new student profile ----------------------------------*/

		
			} else {
			
						//generate a new username
							$acc_uid = "suis" . date('y') . "" . rand(0, pow(8, 6));
						
						//quickly check if this number is taken already, quite unlikely
							$quickcheck = mysql_query("SELECT COUNT(*) AS nbrows FROM parents_account WHERE acc_uid='$acc_uid'");
							$getarray = mysql_fetch_array($quickcheck);
							
							if($getarray[nbrows] > "0") {
							
								//if the number is taken already we just reload the site. It will generate a new
								//one. If this one is taken as well, it will repeat this until it'll find a unused unique number
								//Not the best solution but it's very unlikley that it will find a used number anyway
								
								message("Error generating a unique Username. 
										Please wait until the page has been reloaded","editparentsaccount.php?stud_id=$stud_id");
								exit();
							
							}
						
						//generate a random password
						$acc_pwd = generatePassword();
					
		
						//General
									
						$t->set_var("ACCOUNTID","");		
						$t->set_var("ACCUID","$acc_uid");			
						$t->set_var("ACCPWD","$acc_pwd");
						$t->set_var("ACCEMAIL","$acc_email");
						$t->set_var("ACCATTACHSTUDENT", "$stud_nb");
						$t->set_var("NEWSLETTERSTATUS", dropdown($newsletterstatus_array,"newsletter_status","1","no"));

				

			} // if isset $bus_id
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>