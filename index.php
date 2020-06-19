<?php
include("login.php");
include ("template.inc");		

$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"content" => "index.htm"));

dbConnect('');
	
	$t->set_var(LOGINNAME, $_SESSION[uid]);
	

				
	/*---------------------------- reset the password --------------------*/
	
	
		if(isset($resetpassword)){
				
			$update = mysql_query("UPDATE admin_user SET admin_pwd='$newpassword' WHERE admin_id='$admin_id'");
			if($update){
			
			//send email			
				message("Changed your password to '$newpassword'","index.php","5");
				exit();
			} 
		
		}
	
	
	
		//get all the classes
				$get = mysql_query("SELECT class_id, class_name FROM classes");
														
						if(mysql_num_rows($get) > "0"){
							while($getarray = mysql_fetch_array($get)){
										
								$classes .= "<div class='venues_letter'>
											<a href='student.php?status=1&classname=$getarray[class_id]&submit=show+results'>
											$getarray[class_name]</a></div>";
											
								$classesattend .= "<div class='venues_letter'>
											<a href='attendance.php?class_id=$getarray[class_id]'>
											$getarray[class_name]</a></div>";
											
							}
						}
									

				$t->set_var("CLASSES", "$classes");
				$t->set_var("CLASSESATTEND", "$classesattend");
				
				
					

	$t->parse(CONTENT, "content");		
	$t->pparse(MAIN, "body");
?>

