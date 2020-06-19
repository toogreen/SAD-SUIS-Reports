<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$stud_id = $_POST[stud_id];
						$lastname = $_POST[lastname];
						$fistname = $_POST[firstname];
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
						$skippedgrade = $_POST[skippedgrade];
						$suspended = $_POST[suspended];
						$repeatedgrade = $_POST[repeatedgrade];
						$behaviorproblems = $_POST[behaviorproblems];
						$behaviormanagement = $_POST[behaviormanagement];
						$indi_testing = $_POST[indi_testing];
						$background_others = $_POST[background_others];
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
						$medicine = $_POST[medicine];
						$contactlenses = $_POST[contactlenses];
						$physicalactivity = $_POST[physicalactivity];
						$lang_english_home = $_POST[lang_english_home];
						$lang_native = $_POST[lang_native];
						$lang_second = $_POST[lang_second];
						$lang_others = $_POST[lang_others];
						$lang_english_home = $_POST[lang_english_home];
						$lang_englishfulltime = $_POST[lang_englishfulltime];
						$lang_english_years = $_POST[lang_english_years];
						$private_tutoring = $_POST[private_tutoring];
						$lang_english_private_tutor = $_POST[lang_english_private_tutor];
						$lang_english_private_home = $_POST[lang_english_private_home];
						$lang_english_private_school = $_POST[lang_english_private_school];
						$summerschool = $_POST[summerschool];
						$outsideschool = $_POST[outsideschool];
					
						
			//---------------- make the text save --------------------
			
				$currentgrade = addslashes($currentgrade);
				$skippedgrade = addslashes($skippedgrade);
				$suspended = addslashes($suspended);
				$repeatedgrade = addslashes($repeatedgrade);
				$behaviorproblems = addslashes($behaviorproblems);
				$behaviormanagement = addslashes($behaviormanagement);
				$indi_testing = addslashes($indi_testing);
				$background_others = addslashes($background_others);
				$medicine = addslashes($medicine);
				$physicalactivity = addslashes($physicalactivity);
				$summerschool = addslashes($summerschool);
				$outsideschool = addslashes($outsideschool);
					
				
			//------------------------ dob ---------------------------
			
				$dob = $_POST[year] . "-" . $_POST[month] . "-" . $_POST[day];
				
				
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
			
						$set = "lastname = '$lastname',
								firstname = '$firstname',
								middlename = '$middlename',
								chinesename = '$chinesename',
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
								skippedgrade = '$skippedgrade',
								suspended = '$suspended',
								repeatedgrade = '$repeatedgrade',
								behaviorproblems = '$behaviorproblems',
								behaviormanagement = '$behaviormanagement',
								indi_testing = '$indi_testing',
								background_others = '$background_others',
								emgc_contact = '$emgc_contact',
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
								medicine = '$medicine',
								contactlenses = '$contactlenses',
								immunization = '$immunization_in',
								diseas = '$diseas_in',
								medical_others = '$medical_others_in',
								physicalactivity = '$physicalactivity',
								lang_native = '$lang_native',
								lang_second = '$lang_second',
								lang_others = '$lang_others',
								lang_english_home = '$lang_english_home',
								lang_englishfulltime = '$lang_englishfulltime',
								lang_english_years = '$lang_english_years',
								private_tutoring = '$private_tutoring',
								lang_english_private_tutor = '$lang_english_private_tutor',
								lang_english_private_home = '$lang_english_private_home',
								lang_english_private_school = '$lang_english_private_school',
								summerschool = '$summerschool',
								outsideschool = '$outsideschool'";
								
						
						
			//-------------------------- Input new ------------------------------ 
			
			
				if($stud_id != "") {
					$update = mysql_query("UPDATE student SET $set WHERE stud_id='$stud_id'");
					message("updated","student.php");
					exit();

			//---------------------------- Update -------------------------------- 				
			
				} else {
					$set = mysql_query("INSERT INTO student SET $set");
					message("added","student.php");
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
					echo("yes $lastname");
			
	
						//General
									
						$t->set_var("STUDID","$stud_id");			
						$t->set_var("LASTNAME","$lastname");
						$t->set_var("FIRSTNAME","$firstname");
						$t->set_var("MIDDLENAME","$middlename");
						$t->set_var("CHINESENAME","$chinesename");
						$t->set_var("PREFNAMEDROP", dropdown($preferedname_array,"preferedname","$preferedname","no"));
						$d = new date_to_dropdown();
						$dobarray = explode("-", $dob);
						$t->set_var("DOBDROP", $d->datedropdown(date_for_drop($dobarray[2],$dobarray[1],$dobarray[0]), "no", "yes", "yes"));
						$t->set_var("SEXDROP", dropdown($sex_array,"sex","$sex","no"));
						$t->set_var("DESCENTDROP", dropdown($descent_array,"descent","$descent","no"));
						$t->set_var("PLACEOFBIRTH","$pob");
						$t->set_var("NATIONALITY","$nationality");
						$t->set_var("PASSPORTNB","$passport_nb");
						$t->set_var("PASSPORTEXP","$passport_exp");
						$t->set_var("CURRENTGRADE","$currentgrade");
						$t->set_var("EXPLENGTHSTAY","$exp_length_stay");
												
						//Education Background
						
						$t->set_var("SKIPPEDGRADE","$skippedgrade");
						$t->set_var("SUSPENDED","$suspended");
						$t->set_var("REPEATEDGRADE","$repeatedgrade");
						$t->set_var("BEHAVIORPROBLEMS","$behaviorproblems");
						$t->set_var("BEHAVIORMANAGEMENT","$behaviormanagement");
						$t->set_var("INDITESTING","$indi_testing");
						$t->set_var("BACKGROUNDOTHERS","$background_others");
						
						//Emergency
						
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
						
						
						//Language
						$t->set_var("LANGENGLISHHOMEDROP", dropdown($lang_english_home_array,"lang_english_home","$lang_english_home","no"));
						
						$t->set_var("LANGNATIVE","$lang_native");
						$t->set_var("LANGSECOND","$lang_second");
						$t->set_var("LANGOTHERS","$lang_others");
						$t->set_var("LANGENGLISHHOME","$lang_english_home");
						$t->set_var("LANGENGLISHFULLTIME","$lang_englishfulltime");
						$t->set_var("LANGENGLISHYEARS","$lang_english_years");
						$t->set_var("PRIVATETUTORING","$private_tutoring");
						$t->set_var("LANGENGLISHPRIVATETUTOR","$lang_english_private_tutor");
						$t->set_var("LANGENGLISHPRIVATEHOME","$lang_english_private_home");
						$t->set_var("LANGENGLISHPRIVATESCHOOL","$lang_english_private_school");
						$t->set_var("SUMMERSCHOOL","$summerschool");
						$t->set_var("OUTSIDESCHOOL","$outsideschool");
						
					}


				


		/*------------------------------- Create new student profile ----------------------------------*/

		
			} else {
			
		
				//General
							
				$t->set_var("STUDID","");			
				$t->set_var("LASTNAME","");
				$t->set_var("FIRSTNAME","");
				$t->set_var("MIDDLENAME","");
				$t->set_var("CHINESENAME","");
				$t->set_var("PREFNAMEDROP", dropdown($preferedname_array,"preferedname","","no"));
				$d = new date_to_dropdown();
				$t->set_var("DOBDROP", $d->datedropdown(date_for_drop($day,$month,$year), "no", "yes", "yes"));
				$t->set_var("SEXDROP", dropdown($sex_array,"sex","","no"));
				$t->set_var("DESCENTDROP", dropdown($descent_array,"descent","","no"));
				$t->set_var("PLACEOFBIRTH","");
				$t->set_var("NATIONALITY","");
				$t->set_var("PASSPORTNB","");
				$t->set_var("PASSPORTEXP","");
				$t->set_var("CURRENTGRADE","");
				$t->set_var("EXPLENGTHSTAY","");
				
				//Education Background
				
				$t->set_var("SKIPPEDGRADE","");
				$t->set_var("SUSPENDED","");
				$t->set_var("REPEATEDGRADE","");
				$t->set_var("BEHAVIORPROBLEMS","");
				$t->set_var("BEHAVIORMANAGEMENT","");
				$t->set_var("INDITESTING","");
				$t->set_var("BACKGROUNDOTHERS","");
				
				//Emergency
				
				$t->set_var("EMGCCONTACT","");
				$t->set_var("EMGCRELATIONSHIP","");
				$t->set_var("EMGCPHONE","");
				$t->set_var("EMGCMOBILE","");
				$t->set_var("EMGCOFFICE","");
				$t->set_var("EMGCEMAIL","");
				
				$t->set_var("EMGC2CONTACT","");
				$t->set_var("EMGC2RELATIONSHIP","");
				$t->set_var("EMGC2PHONE","");
				$t->set_var("EMGC2MOBILE","");
				$t->set_var("EMGC2OFFICE","");
				$t->set_var("EMGC2EMAIL","");
				
				
				//Medical
				
				foreach($immunizations_array as $key=>$element){
						$immu_out .= "<input name='immunization[]' type='checkbox' value='$key'> $element<br>";
					}
				$t->set_var ("IMMUNIZATIONS", $immu_out);
				
				foreach($diseas_array as $key=>$element){
						$dis_out .= "<input name='diseas[]' type='checkbox' value='$key'> $element<br>";
					}
				$t->set_var ("DISEASES", $dis_out);

				
				foreach($medical_others_array as $key=>$element){
						$med_out .= "<input name='medical_others[]' type='checkbox' value='$key'> $element<br>";
				}
				$t->set_var ("MEDICALOTHERS", $med_out);

				
				$t->set_var("MEDICINE","");
				$t->set_var("CONTACTLENSES", dropdown($contactlenses_array,"contactlenses","","no"));
				$t->set_var("PHYSICALACTIVITY","");
				
				
				//Language
				$t->set_var("LANGENGLISHHOMEDROP", dropdown($lang_english_home_array,"lang_english_home","","no"));
				
				$t->set_var("LANGNATIVE","");
				$t->set_var("LANGSECOND","");
				$t->set_var("LANGOTHERS","");
				$t->set_var("LANGENGLISHHOME","");
				$t->set_var("LANGENGLISHFULLTIME","");
				$t->set_var("LANGENGLISHYEARS","");
				$t->set_var("PRIVATETUTORING","");
				$t->set_var("LANGENGLISHPRIVATETUTOR","");
				$t->set_var("LANGENGLISHPRIVATEHOME","");
				$t->set_var("LANGENGLISHPRIVATESCHOOL","");
				$t->set_var("SUMMERSCHOOL","");
				$t->set_var("OUTSIDESCHOOL","");


			} // if isset $stud_id
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>