<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form_med.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$medicine = $_POST[medicine];
						$contactlenses = $_POST[contactlenses];
						$physicalactivity = $_POST[physicalactivity];
						
			//---------------- make the text save --------------------
			
						$medicine = addslashes($medicine);
						$physicalactivity = addslashes($physicalactivity);
									
				
			//---------------- health stuff arrays --------------------
				
				if($_POST[immunization] != ""){
					$immunization_in = implode($_POST[immunization], "?");
				}
				
				if($_POST[diseas] != ""){
					$diseas_in = implode($_POST[diseas], "?");
				}
				
				if($_POST[medical_others] != ""){
					$medical_others_in = implode($_POST[medical_others], "?");
				}
				
			//--------------------- set query -------------------------
			
						$set = "medicine = '$medicine',
								contactlenses = '$contactlenses',
								immunization = '$immunization_in',
								diseas = '$diseas_in',
								medical_others = '$medical_others_in',
								physicalactivity = '$physicalactivity',
								lastupdate_ps = lastupdate_ps,
								lastupdate_pa = lastupdate_pa,
								lastupdate_edu = lastupdate_edu,
								lastupdate_med = now(),
								lastupdate_emgc = lastupdate_emgc,
								lastupdate_lang = lastupdate_lang,
								lastupdate_general = now(),
								lastupdate_user = '$_SESSION[user_id]',
								iscreated_med = '1'";
								
						
						
			//-------------------------- Input new ------------------------------ 
			
			
				if($_POST[stud_id] != "") {
					$update = mysql_query("UPDATE student SET $set WHERE stud_id='$_POST[stud_id]'");
					
					//alright, let's check if the timestamp lastupdate_edu is empty / null, if so than it's a new student,
					//so let's send them to the next step student_emgc.php. Otherwise go back to student_hm.php
					
					$get = mysql_query("SELECT iscreated_lang FROM student WHERE stud_id='$_POST[stud_id]'");
					if(mysql_num_rows($get) == "0") {
						
						//something went completely wrong .. 
						message("Invalid page. Please report this to the webmaster", "");
					
					} else {
					
						$getarray = mysql_fetch_array($get);

						if($getarray[iscreated_lang] == "0") { //this '0000-00-00 00:00:00 might change from server to server
							//send to the next step
							message("Information added to profile","student-lang.php?stud_id=$_POST[stud_id]");
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

						$t->set_var("STUDID","$stud_id");	
						
						//is it a new profile, or do they just edit it ?
							if($preferedname == "0") {
								$callname = "$firstname $middlename $lastname";
							} else {
								$callname = "$chinesename";
							}
							
							if($iscreated_med == "0") {
								$t->set_var("ADMINMSG","Creating student profile for $callname (Step 5 / 6)");
							} else {
								$t->set_var("ADMINMSG","Updating student profile of student $callname");
							}		
						
						
						//Medical
						
						$immunization = explode("?", $immunization);
						
						foreach($immunizations_array as $key=>$element){
							if(in_array($key, $immunization)){
								$immu_out .= "<input name='immunization[]' type='checkbox' value='$key' checked> $element<br>";
							} else {
								$immu_out .= "<input name='immunization[]' type='checkbox' value='$key'> $element<br>";
							}
							$t->set_var ("IMMUNIZATIONS", $immu_out);
						}
						
						$diseas = explode("?", $diseas);
						
						foreach($diseas_array as $key=>$element){
							if(in_array($key, $diseas)){
								$dis_out .= "<input name='diseas[]' type='checkbox' value='$key' checked> $element<br>";
							} else {
								$dis_out .= "<input name='diseas[]' type='checkbox' value='$key'> $element<br>";
							}
							$t->set_var ("DISEASES", $dis_out);
						}
						
						$medical_others = explode("?", $medical_others);
						
						foreach($medical_others_array as $key=>$element){
							if(in_array($key, $medical_others)){
								$med_out .= "<input name='medical_others[]' type='checkbox' value='$key' checked> $element<br>";
							} else {
								$med_out .= "<input name='medical_others[]' type='checkbox' value='$key'> $element<br>";
							}
							$t->set_var ("MEDICALOTHERS", $med_out);
						}
						
						$t->set_var("MEDICINE","$medicine");
						$t->set_var("CONTACTLENSES", dropdown($contactlenses_array,"contactlenses","$contactlenses","no"));
						$t->set_var("PHYSICALACTIVITY","$physicalactivity");
						
					}
				}


		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>
