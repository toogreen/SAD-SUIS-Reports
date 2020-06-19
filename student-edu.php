<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form_edu.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Delete a school --------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	if(isset($_GET[delschool])) {
	
		$del = mysql_query("DELETE FROM school WHERE school_id='$_GET[delschool]'");
		if($del) {
			message("School deleted", "student-edu.php?stud_id=$_GET[stud_id]");
			exit();
		}
		
	}

/* -------------------------------------------------------------------------------------------- */	
/* -------------------------------------- Add a school ---------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[addschool])) {
			
			$stud_id = $_POST[stud_id];
			$school_name = $_POST[school_name];
			$school_country = $_POST[school_country];
			$school_periode = $_POST[school_periode];
			$school_curriculum = $_POST[school_curriculum];
			$school_cert = $_POST[school_cert];
			$school_releaseform = $_POST[school_releaseform];
			
			$currentgrade = addslashes($school_name);
			$school_country = addslashes($school_country);
			$school_periode = addslashes($school_periode);
			$school_curriculum = addslashes($school_curriculum);
			$school_cert = addslashes($school_cert);
			$school_releaseform = addslashes($school_releaseform);
			
			
		$insert = mysql_query("INSERT INTO school 
								SET stud_id = '$stud_id', school_name = '$school_name', 
								school_country = '$school_country', school_periode = '$school_periode', 
								school_curriculum = '$school_curriculum', school_releaseform = '$school_releaseform', school_cert = '$school_cert'");
			if($insert) {
			
				message("School added", "student-edu.php?stud_id=$stud_id");
				exit();
			
			}
	}
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	

						$skippedgrade = $_POST[skippedgrade];
						$suspended = $_POST[suspended];
						$repeatedgrade = $_POST[repeatedgrade];
						$behaviorproblems = $_POST[behaviorproblems];
						$behaviormanagement = $_POST[behaviormanagement];
						$indi_testing = $_POST[indi_testing];
						$background_others = $_POST[background_others];
			
						
			//---------------- make the text save --------------------
			
						$currentgrade = addslashes($currentgrade);
						$skippedgrade = addslashes($skippedgrade);
						$suspended = addslashes($suspended);
						$repeatedgrade = addslashes($repeatedgrade);
						$behaviorproblems = addslashes($behaviorproblems);
						$behaviormanagement = addslashes($behaviormanagement);
						$indi_testing = addslashes($indi_testing);
						$background_others = addslashes($background_others);
									
				
			//--------------------- set query -------------------------
			
						$set = "skippedgrade = '$skippedgrade',
								suspended = '$suspended',
								repeatedgrade = '$repeatedgrade',
								behaviorproblems = '$behaviorproblems',
								behaviormanagement = '$behaviormanagement',
								indi_testing = '$indi_testing',
								background_others = '$background_others',
								lastupdate_ps = lastupdate_ps,
								lastupdate_pa = lastupdate_pa,
								lastupdate_med = lastupdate_med,
								lastupdate_edu = now(),
								lastupdate_emgc = lastupdate_emgc,
								lastupdate_lang = lastupdate_lang,
								lastupdate_general = now(),
								lastupdate_user = '$_SESSION[user_id]',
								iscreated_edu = '1'";
								
						
						
			//-------------------------- Input new ------------------------------ 
			
			
				if($_POST[stud_id] != "") {
					$update = mysql_query("UPDATE student SET $set WHERE stud_id='$_POST[stud_id]'");
					
					//alright, let's check if the timestamp lastupdate_edu is empty / null, if so than it's a new student,
					//so let's send them to the next step student_emgc.php. Otherwise go back to student_hm.php
					
					$get = mysql_query("SELECT iscreated_emgc FROM student WHERE stud_id='$_POST[stud_id]'");
					if(mysql_num_rows($get) == "0") {
						
						//something went completely wrong .. 
						message("Invalid page. Please report this to the webmaster", "");
					
					} else {
					
						$getarray = mysql_fetch_array($get);

						if($getarray[iscreated_emgc] == "0") { 
							//send to the next step
							message("Information added to profile","student-emgc.php?stud_id=$_POST[stud_id]");
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


		/*------------------------------------ Schow all schools  ----------------------------*/
		
			$get = mysql_query("SELECT * FROM school WHERE stud_id='$_GET[stud_id]'");
			if(mysql_num_rows($get) > "0"){
				while($getarray = mysql_fetch_array($get)){
					extract($getarray);
					$schools .= "<div class='school_rows'><h1>$school_name / $school_country </h1>Periode of study: $school_periode<br>Curriculum: 
								$school_curriculum<br>Language of Instruction: $school_language<br> Highest level of study/certificate awarded: $school_cert <br>
								School release form: $school_releaseform 
								<br><a href='student-edu.php?delschool=$school_id&stud_id=$stud_id'><img src=\"img/icon_schooldelete.gif\" border='0'/></a></div><br>";
				
				}
				
				$t->set_var("SCHOOLS","$schools");	
			} else {
			
				//no school has been input yet
				$t->set_var("SCHOOLS","$schools");	
			}

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
							
							if($iscreated_edu == "0") {
								$t->set_var("ADMINMSG","Creating student profile for $callname (Step 3 / 6)");
							} else {
								$t->set_var("ADMINMSG","Updating student profile of student $callname");
							}				
										
						//Education Background
							$t->set_var("STUDID","$stud_id");						
							$t->set_var("SKIPPEDGRADE","$skippedgrade");
							$t->set_var("SUSPENDED","$suspended");
							$t->set_var("REPEATEDGRADE","$repeatedgrade");
							$t->set_var("BEHAVIORPROBLEMS","$behaviorproblems");
							$t->set_var("BEHAVIORMANAGEMENT","$behaviormanagement");
							$t->set_var("INDITESTING","$indi_testing");
							$t->set_var("BACKGROUNDOTHERS","$background_others");
						
				}
			} 
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>