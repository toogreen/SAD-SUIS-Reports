<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form_pa.htm",
		"parentsaccount" => "parentsaccount_embed.html"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$legalcustodian = $_POST[legalcustodian];
						$fathername = $_POST[fathername];
						$fathernationality = $_POST[fathernationality];
						$fatherphone = $_POST[fatherphone];
						$fatheremail = $_POST[fatheremail];
						$fatherphone_mobile = $_POST[fatherphone_mobile];
						$fatherphone_company = $_POST[fatherphone_company];
						$fathercompany = $_POST[fathercompany];
						$fathertitle = $_POST[fathertitle];
						$fathercompanyaddress = $_POST[fathercompanyaddress];
						$fatherhomeaddress = $_POST[fatherhomeaddress];
						$fatherenglish = $_POST[fatherenglish];
						$fatherchinese = $_POST[fatherchinese];
						$fathernative = $_POST[fathernative];
						$mothername = $_POST[mothername];
						$mothernationality = $_POST[mothernationality];
						$motherphone = $_POST[motherphone];
						$motheremail = $_POST[motheremail];
						$motherphone_mobile = $_POST[motherphone_mobile];
						$motherphone_company = $_POST[motherphone_company];
						$mothercompany = $_POST[mothercompany];
						$mothertitle = $_POST[mothertitle];
						$mothercompanyaddress = $_POST[mothercompanyaddress];
						$motherhomeaddress = $_POST[motherhomeaddress];
						$motherenglish = $_POST[motherenglish];
						$motherchinese = $_POST[motherchinese];
						$mothernative = $_POST[mothernative];
						$parentsothers = $_POST[parentsothers];
						$carer = $_POST[carer];

					
				
			//--------------------- set query -------------------------
			
						$set = "legalcustodian = '$legalcustodian',
								fathername = '$fathername',
								fathernationality = '$fathernationality',
								fatherphone = '$fatherphone',
								fatheremail = '$fatheremail', 
								fatherphone_mobile = '$fatherphone_mobile',
								fatherphone_company = '$fatherphone_company',
								fathercompany = '$fathercompany',
								fathertitle = '$fathertitle',
								fathercompanyaddress = '$fathercompanyaddress',
								fatherhomeaddress = '$fatherhomeaddress',
								fatherenglish = '$fatherenglish',
								fatherchinese = '$fatherchinese',
								fathernative = '$fathernative',
								mothername = '$mothername',
								mothernationality = '$mothernationality',
								motherphone = '$motherphone',
								motheremail = '$motheremail',
								motherphone_mobile = '$motherphone_mobile',
								motherphone_company = '$motherphone_company',
								mothercompany = '$mothercompany',
								mothertitle = '$mothertitle',
								mothercompanyaddress = '$mothercompanyaddress',
								motherhomeaddress = '$motherhomeaddress',
								motherenglish = '$motherenglish',
								motherchinese = '$motherchinese',
								mothernative = '$mothernative',
								parentsothers = '$parentsothers',
								carer = '$carer',
								lastupdate_ps = lastupdate_ps,
								lastupdate_pa = now(),
								lastupdate_edu = lastupdate_edu,
								lastupdate_med = lastupdate_med,
								lastupdate_emgc = lastupdate_emgc,
								lastupdate_lang = lastupdate_lang,
								lastupdate_general = now(),
								lastupdate_user = '$_SESSION[user_id]',
								iscreated_pa = '1'";
								
						
			//-------------------------- Input new ------------------------------ 
			
			
				if($_POST[stud_id] != "") {
					$update = mysql_query("UPDATE student SET $set WHERE stud_id='$_POST[stud_id]'");
					
					//input parents account
					if($createaccount == "1"){
						$update = mysql_query("INSERT INTO parents_account 
											   SET acc_uid = '$acc_uid', acc_pwd = '$acc_pwd', acc_email = '$acc_email', newsletter_status = '1'");
											   
												$thisparent = mysql_insert_id();
					
						$insert = mysql_query("INSERT INTO parents_student_lookup 
												SET stud_id=$_POST[stud_id], parent_id=$thisparent");
					
					}
					
					//alright, let's check if the timestamp lastupdate_edu is empty / null, if so than it's a new student,
					//so let's send them to the next step student_emgc.php. Otherwise go back to student_hm.php
					
					$get = mysql_query("SELECT iscreated_edu FROM student WHERE stud_id='$_POST[stud_id]'");
					if(mysql_num_rows($get) == "0") {
						
						//something went completely wrong .. 
						message("Invalid page. Please report this to the webmaster", "");
					
					} else {
					
						$getarray = mysql_fetch_array($get);

						if($getarray[iscreated_edu] == "0") { //this '0000-00-00 00:00:00 might change from server to server
							//send to the next step
							message("Information added to profile","student-edu.php?stud_id=$_POST[stud_id]");
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
						
							if($iscreated_pa == "0") {
								$t->set_var("ADMINMSG","Creating student profile for $callname (Step 2 / 6)");
								
								//in that case, add a form section to the bottom to create a new partens account.
								//Suggest the student name as a username
								
								$t->parse(PARENTSACCOUNT, "parentsaccount");
								
								$t->set_var("ACCUID", strtolower(generateParentsUID($firstname,$lastname)));
								$t->set_var("ACCPWD", generatePassword());
								$t->set_var("ACCEMAIL", "");
								
								
							} else {
								$t->set_var("ADMINMSG","Updating student profile of student $callname");
								$t->set_var("PARENTSACCOUNT", "");
							}	
	
						//Emergency
						
							$t->set_var("STUDID","$stud_id");
							
							$t->set_var("LEGALCUSTODIAN", dropdown($legalcustodian_array,"legalcustodian","$legalcustodian","yes"));
							$t->set_var("FATHERLANGUAGEEN", dropdown($parentslanguageskills_array,"fatherenglish","$fatherenglish","yes"));
							$t->set_var("FATHERLANGUAGECN", dropdown($parentslanguageskills_array,"fatherchinese","$fatherchinese","yes"));
							$t->set_var("MOTHERLANGUAGEEN", dropdown($parentslanguageskills_array,"motherenglish","$motherenglish","yes"));
							$t->set_var("MOTHERLANGUAGECN", dropdown($parentslanguageskills_array,"motherchinese","$motherchinese","yes"));
	
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
									
					}
			}

		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>
