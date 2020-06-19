<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "detentions.htm"));

	
	$resultpage = $_GET[resultpage];	
	$t->set_var(LOGINNAME, $_SESSION[uid]);
	
	
	/*--------------------------- Check the user level -------------------*/
	
		if(checklevel("student_det", $mylevel) == "0"){
			message("You have no permission to access this page", "index.php", "3");
			exit();
		}
	

	/*------------------------------------ Detentions  ----------------------------*/
		
		$where = "WHERE det_stud_id > '0'";
		
		//if a class is selected, show only detentions of this class, otherwise show all				
			if(($_GET[stud_id]) != "") {
			
				$where .= " AND detentions.det_stud_id=$_GET[stud_id]";
				
				//let's say we show a student, then we need a link to add a detention for this student
				$getname = mysql_query("SELECT firstname, lastname, chinesename FROM student WHERE stud_id='$_GET[stud_id]'");
				$getarray = mysql_fetch_array($getname);
				$addlink = "<a href='comment_edit.php?stud_id=$_GET[stud_id]'>Add a detention for  student 
							$getarray[firstname] $getarray[lastname] $getarray[chinesename]</a>";
				
			} 

		//if a class is selected, show only detentions of this class, otherwise show all				
			if(($_GET[class_id]) != "") {
			
				$where .= " AND student.class_id=$_GET[class_id]";
				
			} 
			
		
		//if there's a search by date or classroom or name			
			if(($_GET[find_day]) != "") {
			
				$where .= " AND DATE_FORMAT(det_date, '%d' ) = '$_GET[find_day]'";
				
			} 
			
			if(($_GET[find_month]) != "") {
			
				$where .= " AND DATE_FORMAT(det_date, '%m' ) = '$_GET[find_month]'";
				
			} 
			
			if(($_GET[find_year]) != "") {
			
				$where .= " AND DATE_FORMAT(det_date, '%Y' ) = '$_GET[find_year]'";
				
			}
			
			if(($_GET[find_lastname]) != "") {
				$where .= " AND student.lastname LIKE '%$_GET[find_lastname]%'";
				
			} 
			
			if(($_GET[find_classroom]) != "") {
				$where .= " AND student.class_id = '$_GET[find_classroom]'";
				
			} 
			
		//order by clause				
			if(($_GET[order_by]) != "") {
			
				$order = " ORDER BY " . $_GET[order_by];
				
			} 
		
		
				
			$rs = new MysqlPagedResultSet("SELECT det_stud_id, det_id, det_by, det_date, det_txt, student.lastname, student.firstname, student.middlename, 
									student.chinesename, classes.class_name, user.uid AS detuser
									FROM detentions
									LEFT JOIN student ON student.stud_id=detentions.det_stud_id
									LEFT JOIN user ON user.user_id=det_by
									LEFT JOIN classes ON student.class_id=classes.class_id
									$where $order", "20","detentions.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
										
								$detout .= "<div class='dtn_rows'><h1><img src=\"img/icon_stud_small.GIF\" align=\"left\"/> <b>$getarray[lastname] $getarray[firstname] $getarray[middlename]</b> 
											$getarray[chinesename]</h1>
											<h2>Class: $getarray[class_name] | Added: $getarray[det_date] by $getarray[detuser] | <a href='student-hm.php?stud_id=$getarray[det_stud_id]'>Student profile</a> | <a href='comment_edit.php?stud_id=$getarray[det_stud_id]'>Add comment for this student</a>  
											</h2> $getarray[det_txt] 
											[ <a href='comment_edit.php?det_id=$getarray[det_id]'>edit</a> | 
											<a href='comment_edit.php?delete=true&det_id=$getarray[det_id]'>delete</a>]</div>";
								}
								$detentions = "total results: " . $rs->getTotalNum() . " | order by: 
											<a href='$PHP_SELF?class_id=$class_id&stud_id=$stud_id&order_by=student.lastname'>Student name</a> | 
											<a href='$PHP_SELF?class_id=$class_id&stud_id=$stud_id&order_by=detentions.det_date'>Date posted</a>  
											<br><br>$detout <br>" . $rs->getPageNb("");
									
						} else {
									
								$detentions = "<br>No comments found! <br><br>$addlink";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/txt_detentions.gif\" /></h1></div><br><br>$detentions");
						
						
	/*----------------------------- List with classes / studs for right column  ------------------------*/
					
		
		//first get a drop down with all classes for the right column				
				$get = mysql_query("SELECT class_id, class_name FROM classes");
														
						if(mysql_num_rows($get) > "0"){
							while($getarray = mysql_fetch_array($get)){
										
								$classesdrop .= "<option value='$getarray[class_id]'>$getarray[class_name]</option>";
							}
						}
									

				$t->set_var("CLASSESDROP", "<select name=\"find_classroom\" style=\"width: 220px;\"><option value='' selected></option>$classesdrop</select>");
			
			

		if(($_GET[class_id]) == "") {
			
			//there's no class selected, so show the list with all classes
			$get = mysql_query("SELECT class_id, class_name FROM classes ORDER BY class_name");
			if(mysql_num_rows($get) > "0") {
				while($getarray = mysql_fetch_array($get)){
				
						$classlist .= "<li><a href='$PHP_SELF?class_id=$getarray[class_id]'>Class $getarray[class_name]</a></li>";
				
				}
				
				$t->set_var("DETADDLIST","<ul>$classlist</ul>");
			
			}	
		
		//class is selected, show all studs of this class
		} else {
			$get = mysql_query("SELECT student.firstname, student.lastname, student.chinesename, student.stud_id, classes.class_name 
								FROM student 
								LEFT JOIN classes ON classes.class_id = student.class_id
								WHERE student.class_id='$_GET[class_id]'");
			
			if(mysql_num_rows($get) > "0") {
				while($getarray = mysql_fetch_array($get)){
				
						$studentlist .= "<li><a href='comments.php?stud_id=$getarray[stud_id]'>
										Class $getarray[class_name] - $getarray[firstname] $getarray[lastname] $getarray[chinesename]</a></li>";
				
				}
				
				$t->set_var("DETADDLIST","<ul>$studentlist</ul>");
			
			} else {
				$t->set_var("DETADDLIST","<br>No students found");
			}
		
		}			
						
		
		
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>