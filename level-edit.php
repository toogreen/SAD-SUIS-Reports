<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "setupmain.htm",
		"form" => "level_edit_form.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);


	//--------------------------- Check the level ------------------------------//		
	if(checklevel("editlevel", $mylevel) == "0"){
		message("You have no permission to perform this operation", "index.php", "3");
		exit(); }
	//--------------------------------------------------------------------------//	
		
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$level_id = $_POST[level_id];
						$level_name = $_POST[level_name];
						$view_student = $_POST[view_student];
						$add_student = $_POST[add_student];
						$student_ps = $_POST[student_ps];
						$student_pa = $_POST[student_pa];
						$student_edu = $_POST[student_edu];
						$student_emgc = $_POST[student_emgc];
						$student_med = $_POST[student_med];
						$student_lang = $_POST[student_lang];
						$student_transport  = $_POST[student_transport];
						$student_dorm = $_POST[student_dorm];
						$student_det = $_POST[student_det];
						$student_payment = $_POST[student_payment];
						$student_attendance = $_POST[student_attendance];
						$student_psycho = $_POST[student_psycho];
						$student_adbe = $_POST[student_adbe];
					
													
			//--------------------- set query -------------------------
						
						$set = "level_name = '$level_name',
								view_student = '$view_student',
								add_student = '$add_student',
								student_ps = '$student_ps',
								student_pa = '$student_pa',
								student_edu = '$student_edu',
								student_emgc = '$student_emgc',
								student_med = '$student_med',
								student_lang = '$student_lang',
								student_transport  = '$student_transport',
								student_dorm = '$student_dorm',
								student_det = '$student_det',
								student_payment = '$student_payment',
								student_attendance = '$student_attendance',
								student_psycho = '$student_psycho',
								student_adbe = '$student_adbe',
								editlevel = '$editlevel',
								accesssetup = '$accesssetup'";
								
				
						
			//-------------------------- Update ------------------------------ 
			
			
				if($level_id != "") {
					$update = mysql_query("UPDATE user_level SET $set WHERE level_id='$level_id'");
					
					message("Successfully edited level $level_name","setup.php?t=levels");
					exit();		
					
	
			//---------------------------- Input new -------------------------------- 				
			
				} else {
				
					$insert = mysql_query("INSERT INTO user_level SET $set");
					
					message("Successfully created level $level_name","setup.php?t=levels");
					exit();			
				}
			
			
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {
		
		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[level_id] != ""){
			
				$stud_id = $_GET[stud_id];
				$get = mysql_query("SELECT * FROM user_level WHERE level_id='$_GET[level_id]'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
		
						//General
						$t->set_var("LEVELID","$level_id");	

						$t->set_var("LEVELNAME", $level_name);	
						$t->set_var("VIEWSTUDENT", checkbox($view_student, "view_student"));
						$t->set_var("ADDSTUDENT", checkbox($add_student, "add_student"));
						$t->set_var("STUDENTPS", dropdown($userlevel_array,"student_ps","$student_ps","no"));	
						$t->set_var("STUDENTPA", dropdown($userlevel_array,"student_pa","$student_pa","no"));	
						$t->set_var("STUDENTEDU", dropdown($userlevel_array,"student_edu","$student_edu","no"));	
						$t->set_var("STUDENTEMGC", dropdown($userlevel_array,"student_emgc","$student_emgc","no"));	
						$t->set_var("STUDENTMED", dropdown($userlevel_array,"student_med","$student_med","no"));	
						$t->set_var("STUDENTLANG", dropdown($userlevel_array,"student_lang","$student_lang","no"));	
						$t->set_var("STUDENTTRANSPORT", dropdown($userlevel_array,"student_transport","$student_transport","no"));	
						$t->set_var("STUDENTDORM", dropdown($userlevel_array,"student_dorm","$student_dorm","no"));	
						$t->set_var("STUDENTDET", dropdown($userlevel_array,"student_det","$student_det","no"));	
						$t->set_var("STUDENTPAYMENT", dropdown($userlevel_array,"student_payment","$student_payment","no"));	
						$t->set_var("STUDENTATTENDANCE", dropdown($userlevel_array,"student_attendance","$student_attendance","no"));	
						$t->set_var("STUDENTPSYCHO", dropdown($userlevel_array,"student_psycho","$student_psycho","no"));	
						$t->set_var("STUDENTADBE", dropdown($userlevel_array,"student_adbe","$student_adbe","no"));	
						$t->set_var("ACCESSSETUP", checkbox($accesssetup, "accesssetup"));	
						$t->set_var("EDITLEVEL", checkbox($editlevel, "editlevel"));	

						
					}
					
		/*------------------------------- Create new student profile ----------------------------------*/

		
			} else {
			
			
						//General
						$t->set_var("LEVELID","");	

						$t->set_var("LEVELNAME", $level_name);	
						$t->set_var("VIEWSTUDENT", checkbox($view_student, "view_student"));
						$t->set_var("ADDSTUDENT", checkbox($add_student, "add_student"));
						$t->set_var("STUDENTPS", dropdown($userlevel_array,"student_ps","$student_ps","no"));	
						$t->set_var("STUDENTPA", dropdown($userlevel_array,"student_pa","$student_pa","no"));	
						$t->set_var("STUDENTEDU", dropdown($userlevel_array,"student_edu","$student_edu","no"));	
						$t->set_var("STUDENTEMGC", dropdown($userlevel_array,"student_emgc","$student_emgc","no"));	
						$t->set_var("STUDENTMED", dropdown($userlevel_array,"student_med","$student_med","no"));	
						$t->set_var("STUDENTLANG", dropdown($userlevel_array,"student_lang","$student_lang","no"));	
						$t->set_var("STUDENTTRANSPORT", dropdown($userlevel_array,"student_transport","$student_transport","no"));	
						$t->set_var("STUDENTDORM", dropdown($userlevel_array,"student_dorm","$student_dorm","no"));	
						$t->set_var("STUDENTDET", dropdown($userlevel_array,"student_det","$student_det","no"));	
						$t->set_var("STUDENTPAYMENT", dropdown($userlevel_array,"student_payment","$student_payment","no"));	
						$t->set_var("STUDENTATTENDANCE", dropdown($userlevel_array,"student_attendance","$student_attendance","no"));	
						$t->set_var("STUDENTPSYCHO", dropdown($userlevel_array,"student_psycho","$student_psycho","no"));
						$t->set_var("STUDENTADBE", dropdown($userlevel_array,"student_adbe","$student_adbe","no"));		
						$t->set_var("ACCESSSETUP", checkbox($accesssetup, "accesssetup"));	
						$t->set_var("EDITLEVEL", checkbox($editlevel, "editlevel"));	

				

			} // if isset $stud_id
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>