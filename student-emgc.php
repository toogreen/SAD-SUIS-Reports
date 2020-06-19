<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form_emgc.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$emgc_contact = $_POST[emgc_contact];
						$emgc_relationship = $_POST[emgc_relationship];
						$emgc_phone = $_POST[emgc_phone];
						$emgc_mobile = $_POST[emgc_mobile];
						$emgc_office = $_POST[emgc_office];
						$emgc_email = $_POST[emgc_email];
						$emgc2_contact = $_POST[emgc2_contact];
						$emgc2_relationship = $_POST[emgc2_relationship];
						$emgc2_phone = $_POST[emgc2_phone];
						$emgc2_mobile = $_POST[emgc2_mobile];
						$emgc2_office = $_POST[emgc2_office];
						$emgc2_email = $_POST[emgc2_email];
					
				
			//--------------------- set query -------------------------
			
						$set = "emgc_contact = '$emgc_contact',
								emgc_relationship = '$emgc_relationship',
								emgc_phone = '$emgc_phone',
								emgc_mobile = '$emgc_mobile',
								emgc_office = '$emgc_office',
								emgc_email = '$emgc_email',
								emgc2_contact = '$emgc2_contact',
								emgc2_relationship = '$emgc2_relationship',
								emgc2_phone = '$emgc2_phone',
								emgc2_mobile = '$emgc2_mobile',
								emgc2_office = '$emgc2_office',
								emgc2_email = '$emgc2_email',
								lastupdate_ps = lastupdate_ps,
								lastupdate_pa = lastupdate_pa,
								lastupdate_edu = lastupdate_edu,
								lastupdate_med = lastupdate_med,
								lastupdate_emgc = now(),
								lastupdate_lang = lastupdate_lang,
								lastupdate_general = now(),
								lastupdate_user = '$_SESSION[user_id]',
								iscreated_emgc = '1'";
								
						
			//-------------------------- Input new ------------------------------ 
			
			
				if($_POST[stud_id] != "") {
					$update = mysql_query("UPDATE student SET $set WHERE stud_id='$_POST[stud_id]'");
					
					
					//alright, let's check if the timestamp lastupdate_edu is empty / null, if so than it's a new student,
					//so let's send them to the next step student_emgc.php. Otherwise go back to student_hm.php
					
					$get = mysql_query("SELECT iscreated_med FROM student WHERE stud_id='$_POST[stud_id]'");
					if(mysql_num_rows($get) == "0") {
						
						//something went completely wrong .. 
						message("Invalid page. Please report this to the webmaster", "");
					
					} else {
					
						$getarray = mysql_fetch_array($get);

						if($getarray[iscreated_med] == "0") { //this '0000-00-00 00:00:00 might change from server to server
							//send to the next step
							message("Information added to profile","student-med.php?stud_id=$_POST[stud_id]");
							exit();						
						} else {
							//send back to student_hm.php
							message("Student profile has been updated","student-hm.php?stud_id=$_POST[stud_id]");
							exit();
						}
					
					}
					
				
			//---------------------------- Update -------------------------------- 				
			
				} else {
					message("This page is invalid. If you got here through a link, please report this bad link to the webmaster","student.php");
					exit();			
				}
			
			
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {


		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[stud_id] != ""){
			
				$stud_id = $_GET[stud_id];
				$get = mysql_query("SELECT * FROM student WHERE stud_id='$stud_id'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
					
						//is it a new profile, or do they just edit it ?
							if($preferedname == "0") {
								$callname = "$firstname $middlename $lastname";
							} else {
								$callname = "$chinesename";
							}
							
							if($iscreated_emgc == "0") {
								$t->set_var("ADMINMSG","Creating student profile for $callname (Step 4 / 6)");
							} else {
								$t->set_var("ADMINMSG","Updating student profile of student $callname");
							}	
	
						//Emergency
						
							$t->set_var("STUDID","$stud_id");
	
							$t->set_var("EMGCCONTACT","$emgc_contact");
							$t->set_var("EMGCRELATIONSHIP", "$emgc_relationship");
							$t->set_var("EMGCPHONE","$emgc_phone");
							$t->set_var("EMGCMOBILE","$emgc_mobile");
							$t->set_var("EMGCOFFICE","$emgc_office");
							$t->set_var("EMGCEMAIL","$emgc_email");
							
							$t->set_var("EMGC2CONTACT","$emgc2_contact");
							$t->set_var("EMGC2RELATIONSHIP","$emgc2_relationship");
							$t->set_var("EMGC2PHONE","$emgc2_phone");
							$t->set_var("EMGC2MOBILE","$emgc2_mobile");
							$t->set_var("EMGC2OFFICE","$emgc2_office");
							$t->set_var("EMGC2EMAIL","$emgc2_email");
									
					}
			}

		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>