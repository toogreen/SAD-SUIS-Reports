<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form_lang.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$lang_english_home = $_POST[lang_english_home];
						$lang_native = $_POST[lang_native];
						$lang_second = $_POST[lang_second];
						$lang_others = $_POST[lang_others];
						$lang_english_home = $_POST[lang_english_home];
						$lang_english_level = $_POST[lang_english_level];
						$lang_chinese_level = $_POST[lang_chinese_level];
						$lang_maths_level = $_POST[lang_maths_level];
						$lang_ort_level = $_POST[lang_ort_level];
						$lang_specialneeds = $_POST[lang_specialneeds];
						$lang_eal = $_POST[lang_eal];						
						$lang_englishfulltime = $_POST[lang_englishfulltime];
						$lang_english_years = $_POST[lang_english_years];
						$private_tutoring = $_POST[private_tutoring];
						$lang_english_private_tutor = $_POST[lang_english_private_tutor];
						$lang_english_private_home = $_POST[lang_english_private_home];
						$lang_english_private_school = $_POST[lang_english_private_school];
						$summerschool = $_POST[summerschool];
						$outsideschool = $_POST[outsideschool];
					
						
			//---------------- make the text save --------------------
			
						$summerschool = addslashes($summerschool);
						$outsideschool = addslashes($outsideschool);
						$lang_specialneeds = addslashes($lang_specialneeds);
						$lang_eal = addslashes($lang_eal);
					
				
			//--------------------- set query -------------------------
			
						$set = "lang_native = '$lang_native',
								lang_second = '$lang_second',
								lang_others = '$lang_others',
								lang_english_home = '$lang_english_home',
								lang_english_level = '$lang_english_level',
								lang_chinese_level = '$lang_chinese_level',
								lang_maths_level = '$lang_maths_level',
								lang_ort_level = '$lang_ort_level',
								lang_specialneeds = '$lang_specialneeds',
								lang_eal = '$lang_eal',
								lang_englishfulltime = '$lang_englishfulltime',
								lang_english_years = '$lang_english_years',
								private_tutoring = '$private_tutoring',
								lang_english_private_tutor = '$lang_english_private_tutor',
								lang_english_private_home = '$lang_english_private_home',
								lang_english_private_school = '$lang_english_private_school',
								summerschool = '$summerschool',
								outsideschool = '$outsideschool',
								lastupdate_ps = lastupdate_ps,
								lastupdate_pa = lastupdate_pa,
								lastupdate_edu = lastupdate_edu,
								lastupdate_med = lastupdate_med,
								lastupdate_emgc = lastupdate_emgc,
								lastupdate_lang = now(),
								lastupdate_general = now(),
								lastupdate_user = '$_SESSION[user_id]',
								iscreated_lang = '1'";
								
						
						
			//-------------------------- Input new ------------------------------ 
			
			
				if($_POST[stud_id] != "") {
					$update = mysql_query("UPDATE student SET $set WHERE stud_id='$_POST[stud_id]'");
					message("Forwarding you to the students profile","student-hm.php?stud_id=$_POST[stud_id]");
					exit();

			//---------------------------- Update -------------------------------- 				
			
				} else {
					message("Invalid page","student.php");
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
							
							if($iscreated_lang == "0") {
								$t->set_var("ADMINMSG","Creating student profile for $callname (Step 6 / 6)");
							} else {
								$t->set_var("ADMINMSG","Updating student profile of student $callname");
							}
						
						//Language
							$t->set_var("LANGENGLISHHOMEDROP", dropdown($lang_english_home_array,"lang_english_home","$lang_english_home","no"));
							
							// ADDED THESE IN JUNE 2010
							$t->set_var("LANGENGLISHLEVELDROP", dropdown($lang_english_level_array,"lang_english_level","$lang_english_level","no"));
							$t->set_var("LANGCHINESELEVELDROP", dropdown($lang_chinese_level_array,"lang_chinese_level","$lang_chinese_level","no"));
							$t->set_var("LANGMATHSLEVELDROP", dropdown($lang_maths_level_array,"lang_maths_level","$lang_maths_level","no"));
							$t->set_var("LANGORTLEVELDROP", dropdown($lang_ort_level_array,"lang_ort_level","$lang_ort_level","no"));

							// ADDED THESE NEXT 6 IN JUNE 2010
							$t->set_var("LANGENGLISHLEVEL","$lang_english_level");
							$t->set_var("LANGCHINESELEVEL","$lang_chinese_level");
							$t->set_var("LANGMATHSLEVEL","$lang_maths_level");
							$t->set_var("LANGORTLEVEL","$lang_ort_level");
							$t->set_var("LANGSPECIALNEEDS","$lang_specialneeds");
							$t->set_var("LANGEAL","$lang_eal");

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

			}
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>
