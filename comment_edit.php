<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"form" => "detentionform.htm",
		"main" => "detentions.htm"));

	
		$resultpage = $_GET[resultpage];
		
		
	$t->set_var(LOGINNAME, $_SESSION[uid]);
	
	
	//--------------------------- Check the level ------------------------------//		
	if(checklevel("student_det", $mylevel) < "2"){
		message("You have no permission to perform this operation", "comments.php", "3");
		exit(); }
	//--------------------------------------------------------------------------//	
			
			
	
/* --------------------------------------------------- Delete one ------------------------------- */

		if(($_GET[delete] == "true")) {
			
				$del = mysql_query("DELETE FROM detentions WHERE det_id='$_GET[det_id]'");
				
				if($del) {
					
					message("Comment deleted successfully", "comments.php");
					exit();
					
				}
				
		}	
	

/* --------------------------------------------------- Add / Edit ------------------------------- */

		if(isset($_GET[submit])) {
		
		
				// ----------- it's n update  ------------------
					
					if($_GET[det_id] != "") {
					
						$update = mysql_query("UPDATE detentions SET det_txt='$_GET[dettxt]' WHERE det_id='$_GET[det_id]' LIMIT 1");
						
						if($update) {
						
							message("Comment successfully updated", "comments.php");
							exit();
						}
						
				// ----------- it's new  ------------------
					
					} else {
				
						// ----------- first check if it's empty. Might just be  ------------------
						
						if($_GET[dettxt] == ""){
							
							message("Error. Can't submit an empty form", "detention_edit.php?stud_id=$_GET[stud_id]");
							exit();
						} else {
						
							$input = mysql_query("INSERT INTO detentions SET det_txt='$_GET[dettxt]', det_date=now(), det_by='$user_id', det_stud_id='$_GET[stud_id]'");
							
							if($input) {
								message("Comment added successfully", "comments.php?stud_id=$_GET[stud_id]");
								exit();
							}
						
						
						
						}
					}


/* --------------------------------------------------- Show the form ------------------------------- */

} else {


	//---------- get all the info about the student --------------------------
	
	
		// if it's an update, get the stuff from the db 
		
		if(isset($_GET[det_id])) {
		
			$get = mysql_query("SELECT det_txt, det_stud_id FROM detentions WHERE det_id='$_GET[det_id]'");
			if(mysql_num_rows($get) == "0") {
				message("Invalid page. Please report this to the admin", "index.php");
				exit();
			} else {
				$getarray = mysql_fetch_array($get);
				
					$t->set_var(DETTXT, $getarray[det_txt]);
					$stud_id = $getarray[det_stud_id];
			}
		
		} else {
		
			$stud_id = $_GET[stud_id];
			$t->set_var(DETTXT, "");
			
		}
	
		// check first if there's a student id .. if not .. invalid la
		
		if(!isset($stud_id)) {
			
			message("This page is invalid. Please report this bug to an administrator", "comments.php");
			exit();
		}
		
		// otherwise get all the stuff from the database 
	
		$t->set_var(DETID, $_GET[det_id]);
		$t->set_var(STUDID, $_GET[stud_id]);
				
		$get = mysql_query("SELECT firstname, lastname, chinesename, class_name, enrolled 
							FROM student 
							LEFT JOIN classes ON classes.class_id=student.class_id
							WHERE stud_id=$stud_id");
							
		$getarray = mysql_fetch_array($get);
		
			$t->set_var(STUDNAME, "$getarray[firstname] $getarray[middlename] $getarray[lastname] $getarray[chinesename]");
			$t->set_var(CLASSNAME, $getarray[class_name]);
			$t->set_var(ENROLLED, "$getarray[enrolled]");
			
		// Number of previos detentions
		
			$select = mysql_query("SELECT COUNT(*) AS prevdet FROM detentions WHERE det_stud_id=$stud_id");
			$getarray = mysql_fetch_array($select);
			
			$t->set_var(NBDETENTIONS, "$getarray[prevdet]");
		
			

	}


		//first get a drop down with all classes for the right column				
				$get = mysql_query("SELECT class_id, class_name FROM classes");
														
						if(mysql_num_rows($get) > "0"){
							while($getarray = mysql_fetch_array($get)){
										
								$classesdrop .= "<option value='$getarray[class_id]'>$getarray[class_name]</option>";
							}
						}
									

				$t->set_var("CLASSESDROP", "<select name=\"find_classroom\" style=\"width: 220px;\"><option value='' selected></option>$classesdrop</select>");
				
				
			//there's no class selected, so show the list with all classes
			$get = mysql_query("SELECT class_id, class_name FROM classes ORDER BY class_name");
			if(mysql_num_rows($get) > "0") {
				while($getarray = mysql_fetch_array($get)){
				
						$classlist .= "<li><a href='comments.php?class_id=$getarray[class_id]'>Class $getarray[class_name]</a></li>";
				
				}
				
				$t->set_var("DETADDLIST","<ul>$classlist</ul>");
			
			}	
	
$t->parse(MAINSTAGE, "form");

$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>