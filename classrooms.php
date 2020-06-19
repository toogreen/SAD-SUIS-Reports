<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "classrooms.htm"));

	
		$resultpage = $_GET[resultpage];
		
		
		$t->set_var(LOGINNAME, $_SESSION[uid]);


	/*------------------------------------ update the entire class  ----------------------------*/
	
	
	//this is the MOST server intensive script I've ever put on a server. I loops through 20-40 records and
	//does 4 queries or so each. But it doesn't happen often and there's no other way if we want to do it right.
	//and it won't kill the server .. just keep him busy a bit
	
	if(isset($_GET[submit])) {
	
		foreach($_GET[movetoclassroom] AS $key=>$element){
		
				//get the old class
				$check = mysql_query("SELECT class_id AS oldclass FROM student WHERE stud_id='$key'");
				$getarray = mysql_fetch_array($check);
				
				//take one off
				$minus = mysql_query("UPDATE classes SET class_capacity_used=class_capacity_used-1 WHERE class_id='$getarray[oldclass]'");
				
				//add to the new class
				$plus = mysql_query("UPDATE classes SET class_capacity_used=class_capacity_used+1 WHERE class_id='$element'");

				//and now update the student/s class						
				$insert = mysql_query("UPDATE student SET class_id='$element' WHERE stud_id='$key' LIMIT 1");
		
		}
			
		message("Students updated", "classrooms.php");
		exit();
		

	
	}
		
	
	/*------------------------------------ allow to edit all students at once  ----------------------------*/
	
	
	if($_GET[updatedstudents] == "true"){
	
			//get all classes
			$get = mysql_query("SELECT class_id, class_name FROM classes");
												
				if(mysql_num_rows($get) > "0"){
					while($getarray_classes = mysql_fetch_array($get)){
	
					$classdrop .= "<option value='$getarray_classes[class_id]'>$getarray_classes[class_name]</option>";
					}
				}
		
	
		$rs = new MysqlPagedResultSet("SELECT student.stud_id, student.firstname, student.lastname, student.chinesename, sex, student.dob, class_name 
										FROM student
										LEFT JOIN classes ON student.class_id=classes.class_id
										WHERE student.class_id='$_GET[class_id]'", "50","attendance.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
							
								$thisstud = $getarray[stud_id];
								$studsex = $getarray[sex];
																
								$notattout .= "<div class='attend_rows'><h1>
											<select name=\"movetoclassroom[$thisstud]\" style=\"width: 200px;\">
											$classdrop
											</select>
											$getarray[lastname], $getarray[firstname] $getarray[middlename] $getarray[chinesename] 
											<a href='student-hm.php?stud_id=$getarray[stud_id]'>($sex_array[$studsex] | $getarray[dob])</a></h1></div>";
							}
								
								
								$studsout = "<form name=\"submitatt\" method=\"get\" action=\"classrooms.php\">
												$outputtext_class $outputtext_date<br><br> $notattout<br>
												<input type=\"submit\" name=\"submit\" value=\"submit\" />
												</form><br>";
									
						} else {
									
								$studsout = "<br>No results";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/txt_classrooms.gif\" /></h1></div>$studsout");	
						
	
	} else {

	/*------------------------------------ show Classroom  ----------------------------*/
	
		
			$rs = new MysqlPagedResultSet("SELECT classes.class_id, classes.class_name, classes.class_capacity, classes.class_capacity_used 
										  FROM classes ORDER BY class_name", "100","classrooms.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
										
								$current_cap = $getarray[class_capacity] - $getarray[class_capacity_used];
								$classrooms .= "<div class='stud_rows'><img src=\"img/icon_classroom_small.gif\" align=\"left\"/>
												<h1>Classroom : $getarray[class_name]</h1>
												Capacity:  $current_cap |
												<a href='editclassroom.php?class_id=$getarray[class_id]'>edit</a> | 
												<a href='student.php?classname=$getarray[class_id]&submit=show+results'>show students</a> | 
												<a href='comments.php?class_id=$getarray[class_id]'>show comments</a> | 
												<a href='classrooms.php?updatedstudents=true&class_id=$getarray[class_id]'>update students</a></div>";
							}
									
						} else {
									
								$classrooms = "<br>No classes found! <br><br>";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/txt_classrooms.gif\" /></h1></div><br><br>$classrooms");
						
						
	}	
		
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>