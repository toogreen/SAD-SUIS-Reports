<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form_ps.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
	//--------------------------- Check the level ------------------------------//		
	if(checklevel("add_student", $mylevel) == "0"){
		message("You have no permission to perform this operation", "index.php", "3");
		exit(); }
	//--------------------------------------------------------------------------//	
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$stud_id = $_POST[stud_id];
						$pre_interview_res = $_POST[pre_interview_res];
						$status = $_POST[status];
						$appliesforgrade = $_POST[appliesforgrade];
						$lastname = $_POST[lastname];
						$firstname = $_POST[firstname];
						$middlename = $_POST[middlename];
						$chinesename = $_POST[chinesename];
						$preferedname = $_POST[preferedname];
						$sex = $_POST[sex];
						$descent = $_POST[descent];
						$placeofbirth  = $_POST[placeofbirth];
						$nationality = $_POST[nationality];
						$passport_nb = $_POST[passport_nb];
						$passport_exp = $_POST[passport_exp];
						$currentgrade = $_POST[currentgrade];
						$exp_lenght_stay = $_POST[exp_length_stay];
					
				
						
			//---------------- make the text save --------------------

						$pre_interview_res = addslashes($pre_interview_res);
						$lastname = addslashes($lastname);
						$fistname = addslashes($firstname);			
						$middlename = addslashes($middlename);
						$chinesename = addslashes($chinesename);
						$currentgrade = addslashes($currentgrade);					
				
				
			//------------------------ dob & enrolled ---------------------------
			
						$dob = $_POST[year_dob] . "-" . $_POST[month_dob] . "-" . $_POST[day_dob];
						$enrolled = $_POST[year_enrolled] . "-" . $_POST[month_enrolled] . "-" . $_POST[day_enrolled];

								
			//--------------------- set query -------------------------
			

						$createstatus = "1";
			
						$set = "status = '$status',
								appliesforgrade = '$appliesforgrade',
								pre_interview_res = '$pre_interview_res',
								lastname = '$lastname',
								firstname = '$firstname',
								middlename = '$middlename',
								chinesename = '$chinesename',
								enrolled = '$enrolled',
								preferedname = '$preferedname',
								sex = '$sex',
								descent = '$descent',
								dob = '$dob',
								pob = '$placeofbirth',
								nationality = '$nationality',
								passport_nb = '$passport_nb',
								passport_exp = '$passport_exp',
								currentgrade = '$currentgrade',
								exp_length_stay = '$exp_length_stay',
								lastupdate_ps = now(),
								lastupdate_edu = lastupdate_edu,
								lastupdate_med = lastupdate_med,
								lastupdate_emgc = lastupdate_emgc,
								lastupdate_lang = lastupdate_lang,
								lastupdate_general = now(),
								lastupdate_user = '$_SESSION[user_id]',
								iscreated_ps = '$createstatus'";
								
				
						
			//-------------------------- Update ------------------------------ 
			
			
				if($stud_id != "") {
					$update = mysql_query("UPDATE student SET $set WHERE stud_id='$stud_id'");
					
					//alright, let's check if the timestamp lastupdate_pa is empty / null, if so than it's a new student,
					//so let's send them to the next step student_emgc.php. Otherwise go back to student_hm.php
					
					$get = mysql_query("SELECT iscreated_pa FROM student WHERE stud_id='$stud_id'");
					if(mysql_num_rows($get) == "0") {
						
						//something went completely wrong .. 
						message("Invalid page. Please report this to the webmaster", "");
					
					} else {
					
						$getarray = mysql_fetch_array($get);

						if($getarray[iscreated_pa] == "0") { //this '0000-00-00 00:00:00 might change from server to server
							//send to the next step
							message("Information added to profile","student-pa.php?stud_id=$stud_id");
							exit();						
						} else {
							//send back to student_hm.php
							message("Student profile has been updated","student-hm.php?stud_id=$stud_id");
							exit();
						}
					
					}
					
				
			//---------------------------- Input new -------------------------------- 				
			
				} else {
				
					$insert = mysql_query("INSERT INTO student SET $set");
					$thisnewstudent = mysql_insert_id();

					
					
					//generate a unique student number
					
					$stud_number = date('y') . "-" . rand(10000, 99999);
					
					$temp_stud_number = "temp_" . $appliesforgrade . "-" . rand(10000, 99999);
					
					
						//quickly check if this number is taken already, quite unlikely
						$quickcheck = mysql_query("SELECT COUNT(*) FROM student WHERE stud_nb='$stud_number'");
						if(mysql_num_rows($quickcheck) > "0") {
							
							//generate a new number. We just assume this time it's a new one. Would be VERY unlikley that it's not
							
							$stud_number = date('y') . "-" . rand(10000, 99999);
							
						}
					
					//add the create date right away
					$update = mysql_query("UPDATE student SET createdate=now(), temp_stud_nb='$temp_stud_number', stud_nb='$stud_number' 
											WHERE stud_id='$thisnewstudent'");
					
					message("The student profile has been created. ($stud_number) <br>Forwarding you to the next step","student-pa.php?stud_id=$thisnewstudent");
					exit();			
				}
			
			
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {


		/*------------------------------------ Get all nations  ----------------------------*/
		
			$nations_array = array();
				$get = mysql_query("SELECT * FROM nations");
		
				if(mysql_num_rows($get) > "0"){
					while($getarray = mysql_fetch_array($get)){
					extract($getarray);
						$nations_array[$nation_id] .= "$nation_name";
					}
				}
		
		
		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[stud_id] != ""){
			
				$stud_id = $_GET[stud_id];
				$get = mysql_query("SELECT * FROM student WHERE stud_id='$stud_id'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
		
						//General
								
						//status
						if($status == "1") { 
								
							$statusdrop = "<select name=\"status\" size=\"1\" onchange=\"return showhide(form2a)\">
											<option name=\"1\" value=\"1\" selected>active</option>
											<option name=\"2\" value=\"0\">inactive</option>
											</select>";
											
							$preintbox = " <div id=\"form2a\" style=\"display:none\">
										Applies for Grade: 
										" .  dropdown($gradesarray,"appliesforgrade","$appliesforgrade","no") . "<br><br />
										Pre-Interview results<br />
										<br /> <textarea name=\"pre_interview_res\" rows=\"25\" style=\"width:520px;\" >
										{PREINTRES}</textarea></div>";
										
						} else {

							$statusdrop = "<select name=\"status\" size=\"1\" onchange=\"return showhide(form2a)\">
										<option name=\"1\" value=\"1\">active</option>
										<option name=\"2\" value=\"0\" selected>inactive</option>
										</select>";	
										
							$preintbox = " <div id=\"form2a\" style=\"display:block\">
										Applies for Grade: 
										" .  dropdown($gradesarray,"appliesforgrade","$appliesforgrade","no") . "<br><br />
										Pre-Interview results<br />
										<br /> <textarea name=\"pre_interview_res\" rows=\"25\" style=\"width:520px;\">$pre_interview_res</textarea></div>";					
						
						}
								
									
						$t->set_var("ADMINMSG","Updating student profile of: $firstname $middlename $lastname 
									[<a href='http://localhost/suis/student-hm.php?stud_id=$stud_id'>go back without changes</a>]");	
						$t->set_var("STATUSDROP", $statusdrop);	
						$t->set_var("PREINT", $preintbox);	
						$t->set_var("STUDID","$stud_id");			
						$t->set_var("LASTNAME","$lastname");
						$t->set_var("FIRSTNAME","$firstname");
						$t->set_var("MIDDLENAME","$middlename");
						$t->set_var("CHINESENAME","$chinesename");
						$t->set_var("PREFNAMEDROP", dropdown($preferedname_array,"preferedname","$preferedname","no"));
						$d = new date_to_dropdown();
						$t->set_var("ENROLLED", $d->datedropdown(date_for_drop($day,$month,$year), "no", "yes", "yes", "enrolled"));
						$d = new date_to_dropdown();
						$dobarray = explode("-", $dob);
						$t->set_var("DOBDROP", $d->datedropdown(date_for_drop($dobarray[2],$dobarray[1],$dobarray[0]), "no", "yes", "yes", "dob"));
						$t->set_var("SEXDROP", dropdown($sex_array,"sex","$sex","no"));
						$t->set_var("DESCENTDROP", dropdown($descent_array,"descent","$descent","no"));
						$t->set_var("PLACEOFBIRTH","$pob");
						$t->set_var("NATIONALITY", dropdown($nations_array,"nationality","$nationality","no"));
						$t->set_var("PASSPORTNB","$passport_nb");
						$t->set_var("PASSPORTEXP","$passport_exp");
						$t->set_var("CURRENTGRADE","$currentgrade");
						$t->set_var("EXPLENGTHSTAY","$exp_length_stay");
						
					}
					
		/*------------------------------- Create new student profile ----------------------------------*/

		
			} else {
					
			
						//status
						$statusdrop = "<select name=\"status\" size=\"1\" onchange=\"showhide('form2a')\">
										<option name=\"1\" value=\"1\">active</option>
										<option name=\"2\" value=\"0\">inactive</option>
										</select>";
										
						$preintbox = " <div id=\"form2a\" style=\"display:none\">
										Applies for Grade: " .  dropdown($gradesarray,"appliesforgrade","","no") . "<br><br />
										Pre-Interview results<br />
										<br /> <textarea name=\"pre_interview_res\" rows=\"25\" style=\"width:520px;\"></textarea>
										</div>";
						
							
						//General
									
						$t->set_var("ADMINMSG","Creating a new student profile (Step 1 / 6)");
						$t->set_var("STUDID","");	
						$t->set_var("PREINTRES", $pre_interview_res);	
						$t->set_var("STATUSDROP", $statusdrop);	
						$t->set_var("PREINT", $preintbox);			
						$t->set_var("LASTNAME","");
						$t->set_var("FIRSTNAME","");
						$t->set_var("MIDDLENAME","");
						$t->set_var("CHINESENAME","");
						$d = new date_to_dropdown();
						$t->set_var("ENROLLED", $d->datedropdown(date_for_drop($day,$month,$year), "no", "yes", "yes", "enrolled"));
						$t->set_var("PREFNAMEDROP", dropdown($preferedname_array,"preferedname","","no"));
						$d = new date_to_dropdown();
						$t->set_var("DOBDROP", $d->datedropdown(date_for_drop($day,$month,$year), "no", "yes", "yes", "dob"));
						$t->set_var("SEXDROP", dropdown($sex_array,"sex","","no"));
						$t->set_var("DESCENTDROP", dropdown($descent_array,"descent","","no"));
						$t->set_var("PLACEOFBIRTH","");
						$t->set_var("NATIONALITY", dropdown($nations_array,"nationality","$nationality","no"));
						$t->set_var("PASSPORTNB","");
						$t->set_var("PASSPORTEXP","");
						$t->set_var("CURRENTGRADE","");
						$t->set_var("EXPLENGTHSTAY","");
				

			} // if isset $stud_id
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>