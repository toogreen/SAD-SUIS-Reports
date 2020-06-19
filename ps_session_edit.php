<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"form" => "pssessionsform.htm",
		"main" => "ps_sessions.htm"));

	
		$resultpage = $_GET[resultpage];
	
	
	//--------------------------- Check the level ------------------------------//		
	if(checklevel("student_psycho", $mylevel) < "2"){
		message("You have no permission to perform this operation", "ps_sessions.php", "3");
		exit(); }
	//--------------------------------------------------------------------------//	
	
		
//---------------- lastlogin -----------------------//
	
	
		
	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
/* --------------------------------------------------- Delete one ------------------------------- */

if(($_GET[delete] == "true")) {
	
		$del = mysql_query("DELETE FROM psycho_session WHERE sess_id='$_GET[sess_id]'");
		
		if($del) {
			
			message("Session deleted", "ps_sessions.php");
			exit();
			
		}
		
}	
	

/* --------------------------------------------------- Add / Edit ------------------------------- */

if(isset($_GET[submit])) {


		// ----------- it's n update  ------------------
			
			if($_GET[sess_id] != "") {
			
				$update = mysql_query("UPDATE psycho_session 
									  SET sess_ana='$_GET[sess_ana]', sess_nb='$_GET[sess_nb]', sess_person='$_GET[sess_person]' 
									  WHERE sess_id='$_GET[sess_id]' 
									  LIMIT 1");
				
				if($update) {
				
					message("Session summary successfully updated", "ps_sessions.php");
					exit();
				}
				
		// ----------- it's new  ------------------
			
			} else {
		

				// ----------- first check if it's empty. Might just be  ------------------
				
				if($_GET[sess_ana] == ""){
					
					message("Error. Can't submit an empty form", "ps_session_edit.php?add=true&stud_id=$_GET[stud_id]");
					exit();
				} else {
				
					$input = mysql_query("INSERT INTO psycho_session 
										  SET sess_ana='$_GET[sess_ana]', sess_date=now(), 
										  sess_user='$user_id',  sess_nb='$_GET[sess_nb]', sess_person='$_GET[sess_person]', sess_stud_id='$_GET[stud_id]'");
					
					if($input) {
						message("Session summary added successfully", "ps_sessions.php?stud_id=$_GET[stud_id]");
						exit();
					}
				
				
				
				}
			}


/* --------------------------------------------------- Show the form ------------------------------- */

} else {


	//---------- get all the info about the student --------------------------
	
	
		// if it's an update, get the stuff from the db 
		
		if(isset($_GET[sess_id])) {
		
			$get = mysql_query("SELECT sess_ana, sess_person, sess_stud_id, sess_nb FROM psycho_session WHERE sess_id='$_GET[sess_id]'");
			if(mysql_num_rows($get) == "0") {
				message("Invalid page. Please report this to the admin", "index.php");
				exit();
			} else {

					$getarray = mysql_fetch_array($get);
				
					$t->set_var(SESSANA, $getarray[sess_ana]);
					$t->set_var(SESSPERSON, $getarray[sess_person]);
					$t->set_var(SESSNB, $getarray[sess_nb]);
					$stud_id = $getarray[sess_stud_id];
					$t->set_var(PREVSESSIONHELP, ""); 
			}
		
		} else {
		
					//get the number of the previos session
					$getprev = mysql_query("SELECT sess_nb FROM psycho_session WHERE sess_stud_id='$stud_id' ORDER BY sess_id DESC LIMIT 1");
					if(mysql_num_rows($getprev) > "0") {
						
						$getarray = mysql_fetch_array($getprev);
						$t->set_var(PREVSESSIONHELP, "(previous session was $getarray[sess_nb])");
					
					} else {
					
						$t->set_var(PREVSESSIONHELP, "");
					
					}
					
					$stud_id = $_GET[stud_id];
					$t->set_var(SESSANA, "");
					$t->set_var(SESSPERSON, "");
					$t->set_var(SESSNB, "");
					 
			
		}
	
		
		// otherwise get all the stuff from the database 
	
		$t->set_var(SESSID, $sess_id);
		$t->set_var(STUDID, $stud_id);
				
		$get = mysql_query("SELECT firstname, lastname, chinesename, class_name, enrolled 
							FROM student 
							LEFT JOIN classes ON classes.class_id=student.class_id
							WHERE stud_id=$stud_id");
							
		$getarray = mysql_fetch_array($get);
		
			$t->set_var(STUDNAME, "$getarray[firstname] $getarray[middlename] $getarray[lastname] $getarray[chinesename]");
			$t->set_var(CLASSNAME, $getarray[class_name]);
			$t->set_var(ENROLLED, "$getarray[enrolled]");
					

	}


			//there's no class selected, so show the list with all classes
			$get = mysql_query("SELECT class_id, class_name FROM classes ORDER BY class_name");
			if(mysql_num_rows($get) > "0") {
				while($getarray = mysql_fetch_array($get)){
				
						$classlist .= "<li><a href='ps_sessions.php?class_id=$getarray[class_id]'>Class $getarray[class_name]</a></li>";
				
				}
				
				$t->set_var("DETADDLIST","<ul>$classlist</ul>");
			
			}	
	
$t->parse(MAINSTAGE, "form");

$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>