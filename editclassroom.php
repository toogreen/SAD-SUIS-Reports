<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "classrooms.htm",
		"form" => "classroomdetails.html"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);

	
	
	//---------------- Delete the bus --------------------
	
		if(isset($_GET[deletebus])){
		
			//check first if there are still student on this bus. If YES, than don't allow to delete this bus
			$count = mysql_query("SELECT COUNT(*) as onbus FROM bus_lookup WHERE bus_id='$_GET[deletebus]'");
			$getarray = mysql_fetch_array($count);
			
			
			if($getarray[onbus] > "0") {
			
				message("Error. Can only delete empty busses","transport.php");
				exit();
			
			}
			
			$del = mysql_query("DELETE FROM bus WHERE bus_id='$_GET[deletebus]'");
			message("Bus deleted", "transport.php");
			exit();
		
		
		}
	
/* -------------------------------------------------------------------------------------------- */	
/* ----------------------------------- Form was submitted ------------------------------------- */
/* -------------------------------------------------------------------------------------------- */


	if(isset($_POST[submit])) {
	
						$class_id = $_POST[class_id];
						$class_name = $_POST[class_name];
						$class_grade = $_POST[class_grade];
						$class_capacity = $_POST[class_capacity];
						$class_ht = $_POST[class_ht];
						$class_stream = $_POST[class_stream];
					
					
			//---------------- make the text save --------------------

						$class_name = addslashes($class_name);				
				
								
			//--------------------- set query -------------------------
			
						$set = "class_name = '$class_name',
								class_grade = '$class_grade',
								class_capacity = '$class_capacity',
								class_ht = '$class_ht',
								class_stream = '$class_stream'";
								
								
								
			//-------------------------- Update ------------------------------ 
			
				if($class_id != "") {
											  
						$update = mysql_query("UPDATE classes SET $set WHERE class_id='$class_id'");
						
						message("Classroom has been updated", "classrooms.php");
						exit();
				
				} else {
					
						$insert = mysql_query("INSERT INTO classes SET $set");	
						
						message("Classroom $class_name has been created", "classrooms.php");
						exit();				
					
				}
				
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {

			//---- Number of seats in a classroom -------
			for($i=0; $i<150; $i++) {
					$capacityarray[] .= $i;
			}		
			
										
		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[class_id] != ""){
			
				$class_id = $_GET[class_id];
				$get = mysql_query("SELECT * FROM classes WHERE class_id='$class_id'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
											
						$t->set_var("CLASSID","$class_id");		
						$t->set_var("CLASSNAME","$class_name");		
						$t->set_var("GRADE", dropdown($gradesarray,"class_grade","$class_grade","no"));	
						$t->set_var("CAPACITY", dropdown($capacityarray,"class_capacity","$class_capacity","no"));
						$t->set_var("CLASSHT","$class_ht");
						$t->set_var("CLASSSTREAM","$class_stream");

						
					}
					
		/*------------------------------- Create new class profile ----------------------------------*/

		
			} else {
			
		
						//General
									
						$t->set_var("CLASSID","");		
						$t->set_var("CLASSNAME","");	
						$t->set_var("GRADE", dropdown($gradesarray,"class_grade","","no"));			
						$t->set_var("CAPACITY", dropdown($capacityarray,"class_capacity","","no"));
						$t->set_var("CLASSHT","");
						$t->set_var("CLASSSTREAM","");
				

			} // if isset $class_id
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>