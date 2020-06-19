<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "attendance.htm"));

	
	$resultpage = $_GET[resultpage];
		
		
	$t->set_var(LOGINNAME, $_SESSION[uid]);


	/*--------------------------- Check the user level -------------------*/
	
		if(checklevel("student_attendance", $mylevel) == "0"){
			message("You have no permission to access this page", "index.php", "3");
			exit();
		}
		
		
//---------------- Stuff for the drop down menus on the right pannel  -----------------------//


				//get all the classes
				$get = mysql_query("SELECT class_id, class_name FROM classes");
														
						if(mysql_num_rows($get) > "0"){
							while($getarray = mysql_fetch_array($get)){
										
								$classesdrop .= "<option value='$getarray[class_id]'>$getarray[class_name]</option>";
							}
						}
									

				$t->set_var("CLASSESDROP", "<select name=\"class_id\" style=\"width: 220px; margin-top:5px\">
							<option value='' selected></option>$classesdrop</select>");
							

	/*------------------------------------ What date is it  ----------------------------*/
	
		$start  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
		
		$t->set_var(SHORTDATE, date("D dS",$start));		
		$longdate = date("D dS F Y",$start);
		$today = date("Y-m-d",$start);



	/*------------------------------------ Edit a single attandency  ----------------------------*/
	
		if(isset($_GET[editsingle])) {
		
		

			//--------------------------- Check the level ------------------------------//		
			if(checklevel("student_attendance", $mylevel) < "2"){
				message("You have no permission to perform this operation", "attendance.php", "3");
				exit(); }
			//--------------------------------------------------------------------------//	
			
		
			$update = mysql_query("UPDATE attend SET att_status='$_GET[att_status]' WHERE attend_id='$_GET[attend_id]' LIMIT 1");
			if($update) {
			
				message("Student attendance status updated", "attendance.php");
				exit();
				
			}
		
		}


	/*------------------------------------ SFormular was submitted  ----------------------------*/
	
		if(isset($_GET[submit])) {
		
	
			//--------------------------- Check the level ------------------------------//		
			if(checklevel("student_attendance", $mylevel) < "2"){
				message("You have no permission to perform this operation", "attendance.php", "3");
				exit(); }
			//--------------------------------------------------------------------------//	
		
			foreach($_GET[attending] AS $key=>$element){
				
				$insert = mysql_query("INSERT INTO attend SET att_date='$today', att_stud_id='$key', att_class='$_GET[class_id]', att_status='$element'");
			
			}
			
			message("Input ok", "attendance.php");
			exit();
		
		}
	
	
	
	if (isset($_GET[search])) {
	

	/*------------------------------------ Search, and output one class for one date  ----------------------------*/
			
		//with class or without
		$where = " WHERE attend_id > '0'";
		
		if($_GET[class_id] != "") {
		
			//get the class name for the headline
			$getname = mysql_query("SELECT class_name FROM classes WHERE class_id='$_GET[class_id]'");
			$getarray = mysql_fetch_array($getname);
			
			$outputtext_class = "of class  <b>$getarray[class_name]</b>";
			
			$where .= " AND attend.att_class='$_GET[class_id]'";
		
		}
		
		if($_GET[searchdate] != "") {
		
			$where .= " AND att_date='$_GET[searchdate]'";
			$outputtext_date = "on  <b>$_GET[searchdate]</b>";
		
		}
				
		$rs = new MysqlPagedResultSet("SELECT attend_id, attend.att_stud_id, student.firstname, student.lastname, student.chinesename, class_name, att_status 
										FROM student
										LEFT JOIN attend ON student.stud_id=attend.att_stud_id
										LEFT JOIN classes ON student.class_id=classes.class_id
										$where
										AND student.archived != '1'", "500","attendance.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
								
								$status = $getarray[att_status];
								
								$notattout .= "<div class='stud_rows'>
											<form  name=\"submitsingle\" method=\"get\" action=\"attendance.php\" style=\"padding: 0px; border: 0px;\">
											<h1><img src=\"img/icon_stud_small.GIF\" align=\"left\"/>
											$getarray[firstname], $getarray[lastname] $getarray[middlename] 
											$getarray[chinesename]</h1>$attend_array[$status] | change to : 
											<select name='att_status' style='font-size: 9px; width:100px; margin-right: 5px;'>
											<option value='0' selected>attending</option>
											<option value='1'>Attending - late</option>
											<option value='2'>Not attending - excused</option>
											<option value='3'>Not attending - unexcused</option>
											</select>
											<input name=\"attend_id\" type=\"hidden\" value=\"$getarray[attend_id]\" />
											<input name=\"thisstud\" type=\"hidden\" value=\"$getarray[att_stud_id]\" />
											<input name=\"class_id\" type=\"hidden\" value=\"$_GET[show_class]\" />
											<input type=\"submit\" name=\"editsingle\" value=\"submit\" style=\"font-size: 8px;\" />
											</form>
											</div>";
								}
								
								
								$detentions = "Attendance $outputtext_class $outputtext_date<br><br> $notattout";
									
						} else {
									
								$detentions = "<br>No results";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/icon_attendance.gif\" /></h1></div><br><br>$detentions");				
	
	
	
	} elseif(isset($_GET[class_id])) {
	
	/*------------------------------------ Show the list of the class  ----------------------------*/
	
	
		//get the class name and stuff
		$get = mysql_query("SELECT class_name FROM classes WHERE class_id='$_GET[class_id]'");
		$getclassname = mysql_fetch_array($get);
		
	
		$rs = new MysqlPagedResultSet("SELECT firstname, lastname, chinesename, stud_id, sex, dob  
										FROM student
										WHERE class_id=$_GET[class_id]
										AND student.archived != '1'
										ORDER BY firstname, lastname", "100","attendance.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
								
								$status = $getarray[att_status];
								$studsex = $getarray[sex];
								
								$thisstud = $getarray[stud_id];
								$notattout .= "<div class='attend_rows'><h1>" . dropdown($attend_array,"attending[$thisstud]","$sex","no") . "
											$getarray[firstname], $getarray[lastname] $getarray[middlename] $getarray[chinesename] 
											<a href='student-hm.php?stud_id=$getarray[stud_id]'>($sex_array[$studsex] | $getarray[dob])</a></h1></div>";
								}
								$detentions = "<h1>Set attendence for class <b>$getclassname[class_name]</b> on <b>$longdate</b></h1><br> 
												<form  name=\"submitatt\" method=\"get\" action=\"attendance.php\">
												<div class='schoolbox'>$notattout <br><input name=\"class_id\" type=\"hidden\" value=\"$_GET[class_id]\" />
												<input type=\"submit\" name=\"submit\" value=\"submit\" /></div></form>";
									
						} else {
									
								$detentions = "<br>No students found";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/icon_attendance.gif\" /></h1></div><br><br>$detentions");		
	
	
	} elseif (isset($_GET[show_class])) {
	
	
	/*------------------------------------ Show the class that has already been submitted  ----------------------------*/
				
		$rs = new MysqlPagedResultSet("SELECT attend_id, attend.att_stud_id, student.firstname, student.lastname, student.chinesename, class_name, att_status 
										FROM student
										LEFT JOIN attend ON student.stud_id=attend.att_stud_id
										LEFT JOIN classes ON student.class_id=classes.class_id
										WHERE student.class_id=$_GET[show_class] AND att_date='$today' ORDER BY firstname", "100","attendance.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
								
								$status = $getarray[att_status];
								
								$notattout .= "<div class='stud_rows'>
											<form  name=\"submitsingle\" method=\"get\" action=\"attendance.php\" style=\"padding: 0px; border: 0px;\">
											<h1><img src=\"img/icon_stud_small.GIF\" align=\"left\"/>
											$getarray[firstname], $getarray[lastname] $getarray[middlename] 
											$getarray[chinesename]</h1>$attend_array[$status] | change to : 
											<select name='att_status' style='font-size: 9px; width:100px; margin-right: 5px;'>
											<option value='0' selected>attending</option>
											<option value='1'>Attending - late</option>
											<option value='2'>Not attending - excused</option>
											<option value='3'>Not attending - unexcused</option>
											</select>
											<input name=\"attend_id\" type=\"hidden\" value=\"$getarray[attend_id]\" />
											<input name=\"thisstud\" type=\"hidden\" value=\"$getarray[att_stud_id]\" />
											<input name=\"class_id\" type=\"hidden\" value=\"$_GET[show_class]\" />
											<input type=\"submit\" name=\"editsingle\" value=\"submit\" style=\"font-size: 8px;\" />
											</form>
											</div>";
								}
								$detentions = "Attendence for class <b>$class_name</b> on  <b>$longdate</b><br><br> $notattout";
									
						} else {
									
								$detentions = "<br>No results";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/icon_attendance.gif\" /></h1></div><br><br>$detentions");
			
			
			
	}  else {
	
	/*------------------------------------ Wh's not here today  ----------------------------*/
		
		$rs = new MysqlPagedResultSet("SELECT attend.att_stud_id, student.firstname, student.lastname, student.chinesename, class_name, att_status 
										FROM student
										LEFT JOIN attend ON student.stud_id=attend.att_stud_id
										LEFT JOIN classes ON student.class_id=classes.class_id
										WHERE attend.att_date='$today' AND att_status > '1' ORDER BY firstname", "100","attendance.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
								
								$status = $getarray[att_status];
								
								$notattout .= "<div class='stud_rows'><h1><img src=\"img/icon_stud_small.GIF\" align=\"left\"/>
											$getarray[firstname], $getarray[lastname] $getarray[middlename] 
											$getarray[chinesename]</h1>Class: $getarray[class_name] | $attend_array[$status]
											[<a href='student-hm.php?stud_id=$getarray[att_stud_id]'>show profile</a>]</div>";
								}
								$detentions = "Not attending students for <b>$longdate</b><br><br> $notattout";
									
						} else {
									
								$detentions = "<br>No results";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/icon_attendance.gif\" /></h1></div><br><br>$detentions");
						
	}
	
						
	/*----------------------------- List with classes / studs for right column  ------------------------*/
					
					
			//nice and tricky ... We get all the attendane inputs for this day, and group them by class. 
			//This we put in an array $attendclasses. This then holds all the classes that teachers already set attendence values for
			//Then we loop through all classes, and divide them according to in_array
			
			$attendclasses = array();
			
			$get = mysql_query("SELECT att_class FROM attend WHERE att_date='$today' GROUP BY att_class");
			if(mysql_num_rows($get) > "0") {
				while($getarray = mysql_fetch_array($get)){
					extract($getarray);
					$attendclasses[] = $att_class;
				}
			}	 
				
			
			//show those classes where attendance hasn't been set for this given day
			$get = mysql_query("SELECT class_id, class_name 
								FROM classes 
								ORDER BY class_name");
			if(mysql_num_rows($get) > "0") {
				
				while($getarray = mysql_fetch_array($get)){
					
						if(in_array($getarray[class_id], $attendclasses)) {
							$classesok .= "<li><a href='attendance.php?show_class=$getarray[class_id]'>Class $getarray[class_name]</a></li>";
						} else {
							$classestodo .= "<li><a href='attendance.php?class_id=$getarray[class_id]'>Class $getarray[class_name]</a></li>";
						}
				}
				
				$t->set_var("CLASSESOK","<ul>$classesok</ul>");
				$t->set_var("CLASSESTODO","<ul>$classestodo</ul>");
			
			}	
		
	
						
		
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>
