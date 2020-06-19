<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "student.htm",
		"form" => "student_form_adbe.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$stud_id = $_POST[stud_id];
						$adbe1 = $_POST[adbe1];
						$adbe2 = $_POST[adbe2];
						$adbe3 = $_POST[adbe3];
						$adbe4 = $_POST[adbe4];
						$adbe5 = $_POST[adbe5];
						$adbe6 = $_POST[adbe6];
						$adbe7 = $_POST[adbe7];
						$adbe8 = $_POST[adbe8];
						$adbe9 = $_POST[adbe9];
						$adbe10 = $_POST[adbe10];
						$adbe11 = $_POST[adbe11];
						$adbe12 = $_POST[adbe12];
						$adbe13 = $_POST[adbe13];
						$adbe14 = $_POST[adbe14];
					
				
			//--------------------- set query -------------------------
			
						$set = "adbe1 = '$adbe1',
								adbe2 = '$adbe2',
								adbe3 = '$adbe3',
								adbe4 = '$adbe4',
								adbe5 = '$adbe5',
								adbe6 = '$adbe6',
								adbe7 = '$adbe7',
								adbe8 = '$adbe8',
								adbe9 = '$adbe9',
								adbe10 = '$adbe10',
								adbe11 = '$adbe11',
								adbe12 = '$adbe12',
								adbe13 = '$adbe13',
								adbe14 = '$adbe14'";
								
						
			//-------------------------- Input new ------------------------------ 
			
				//check if there's already one, if yes it's an update, otherwise a new entry
				
				$count = mysql_query("SELECT COUNT(*) isscho FROM adbe WHERE stud_id='$stud_id'");
				$getarray = mysql_fetch_array($count);
				if($getarray[isscho] > "0") {
			
					$update = mysql_query("UPDATE adbe SET $set WHERE stud_id='$stud_id' LIMIT 1");
					message("Admission test successfully updated", "student-hm.php?stud_id=$stud_id");
					exit();		
					
				} else {
					$update = mysql_query("INSERT INTO adbe SET $set, stud_id='$stud_id'");
					message("Admission test successfully added", "student-hm.php?stud_id=$stud_id");
					exit();				
				}
			
			
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {


		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[stud_id] != ""){
			
			
				//get this students name and stuff
				$stud_id = $_GET[stud_id];
				$getname = mysql_query("SELECT firstname, lastname, chinesename FROM student WHERE stud_id='$stud_id'");
				if(mysql_num_rows($get) > "0"){
					$getname_array = mysql_fetch_array($getname);

				
				//now get all the stuff from the adbe database, if he has
				$get = mysql_query("SELECT * FROM adbe WHERE stud_id='$stud_id'");
				if(mysql_num_rows($get) > "0") {
				
						$getarray = mysql_fetch_array($get);
						extract($getarray);
				
						$t->set_var("ADMINMSG","Updating Admission Behavior Test of 
									$getname_array[firstname] $getname_array[lastname] $getname_array[chinesename]
									(<a href='student-hm.php?stud_id=$_GET[stud_id]'>return to profile</a>)");
				} else {
						$t->set_var("ADMINMSG","Creating Admission Behavior Test for student $callname");
				}	
	
						//Emergency
						
							$t->set_var("STUDID","$stud_id");
	
							$t->set_var("ADBE1",dropdown($adbe_array,"adbe1","$adbe1","no"));
							$t->set_var("ADBE2",dropdown($adbe_array,"adbe2","$adbe2","no"));
							$t->set_var("ADBE3",dropdown($adbe_array,"adbe3","$adbe3","no"));
							$t->set_var("ADBE4",dropdown($adbe_array,"adbe4","$adbe4","no"));
							$t->set_var("ADBE5",dropdown($adbe_array,"adbe5","$adbe5","no"));
							$t->set_var("ADBE6",dropdown($adbe_array,"adbe6","$adbe6","no"));
							$t->set_var("ADBE7",dropdown($adbe_array,"adbe7","$adbe7","no"));
							$t->set_var("ADBE8",dropdown($adbe_array,"adbe8","$adbe8","no"));
							$t->set_var("ADBE9",dropdown($adbe_array,"adbe9","$adbe9","no"));
							$t->set_var("ADBE10",dropdown($adbe_array,"adbe10","$adbe10","no"));
							$t->set_var("ADBE11",dropdown($adbe_array,"adbe11","$adbe11","no"));
							$t->set_var("ADBE12",dropdown($adbe_array,"adbe12","$adbe12","no"));
							$t->set_var("ADBE13",dropdown($adbe_array,"adbe13","$adbe13","no"));
							$t->set_var("ADBE14",dropdown($adbe_array,"adbe14","$adbe14","no"));						
									
					}
			}

		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>