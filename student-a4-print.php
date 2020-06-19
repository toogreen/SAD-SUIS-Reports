<?php
include ("login.php");
include ("template.inc");

dbConnect ('');
	
$a4 = 1;
$t = new Template("templates");

	$t->set_file(array(
			"body" => "admin_nav_a4.htm",
			"main" => "student_a4.htm",
			"form" => "student_hm.htm",
			"hm_ps" => "hm_ps.html",
			"hm_pa" => "hm_pa.html",
			"hm_edu" => "hm_edu.html",
			"hm_emgc" => "hm_emgc.html",
			"hm_med" => "hm_med.html",
			"hm_lang" => "hm_lang.html",
			"hm_comments" => "hm_comments.html",
			"hm_payment" => "hm_payment.html",
			"hm_attendance" => "hm_attendance.html",
			"hm_psycho" => "hm_psycho.html",
			"hm_adbe" => "hm_adbe.html"));


	// HEADER FOR admin_nav_a4.htm 
	$t->set_var(A4HEADER, "Personal Information Printout");
	
	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);

// ADDED THIS TO PRINT SEVERAL STUDENTS ON ONE PAGE:
//LEFT JOIN classes ON classes.class_id = student.class_id


			$rs = new MysqlPagedResultSet("SELECT * FROM student 
			
				WHERE student.class_id > '0' AND student.class_id='$_GET[class_id]' AND status > '0' AND archived = '0' ORDER BY student.firstname", "100","student-a4-print.php");					
			
						if($rs->getTotalNum() > "0") {
									
					
							while ($getarray = $rs->fetchArray()) {
							$stud_id = $getarray[stud_id]; 
							
							


	/*------------------------------------ Show student profile ----------------------------*/

		
			//if($_GET[stud_id] != ""){
//			if($stud_id != ""){
			
				//$stud_id = $_GET[stud_id];
				$get = mysql_query("SELECT * FROM student WHERE stud_id='$stud_id'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);			
	
						//Main Name
						if($preferedname == "0") {
							$t->set_var("MAINNAME","$firstname $middlename $lastname");
						} else {
							$t->set_var("MAINNAME","$chinesename");
						}
	
	
						//Student Number
						if($status == "0") {
							$t->set_var("STUDNB","$temp_stud_nb");
						} else {
							$t->set_var("STUDNB","$stud_nb");						
						}
						
										
						$t->set_var("PREINTRES","$intpre");		
							
						
					/*--------------------------- Check the user level -------------------*/
					
						if(checklevel("student_ps", $mylevel) == "0"){
							$t->set_var("STUDENTPS","");	
						} else {
							$t->parse(STUDENTPS,"hm_ps");	
						}
						
						//Make name capitals	
						$lastname_cap = $lastname;
						$lastname_cap = strtoupper($lastname_cap);	
						//$firstname_cap = $firstname;
						//$firstname_cap = strtoupper($firstname_cap);	
						
						
						//General
						$t->set_var("STUDID","$stud_id");	
						$t->set_var("STATUS","$status_array[$status]");	
						$t->set_var("PROFILECREATED","$createdate");			
						$t->set_var("LASTNAME","$lastname_cap");
						$t->set_var("ENROLLED","$enrolled");
						$t->set_var("FIRSTNAME","$firstname");
						$t->set_var("MIDDLENAME","$middlename");
						$t->set_var("CHINESENAME","$chinesename");
						$t->set_var("SEX","$sex_array[$sex]");
						$t->set_var("PREFNAMEDROP", $preferedname_array[$preferedname]);
						$t->set_var("DOBDROP", $dob);
						$t->set_var("SEXDROP", $sex_array[$sex]);
						$t->set_var("DESCENTDROP", $descent_array[$descent]);
						$t->set_var("PLACEOFBIRTH","$pob");
						$t->set_var("PASSPORTNB","$passport_nb");
						$t->set_var("PASSPORTEXP","$passport_exp");
						$t->set_var("CURRENTGRADE","$currentgrade");
						$t->set_var("EXPLENGTHSTAY","$exp_length_stay");
												
						//Parents
						if(checklevel("student_pa", $mylevel) == "0"){
							$t->set_var("STUDENTPA","");	
						} else {
							$t->parse(STUDENTPA,"hm_pa");	
						}
						
						$t->set_var("LEGALCUSTODIAN", $legalcustodian_array[$legalcustodian]);
						$t->set_var("FATHERLANGUAGEEN", $parentslanguageskills_array[$fatherenglish]);
						$t->set_var("FATHERLANGUAGECN", $parentslanguageskills_array[$fatherchinese]);
						$t->set_var("MOTHERLANGUAGEEN", $parentslanguageskills_array[$motherenglish]);
						$t->set_var("MOTHERLANGUAGECN", $parentslanguageskills_array[$motherchinese]);
	
						$t->set_var("FATHERNAME","$fathername");
						$t->set_var("FATHERNATIONALITY", "$fathernationality");
						$t->set_var("FATHERPHONE","$fatherphone");
						$t->set_var("FATHEREMAIL","$fatheremail");
						$t->set_var("FATHERPHONEMOBILE","$fatherphone_mobile");
						$t->set_var("FATHERPHONECOMPANY","$fatherphone_company");
						$t->set_var("FATHERCOMPANY","$fathercompany");
						$t->set_var("FATHERTITLE","$fathertitle");
						$t->set_var("FATHERCOMPANYADDRESS","$fathercompanyaddress");
						$t->set_var("FATHERHOMEADDRESS","$fatherhomeaddress");
						$t->set_var("FATHERNATIVE", "$fathernative");
						
						$t->set_var("MOTHERNAME","$mothername");
						$t->set_var("MOTHERNATIONALITY", "$mothernationality");
						$t->set_var("MOTHERPHONE","$motherphone");
						$t->set_var("MOTHEREMAIL","$motheremail");
						$t->set_var("MOTHERPHONEMOBILE","$motherphone_mobile");
						$t->set_var("MOTHERPHONECOMPANY","$motherphone_company");
						$t->set_var("MOTHERCOMPANY","$mothercompany");
						$t->set_var("MOTHERTITLE","$mothertitle");
						$t->set_var("MOTHERCOMPANYADDRESS","$mothercompanyaddress");
						$t->set_var("MOTHERHOMEADDRESS","$motherhomeaddress");
						$t->set_var("MOTHERNATIVE", "$mothernative");
						
						$t->set_var("CARER","$carer");
						$t->set_var("PARENTSOTHERS", "$parentsothers");
							
							
												
						//Education Background
						if(checklevel("student_edu", $mylevel) == "0"){
							$t->set_var("STUDENTEDU","");	
						} else {
							$t->parse(STUDENTEDU,"hm_edu");	
						}
						$t->set_var("SKIPPEDGRADE","$skippedgrade");
						$t->set_var("SUSPENDED","$suspended");
						$t->set_var("REPEATEDGRADE","$repeatedgrade");
						$t->set_var("BEHAVIORPROBLEMS","$behaviorproblems");
						$t->set_var("BEHAVIORMANAGEMENT","$behaviormanagement");
						$t->set_var("INDITESTING","$indi_testing");
						$t->set_var("BACKGROUNDOTHERS","$background_others");
						
						//Emergency
						if(checklevel("student_emgc", $mylevel) == "0"){
							$t->set_var("STUDENTEMGC","");	
						} else {
							$t->parse(STUDENTEMGC,"hm_emgc");	
						}
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
						if(checklevel("student_med", $mylevel) == "0"){
							$t->set_var("STUDENTMED","");	
						} else {
							$t->parse(STUDENTMED,"hm_med");	
						}
						
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
						if(checklevel("student_lang", $mylevel) == "0"){
							$t->set_var("STUDENTLANG","");	
						} else {
							$t->parse(STUDENTLANG,"hm_lang");	
						}
						
						$t->set_var("LANGENGLISHHOMEDROP", dropdown($lang_english_home_array,"lang_english_home","$lang_english_home","no"));
						
						$t->set_var("LANGNATIVE","$lang_native");
						$t->set_var("LANGSECOND","$lang_second");
						$t->set_var("LANGOTHERS","$lang_others");
						$t->set_var("LANGENGLISHHOME","$lang_english_home");
						
						// ADDED THESE 6 IN JUNE 2010
						$t->set_var("LANGENGLISHLEVEL","$lang_english_level");
						$t->set_var("LANGCHINESELEVEL","$lang_chinese_level");
						
						// Maths level check, then set proper text to display
						if($lang_maths_level == 1) {
								$t->set_var("LANGMATHSLEVEL","Chinese Maths");
							} else {
								$t->set_var("LANGMATHSLEVEL","English Maths");
						}	
						$t->set_var("LANGORTLEVEL","$lang_ort_level");
						$t->set_var("LANGSPECIALNEEDS","$lang_specialneeds");
						$t->set_var("LANGEAL","$lang_eal");
						
						$t->set_var("LANGENGLISHFULLTIME","$lang_englishfulltime");
						$t->set_var("LANGENGLISHYEARS","$lang_english_years");
						$t->set_var("PRIVATETUTORING","$private_tutoring");
						$t->set_var("LANGENGLISHPRIVATETUTOR","$lang_english_private_tutor");
						$t->set_var("LANGENGLISHPRIVATEHOME","$lang_english_private_home");
						$t->set_var("LANGENGLISHPRIVATESCHOOL","$lang_english_private_school");
						$t->set_var("SUMMERSCHOOL","$summerschool");
						$t->set_var("OUTSIDESCHOOL","$outsideschool");
						
						
						/*----------------------------------- Classroom ------------------------------------*/
						
						
							
							if($_GET[editclassroom] != "true") {
							
								if($class_id == "0") {
								
									$t->set_var("CLASSNAME", "No Classroom yet");
									
								} else {
								
									//get the classroom name and stuff
									$select = mysql_query("SELECT class_name, class_ht FROM classes WHERE class_id='$class_id'");
									$getarray = mysql_fetch_array($select);
									
									$t->set_var("CLASSNAME", $getarray[class_name]);
									$t->set_var("CLASSHT",$getarray[class_ht]);									

								}

							}
							

						
						/*----------------------------------- Nationality ------------------------------------*/
						
								$get = mysql_query("SELECT nation_name FROM nations WHERE nation_id=$nationality");
								$getarray = mysql_fetch_array($get);
								
								 $t->set_var("NATIONALITY","$getarray[nation_name]");
								
						
						/*----------------------------------- Last update ------------------------------------*/
						
							//lets do another query for this, as SQL is much better to get a nice date output than PHP
							//just can't do it in the first query
							
								$get = mysql_query("SELECT lastupdate_user, DATE_FORMAT(lastupdate_general, '%b %D %y, %H:%i') AS lupdated 
													FROM student 
													WHERE stud_id='$stud_id'");
													
									if(mysql_num_rows($get) > "0"){
									$getarray = mysql_fetch_array($get);
									extract($getarray);	
									
									$t->set_var("LUPDATE","$lupdated");
								
								}
								
							//and who did it ... ?
							
								$get = mysql_query("SELECT uid AS lastupdateuser FROM user WHERE user_id='$lastupdate_user'");
								if(mysql_num_rows($get) > "0"){
									$getarray = mysql_fetch_array($get);
									extract($getarray);	
									
									$t->set_var("LUPDATEUSER","$lastupdateuser");
								
								}
								
					
				
						/*------------------------------------ Detentions  ----------------------------*/
						
								$getdet = mysql_query("SELECT det_id, det_by, det_date, det_txt 
														FROM detentions 
														WHERE det_stud_id='$stud_id'");
														
									if(mysql_num_rows($getdet) > "0"){
										
										while($getarray = mysql_fetch_array($getdet)) {
										
										$detout .= "$getarray[det_date]  by $getarray[bus_route] $getarray[det_txt]";
										}
										$t->set_var("DETENTIONS","$detout");
									
									} else {
									
										$t->set_var("DETENTIONS","No comments yet.");
										
									}
								
								
								
						/*------------------------------------ Attendance  ----------------------------*/
						
								$getatt = mysql_query("SELECT att_date, attend_id, attend.att_stud_id, att_status 
																FROM attend 
																WHERE attend.att_stud_id='$stud_id'
																AND att_status > '0'
																ORDER BY att_date");
															
										if(mysql_num_rows($getatt) > "0"){
											
											while($getarray = mysql_fetch_array($getatt)) {
											
											$status = $getarray[att_status];
											$attend_out .= "$getarray[att_date] - $attend_array[$status]<BR>";
											}
											$t->set_var("ATTENDENCE","$attend_out");
										
										} else {
										
											$t->set_var("ATTENDENCE","<br>No data yet");
											
										}
							
								
								
						/*------------------------------------ Psycho Session  ----------------------------*/
						

								$getatt = mysql_query("SELECT sess_id, sess_date, sess_user, user.uid AS sess_user_out 
																FROM psycho_session 
																LEFT JOIN user ON user.user_id=psycho_session.sess_user
																WHERE sess_stud_id='$stud_id'
																ORDER BY sess_date");
															
										if(mysql_num_rows($getatt) > "0"){
											
											while($getarray = mysql_fetch_array($getatt)) {
											
											$ps_sess_out .= "$getarray[sess_date] by $getarray[sess_user_out]";
											}
											$t->set_var("PSYCHOSESSION","$ps_sess_out");
										
										} else {
										
											$t->set_var("PSYCHOSESSION","No reports yet.");
											
										}
								
								
						/*------------------------------------ Dorm  ----------------------------*/
						
				
									$t->set_var("DORM","$dorm_array[$dorm]");							
							

						/*------------------------------------ Payment  ----------------------------*/
						

									$t->set_var("PAYMENT","$payment_array[$pay_tut]");
								

						/*------------------------------------ Transportation  ----------------------------*/


	
										$getbus = mysql_query("SELECT bus.bus_id, bus_name, bus_route 
																FROM bus 
																WHERE bus.bus_id=$bus");
										
										$getarray = mysql_fetch_array($getbus);

										$t->set_var("BUSOUT","$getarray[bus_name] - $getarray[bus_route]");
									
							
// END OF SCRIPTS BELOW							
					}
			



		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		}
}

?>
