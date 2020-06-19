<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "ps_sessions.htm"));

	
		$resultpage = $_GET[resultpage];
		

	/*--------------------------- Check the user level -------------------*/
	
		if(checklevel("student_psycho", $mylevel) == "0"){
			message("You have no permission to access this page", "index.php", "3");
			exit();
		}
		
		
//---------------- lastlogin -----------------------//

		$timestamp = $_SESSION[lastlogin];
		$yyyy = substr($timestamp, 0, 4);
		$month = substr($timestamp, 4, 2);
		$dd = substr($timestamp, 6, 2);
		$hh = substr($timestamp, 8, 2);
		$mm = substr($timestamp, 10, 2);
		$ss = substr($timestamp, 12, 2);
		
		$t->set_var(LASTLOGIN, "$yyyy/$mm/$dd - $hh.$mm h");	
		
		
		
	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	

			//Where condition.. Either show all, or for one class, or for one student
			
			$where = " WHERE psycho_session.sess_id > '0'";
			
			if($_GET[class_id] != "") {
			
				$where .= " AND student.class_id='$_GET[class_id]'";
			
			}
			
			if($_GET[stud_id] != "") {
			
				$where .= " AND student.stud_id='$_GET[stud_id]'";
			
			}
		
				
			$rs = new MysqlPagedResultSet("SELECT stud_id, sess_id, sess_nb, sess_ana, sess_date, student.firstname, student.lastname, 
											classes.class_name, user.uid AS sess_user
											FROM psycho_session
											LEFT JOIN student ON student.stud_id=psycho_session.sess_stud_id
											LEFT JOIN classes ON student.class_id = classes.class_id
											LEFT JOIN user ON psycho_session.sess_user = user.user_id
											$where", "20","ps_sessions.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
										
										
								//cut it short and take of line breaks to make it look better la
								$ana = cut_string($getarray[sess_ana], "400");
								$ana = str_replace('<br>', '', $ana);
								$ana = str_replace('<BR>', '', $ana);
								
								
								$detout .= "<div class='dtn_rows'><h1><img src=\"img/icon_stud_small.GIF\" align=\"left\"/>
											<b>$getarray[lastname], $getarray[firstname] $getarray[middlename] $getarray[chinesename]</b></h1>
											<h2>Class: $getarray[class_name] | added: $getarray[sess_date] by $getarray[sess_user] | 
											<a href='student-hm.php?stud_id=$getarray[stud_id]'>Student profile</a> | 
											<a href='ps_session_edit.php?add=true&stud_id=$getarray[stud_id]'>Add session summary</a></h2>
											$ana<br> 
											<h1>[ <a href='ps_session_edit.php?sess_id=$getarray[sess_id]'>show session summary</a> | 
											<a href='ps_session_edit.php?sess_id=$getarray[sess_id]'>edit</a> | 
											<a href='ps_session_edit.php?delete=true&sess_id=$getarray[sess_id]'>delete</a>]</h1></div>";
								}
								$detentions = "total results: " . $rs->getTotalNum() . "  
											<br><br>$detout <br>" . $rs->getPageNb("");
									
						} else {
									
								//if searched by one student, and there's no result, than add a link to add a post for this student
								//to make it nice we get his name 
								
								if($_GET[stud_id] != "") {
								
									$getname = mysql_query("SELECT firstname, lastname, chinesename FROM student WHERE stud_id=$_GET[stud_id]");
									$getarray = mysql_fetch_array($getname);
									
									$detentions = "<br>No results. 
													<a href='ps_session_edit.php?add=true&stud_id=$_GET[stud_id]'>Add a session for 
													$getarray[firstname] $getarray[lastname] $getarray[chinesename]</a>";
								} else {
									$detentions = "<br>No results";								
								}
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/icon_psychosession.gif\" /></h1></div><br><br>$detentions");
						
						
	/*----------------------------- List with classes / studs for right column  ------------------------*/
					
						
		if(($_GET[class_id]) == "") {
			
			//there's no class selected, so show the list with all classes
			$get = mysql_query("SELECT class_id, class_name FROM classes ORDER BY class_name");
			if(mysql_num_rows($get) > "0") {
				while($getarray = mysql_fetch_array($get)){
				
						$classlist .= "<li><a href='ps_sessions.php?class_id=$getarray[class_id]'>Class $getarray[class_name]</a></li>";
				
				}
				
				$t->set_var("DETADDLIST","<ul>$classlist</ul>");
			
			}	
		
		//class is selected, show all studs of this class
		} else {
			$get = mysql_query("SELECT student.firstname, student.lastname, student.chinesename, student.stud_id, classes.class_name 
								FROM student 
								LEFT JOIN classes ON classes.class_id = student.class_id
								WHERE student.class_id='$class_id'");
			
			if(mysql_num_rows($get) > "0") {
				while($getarray = mysql_fetch_array($get)){
				
						$classlist .= "<li><a href='ps_sessions.php?stud_id=$getarray[stud_id]'>
										Class $getarray[class_name] - $getarray[firstname] $getarray[lastname] $getarray[chinesename]</a></li>";
				
				}
				
				$t->set_var("DETADDLIST","<ul>$classlist</ul>");
			
			} else {
				$t->set_var("DETADDLIST","<br>No students found");
			}
		
		}			
						
		
		
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>