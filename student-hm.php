<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

if(isset($print)) {

	$t->set_file(array(
			"body" => "student_hm_print.htm",
			"main" => "student.htm",
			"form" => "student_hm_print.htm",
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
		
} else {

	$t->set_file(array(
			"body" => "admin_nav.htm",
			"main" => "student.htm",
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

}

	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	

	/*------------------------------- move student to archives --------------------------------------*/
	

		if($_GET[move2archives] == "true") {

			 
			//then update the class
			$update = mysql_query("UPDATE student SET 
								   	lastupdate_ps = lastupdate_ps,
									lastupdate_pa = lastupdate_pa,
									lastupdate_edu = lastupdate_edu,
									lastupdate_med = lastupdate_med,
									lastupdate_emgc = lastupdate_emgc,
									lastupdate_lang = lastupdate_lang,
									lastupdate_general = lastupdate_general,
									archived = '1'
								  	WHERE stud_id='$_GET[stud_id]' LIMIT 1");
									
			message("Student moved to archives","student.php");
			exit();
		}
		
		
	/*------------------------------- change the class .. machen wir im moment nal hier --------------------------------------*/
	

		if(isset($_GET[submitclasschange])) {

			//now this is a bit more tricky, we need to set the capacity of his new classroom -1 and 
			//of his old classroom +1. But we first need to know what's his old classroom.
			
				//get the old class
				$check = mysql_query("SELECT class_id AS oldclass FROM student WHERE stud_id='$_GET[stud_id]'");
				$getarray = mysql_fetch_array($check);
			
				//take one off
				$minus = mysql_query("UPDATE classes SET class_capacity_used=class_capacity_used-1 WHERE class_id='$getarray[oldclass]'");
				
				//add to the new class
				$plus = mysql_query("UPDATE classes SET class_capacity_used=class_capacity_used+1 WHERE class_id='$_GET[movetoclass]'");
		
		
			//quickly get the name of the class
			$getname = mysql_query("SELECT class_name FROM classes WHERE class_id='$_GET[movetoclass]'");
			$getarray = mysql_fetch_array($getname);
			
			
			//then update the class
			$update = mysql_query("UPDATE student 
								   	SET class_id='$_GET[movetoclass]',
								   	lastupdate_ps = lastupdate_ps,
									lastupdate_pa = lastupdate_pa,
									lastupdate_edu = lastupdate_edu,
									lastupdate_med = lastupdate_med,
									lastupdate_emgc = lastupdate_emgc,
									lastupdate_lang = lastupdate_lang,
									lastupdate_general = lastupdate_general
								  	WHERE stud_id='$_GET[stud_id]' LIMIT 1");
									
			message("Student added to class $getarray[class_name]","student-hm.php?stud_id=$_GET[stud_id]");
			exit();
		}
		
	
	//---------------- Add student to bus --------------------
	
		if(isset($_GET[submitbus])) {
		
			//then update the class
			$update = mysql_query("UPDATE student 
								   	SET bus='$_GET[bus]',
								   	lastupdate_ps = lastupdate_ps,
									lastupdate_pa = lastupdate_pa,
									lastupdate_edu = lastupdate_edu,
									lastupdate_med = lastupdate_med,
									lastupdate_emgc = lastupdate_emgc,
									lastupdate_lang = lastupdate_lang,
									lastupdate_general = lastupdate_general
								  	WHERE stud_id='$_GET[stud_id]' LIMIT 1");
									

				if($_GET[bus] > "0") {
					$update = mysql_query("UPDATE bus SET bus_capacityused=bus_capacityused+1 WHERE bus_id='$_GET[bus]'");
				}
				
				message("Transportation information updated", "student-hm.php?stud_id=$_GET[stud_id]");
				exit();
				
			
		}
			
	/*------------------------------- change payment thigs--------------------------------------*/
	

		if(isset($_GET[changepayment])) {
		
				//--------------------------- Check the level ------------------------------//		
					if(checklevel("student_payment", $mylevel) < "2"){
						message("You have no permission to perform this operation", "student-hm.php?stud_id=$_GET[stud_id]", "3");
					exit(); }
				//--------------------------------------------------------------------------//	


			$pay_seat_deadline = $_GET[year_pay_seat_deadline] . "-" . $_GET[month_pay_seat_deadline] . "-" . $_GET[day_pay_seat_deadline];
			
			//then update the class
			$update = mysql_query("UPDATE student 
								   	SET pay_tut ='$_GET[pay_tut]',
									pay_appl ='$_GET[pay_appl]',
									pay_seat ='$_GET[pay_seat]',
									pay_seat_deadline = '$pay_seat_deadline',
									pay_bus ='$_GET[pay_bus]',
									pay_dorm ='$_GET[pay_dorm]',
									pay_uni ='$_GET[pay_uni]',
									pay_by ='$_GET[pay_by]',
									pay_met ='$_GET[pay_met]',
									pay_comment ='$_GET[pay_comment]',
								   	lastupdate_ps = lastupdate_ps,
									lastupdate_pa = lastupdate_pa,
									lastupdate_edu = lastupdate_edu,
									lastupdate_med = lastupdate_med,
									lastupdate_emgc = lastupdate_emgc,
									lastupdate_lang = lastupdate_lang,
									lastupdate_general = lastupdate_general
								  	WHERE stud_id='$_GET[stud_id]' LIMIT 1");
									
			message("Payment details updated","student-hm.php?stud_id=$_GET[stud_id]#payment");
			exit();
		}
		
		
	/*------------------------------- change the schooldorm thing --------------------------------------*/
	

		if(isset($_GET[changedorm])) {
			
			//then update the class
			$update = mysql_query("UPDATE student SET
									dorm ='$_GET[dorm]',
								   	lastupdate_ps = lastupdate_ps,
									lastupdate_pa = lastupdate_pa,
									lastupdate_edu = lastupdate_edu,
									lastupdate_med = lastupdate_med,
									lastupdate_emgc = lastupdate_emgc,
									lastupdate_lang = lastupdate_lang,
									lastupdate_general = lastupdate_general
								  	WHERE stud_id='$_GET[stud_id]' LIMIT 1");
									
			message("Student boarding information updated","student-hm.php?stud_id=$_GET[stud_id]#dorm");
			exit();
		}
		
		

		
	/*------------------------------- stud id check --------------------------------
	
		//this page shows a studens profile, so it do doesn't make any 
		//sense if it doesn't have a $_GET[stud_id]
		
		if((!isset($_GET[stud_id])) || ($_GET[stud_id] == "")) {
		
			message("This page is invalid. If you've been refered to this page through a link, please report this bug to the webmaster","student.php");
			exit();
		}
		
	------*/	

	/*------------------------------------ Show student profile ----------------------------*/
		
		
			if($_GET[stud_id] != ""){
			
				$stud_id = $_GET[stud_id];
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
						
						
					//Pre int result
					    if($status == "0") {
							$intpre = "<tr bgcolor=\"#FAFAFA\">
										<td height=\"34\">Pre-Interview results</td>
										<td height=\"34\">$pre_interview_res</td>
										</tr>";
						} else {	
							$intpre = "";
						}		
						
						$t->set_var("PREINTRES","$intpre");		
							
						
					/*--------------------------- Check the user level -------------------*/
					
						if(checklevel("student_ps", $mylevel) == "0"){
							$t->set_var("STUDENTPS","");	
						} else {
							$t->parse(STUDENTPS,"hm_ps");	
						}
						
						//General
						$t->set_var("STUDID","$stud_id");	
						$t->set_var("STATUS","$status_array[$status]");	
						$t->set_var("PROFILECREATED","$createdate");			
						$t->set_var("LASTNAME","$lastname");
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
						
						$t->set_var("CARER", "$carer");
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
						
						
						// ADDED THESE NEXT 4 IN JUNE 2010
						$t->set_var("LANGENGLISHLEVELDROP", dropdown($lang_english_level_array,"lang_english_level","$lang_english_level","no"));
						$t->set_var("LANGCHINESELEVELDROP", dropdown($lang_chinese_level_array,"lang_chinese_level","$lang_chinese_level","no"));
						$t->set_var("LANGMATHSLEVELDROP", dropdown($lang_maths_level_array,"lang_maths_level","$lang_maths_level","no"));
						$t->set_var("LANGORTLEVELDROP", dropdown($lang_ort_level_array,"lang_ort_level","$lang_ort_level","no"));
						
						$t->set_var("LANGNATIVE","$lang_native");
						$t->set_var("LANGSECOND","$lang_second");
						$t->set_var("LANGOTHERS","$lang_others");
						$t->set_var("LANGENGLISHHOME","$lang_english_home");
						
						// ADDED THESE NEXT 6 IN JUNE 2010
						$t->set_var("LANGENGLISHLEVEL","$lang_english_level");
						$t->set_var("LANGCHINESELEVEL","$lang_chinese_level");
						$t->set_var("LANGMATHSLEVEL","$lang_maths_level");
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
								
									$t->set_var("CLASSROOM", "No Classroom yet [<a href='$PHP_SELF?stud_id=$stud_id&editclassroom=true#classroom'>change this</a>]<br><br>");
									$t->set_var("CLASSNAME", "No Classroom yet");
									
								} else {
								
									//get the classroom name and stuff
									$select = mysql_query("SELECT class_name FROM classes WHERE class_id='$class_id'");
									$getarray = mysql_fetch_array($select);
									
									$t->set_var("CLASSNAME", $getarray[class_name]);									
									$t->set_var("CLASSROOM", "In Class $getarray[class_name] [<a href='$PHP_SELF?stud_id=$stud_id&editclassroom=true#classroom'>
															change this</a>]<br><br>");
								}
							
							/* ---------- edit classroom ------------- */
							
							} else {
							
								
										$get = mysql_query("SELECT class_id, class_name, class_capacity, class_capacity_used FROM classes");
												
											if(mysql_num_rows($get) > "0"){
												while($getarray_classes = mysql_fetch_array($get)){
	
													//current capacity
													
													$current_cap = $getarray_classes[class_capacity] - $getarray_classes[class_capacity_used];
													
													$classdrop .= "<option value='$getarray_classes[class_id]'>$getarray_classes[class_name] - 
																	capacity : $current_cap</option>";
												}
											}
										
										
									if($getarray[class_id] == "0"){
									
										$t->set_var("CLASSNAME", "<font color='#fe0249'>No classroom yet. Set classroom below</font>");
										$t->set_var("CLASSROOM","<form name=\"busform\" method=\"get\" action=\"student-hm.php\"> No classroom yet. 
																Set to 
																<select name=\"movetoclass\" style=\"width: 200px;\">
																$classdrop</select> <input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />
																<input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />
																<input type=\"submit\" name=\"submitclasschange\" value=\"Add \" style=\"font-size: 10px;\"/></form>");
										
									} else {
									
										$select = mysql_query("SELECT class_name FROM classes WHERE class_id='$getarray[class_id]'");
										if(mysql_num_rows($select) != "0") {
											$getarray = mysql_fetch_array($select);
											$t->set_var("CLASSNAME", $getarray[class_name]);
											$t->set_var("CLASSROOM", "<form name=\"busform\" method=\"get\" action=\"student-hm.php\"> 
											Current classroom $getarray[class_name]. 
															Change to 
															<select name=\"movetoclass\" style=\"width: 200px;\">
															$classdrop</select> <input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />
															<input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />
															<input type=\"submit\" name=\"submitclasschange\" value=\"Add \" style=\"font-size: 10px;\"/></form>");
										} else {
											$t->set_var("CLASSNAME", "Class doesn't exist");
											$t->set_var("CLASSROOM", "");
										}
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
						
							if(checklevel("student_det", $mylevel) == "0"){
								$t->set_var("STUDENTCOMMENTS","");	
							} else {
								$t->parse(STUDENTCOMMENTS,"hm_comments");	
							}
						
						
								$getdet = mysql_query("SELECT det_id, det_by, det_date, det_txt 
														FROM detentions 
														WHERE det_stud_id='$stud_id'");
														
									if(mysql_num_rows($getdet) > "0"){
										
										while($getarray = mysql_fetch_array($getdet)) {
										
										$detout .= "<div class='dtn_rows'><h1>$getarray[det_date]  by $getarray[bus_route]</h1> $getarray[det_txt] 
													[ <a href='comment_edit.php?det_id=$getarray[det_id]'>edit</a> | 
													<a href='comment_edit.php?delete=true&det_id=$getarray[det_id]'>delete</a>]</div>";
										}
										$t->set_var("DETENTIONS","$detout<br> <a href='comment_edit.php?stud_id=$stud_id'>
																Add a comment for $firstname $lastname $chinesename</a>");
									
									} else {
									
										$t->set_var("DETENTIONS","<br>No comments yet. <a href='comment_edit.php?stud_id=$stud_id'>Add one</a><br><br>");
										
									}
								
								
								
						/*------------------------------------ Attendance  ----------------------------*/
						
							if(checklevel("student_attendance", $mylevel) == "0"){
								$t->set_var("STUDENTATTENDANCE","");	
							} else {
								$t->parse(STUDENTATTENDANCE,"hm_attendance");	
							}
							
							
								$getatt = mysql_query("SELECT att_date, attend_id, attend.att_stud_id, att_status 
																FROM attend 
																WHERE attend.att_stud_id='$stud_id'
																AND att_status > '0'
																ORDER BY att_date");
															
										if(mysql_num_rows($getatt) > "0"){
											
											while($getarray = mysql_fetch_array($getatt)) {
											
											$status = $getarray[att_status];
											$attend_out .= "<div class='attend_rows'>
															$getarray[att_date] - $attend_array[$status] 
															[<a href='attendance.php?searchdate=$getarray[att_date]&search=search'>update</a>]
															</div>";
											}
											$t->set_var("ATTENDENCE","$attend_out");
										
										} else {
										
											$t->set_var("ATTENDENCE","<br>No data yet");
											
										}
							
								
								
						/*------------------------------------ Psycho Session  ----------------------------*/
						
							if(checklevel("student_psycho", $mylevel) == "0"){
								$t->set_var("STUDENTPSYCHO","");	
							} else {
								$t->parse(STUDENTPSYCHO,"hm_psycho");	
							}
							
							
								$getatt = mysql_query("SELECT sess_id, sess_date, sess_user, user.uid AS sess_user_out 
																FROM psycho_session 
																LEFT JOIN user ON user.user_id=psycho_session.sess_user
																WHERE sess_stud_id='$stud_id'
																ORDER BY sess_date");
															
										if(mysql_num_rows($getatt) > "0"){
											
											while($getarray = mysql_fetch_array($getatt)) {
											
											$ps_sess_out .= "<div class='attend_rows'>
															$getarray[sess_date] by $getarray[sess_user_out] 
															[<a href='ps_session_edit.php?sess_id=$getarray[sess_id]'>show</a>]
															</div>";
											}
											$t->set_var("PSYCHOSESSESION","$ps_sess_out");
										
										} else {
										
											$t->set_var("PSYCHOSESSESION","<br>No reports yet. <a href='ps_session_edit.php?add=true&stud_id=$stud_id'>Add one</a>");
											
										}
								
								
						/*------------------------------------ Dorm  ----------------------------*/
						
						
							if($_GET[editdorm] != "true") {
	
									$t->set_var("DORM","$dorm_array[$dorm] [<a href='$PHP_SELF?stud_id=$stud_id&editdorm=true#dorm'>change this</a>]<br><br>");							
							
							} else {
							
								//edit dorm information. The only difference between the two version below is that one has t}he
								//button labled edit and the other one submit. There would be smarter solutions, but then ... wgaf
								
								if($dorm == "0") {
							
									$t->set_var("DORM","<br><form name=\"dormform\" method=\"get\" action=\"student-hm.php\">Student accommodation : 
														" . dropdown($dorm_array,"dorm","$dorm","no") . 
														"<input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />
														<input type=\"submit\" name=\"changedorm\" value=\"Set \" style=\"font-size: 10px;\"/>");
								
								} else {
								
									$t->set_var("DORM","<br><form name=\"dormform\" method=\"get\" action=\"student-hm.php\">Student accommodation : 
														" . dropdown($dorm_array,"dorm","$dorm","no") . 
														"<input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />
														<input type=\"submit\" name=\"changedorm\" value=\"Change \" style=\"font-size: 10px;\"/>");	
								}
							
							
							}
							
							
						/*------------------------------------ Payment  ----------------------------*/
						
						
							if(checklevel("student_payment", $mylevel) == "0"){
								$t->set_var("STUDENTPAYMENT","");	
							} else {
								$t->parse(STUDENTPAYMENT,"hm_payment");	
							}
							
							
							if($_GET[editpayment] != "true") {						
									
									$payment .= "<div class='attend_rows'>Tuition Fee:  $payment_array[$pay_tut]</div>";
									$payment .= "<div class='attend_rows'>Application Fee:  $payment_array[$pay_appl]</div>";
									$payment .= "<div class='attend_rows'>Seat deposit Fee:  $payment_array[$pay_sat] | Deadline: $pay_seat_deadline</div>";
									$payment .= "<div class='attend_rows'>School bus Fee:  $payment_array[$pay_bus]</div>";
									$payment .= "<div class='attend_rows'>Boarding Fee:  $payment_array[$pay_dorm]</div>";
									$payment .= "<div class='attend_rows'>Uniform Fee:  $payment_array[$pay_uni]</div>";
									$payment .= "<div class='attend_rows'>Payment made by:  $payment_by_array[$pay_by]</div>";
									$payment .= "<div class='attend_rows'>Payment method:  $payment_method_array[$pay_met]</div>";
									$payment .= "<div class='attend_rows'>Comment: $pay_comment</div>";
									$payment .= "<div class='attend_rows'><br><a href='$PHP_SELF?stud_id=$stud_id&editpayment=true#payment'>
									Edit payment information</a></div>";
									
									
							} else {
							
									$payment = "<form id=\"submitpayment\" name=\"submitpayment\" method=\"get\" action=\"student-hm.php\">";
									$payment .= "<div class='attend_rows'>Tuition Fee:  " . dropdown($payment_array,"pay_tut", "$pay_tut", "no") . "</div>";
									$payment .= "<div class='attend_rows'>Application Fee:  " . dropdown($payment_array,"pay_appl", "$pay_appl", "no") . "</div>";
									$payment .= "<div class='attend_rows'>Seat deposit Fee:  " . dropdown($payment_array,"pay_set", "$pay_seat", "no") . "</div>";
									
									$d = new date_to_dropdown();
									$payment .= "<div class='attend_rows'>Seat deposit Fee deadline:  " . 
									
									$d->datedropdown(date_for_drop($day,$month,$year), "no", "yes", "yes", "pay_seat_deadline") . "</div>";
									$payment .= "<div class='attend_rows'>School bus Fee:  " . dropdown($payment_array,"pay_bus", "$pay_bus", "no") . "</div>";
									$payment .= "<div class='attend_rows'>Dormitory Fee:  " . dropdown($payment_array,"pay_dorm", "$pay_dorm", "no") . "</div>";
									$payment .= "<div class='attend_rows'>Uniform Fee:  " . dropdown($payment_array,"pay_uni", "$pay_uni", "no") . "</div>";
									$payment .= "<div class='attend_rows'>Payment made by:  " . dropdown($payment_by_array,"pay_by", "$pay_by", "no") . "</div>";
									$payment .= "<div class='attend_rows'>Payment method:  " . dropdown($payment_method_array,"pay_met", "$pay_met", "no") . "</div>";
									$payment .= "<div class='attend_rows'>Comment: <br>
												<textarea name=\"pay_comment\" rows=\"5\" style=\"width: 400px;\"></textarea></div>";
									$payment .= "<input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />";
									$payment .= "<input type=\"submit\" name=\"changepayment\" value=\"submit\" /></label></form>";
									
							}
										
									$t->set_var("PAYMENT","$payment");
								

						/*------------------------------------ Transportation  ----------------------------*/


								if($_GET[editbus] != "true") {
									
									//has a bus alrday, so get the bus information
									if($bus != "0") {
	
										$getbus = mysql_query("SELECT bus.bus_id, bus_name, bus_route 
																FROM bus 
																WHERE bus.bus_id=$bus");
														
											if(mysql_num_rows($getbus) > "0"){
											
												$getarray = mysql_fetch_array($getbus);
												
												$busout = "$getarray[bus_name] - $getarray[bus_route] ";
											}
										$t->set_var("BUSOUT","<br>$busout [<a href='$PHP_SELF?stud_id=$stud_id&editbus=true#bus'>change this</a>]<br><br>");
									
									//doesn't have a bus yet
									} else {
									
											$t->set_var("BUSOUT","<br>No bus yet [<a href='$PHP_SELF?stud_id=$stud_id&editbus=true#bus'>change this</a>]<br><br>");
	
									}
									
								/* ------------------- edit bus ----------------------*/
								
								} else {
								
										//get all the busses that have capacity
										$get = mysql_query("SELECT bus_id, bus_name, bus_totalcapacity, bus_capacityused 
															FROM bus 
															WHERE bus_totalcapacity > bus_capacityused");
															
										if(mysql_num_rows($get) > "0"){
										
												//ad empty line at the beginning of drop down menue,
												//in case they want to take someone of the bus without changing to another bus
												$busdrop .= "<option value='0'>No Bus</option>";
										
											while($getarray = mysql_fetch_array($get)){
											
												$capacity = $getarray[bus_totalcapacity] - $getarray[bus_capacityused];
												$busdrop .= "<option value='$getarray[bus_id]'>$getarray[bus_name] (Capacity: $capacity)</option>";
											}
										}
									
											$t->set_var("BUSOUT","<br><form name=\"busform\" method=\"get\" action=\"student-hm.php\">Change to: 
													<select name=\"bus\" style=\"width: 200px;\">
													$busdrop</select> <input name=\"stud_id\" type=\"hidden\" value=\"$stud_id\" />
													<input type=\"submit\" name=\"submitbus\" value=\"Add \" style=\"font-size: 10px;\"/></form>");
								
								}
							
							
					
						/*------------------------------------ Show all schools  ----------------------------*/
						
						
								$get = mysql_query("SELECT * FROM school WHERE stud_id='$stud_id'");
								if(mysql_num_rows($get) > "0"){
									while($getarray = mysql_fetch_array($get)){
										extract($getarray);
										$schools .= "<div class='school_rows'><h1>$school_name / $school_country </h1>Periode of study: $school_periode<br>Curriculum: 
													$school_curriculum<br>Language of Instruction: $school_language
													<br> Highest level of study/certificate awarded: $school_cert 
													<br></div><br>";
									
									}
									
									$t->set_var("SCHOOLS","$schools");	
								} else {
								
									$t->set_var("SCHOOLS","");								
								}
							
							
						/*------------------------------------ Admission behavior test (adbb)  ----------------------------*/
						
							if(checklevel("student_adbe", $mylevel) == "0"){
								$t->set_var("STUDENTADBE","");	
							} else {
								$t->parse(STUDENTADBE,"hm_adbe");	
							}
							
						
								$get = mysql_query("SELECT COUNT(*) AS adbe FROM adbe WHERE stud_id='$stud_id'");
								$getarray = mysql_fetch_array($get);
								
								if($getarray[adbe] > "0") {
								
									$t->set_var("ADBE","<br><a href='student-adbe.php?stud_id=$stud_id'>View results</a>");
								
								} else {
								
									$t->set_var("ADBE","<br>Not created yet. 
									<a href='student-adbe.php?stud_id=$stud_id'>Create now</a>");
								}
								
								

						/*------------------------------------ Parents ccount  ----------------------------*/
						
						
								$get = mysql_query("SELECT acc_uid, account_id 
													FROM parents_account
													LEFT JOIN parents_student_lookup 
													ON parents_student_lookup.parent_id=parents_account.account_id
													WHERE parents_student_lookup.stud_id='$stud_id'");
												
								if(mysql_num_rows($get) > "0") {
								
									while ($getarray = mysql_fetch_array($get)) {	
										
										$pa_account .= "Account: 
										$getarray[acc_uid] 
										[<a href='editparentsaccount.php?account_id=$getarray[account_id]'>edit</a>]<br>";					
										
									}
									
									$t->set_var("PARENTSACCOUNT","<br>$pa_account");
								
								} else {
								
									$t->set_var("PARENTSACCOUNT","<br>Not accounts yet. 
													<a href='editparentsaccount.php?stud_nb=$stud_nb'>Create one now</a>");
								}
									
							
							
							
					}

			}
				

		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>
