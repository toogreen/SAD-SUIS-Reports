<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "payment.htm"));

	
		$resultpage = $_GET[resultpage];
				
		$t->set_var(LOGINNAME, $_SESSION[uid]);

	
	/*--------------------------- Check the user level -------------------*/
	
		if(checklevel("student_payment", $mylevel) == "0"){
			message("You have no permission to access this page", "index.php", "3");
			exit();
		}
		

	/*------------------------------------ Detentions  ----------------------------*/


		$start  = mktime(0, 0, 0, date("m")  , date("d"), date("Y"));
		$tod = date("Y-m-d H",$start);
		
					
		$rs = new MysqlPagedResultSet("SELECT pay_seat_deadline, student.stud_id, student.stud_nb, student.firstname, student.middlename, student.lastname, 
									   student.chinesename, student.preferedname, student.sex, student.enrolled, classes.class_name 
									   FROM student
									   LEFT JOIN bus_lookup ON bus_lookup.stud_id=student.stud_id
									   LEFT JOIN classes ON student.class_id=classes.class_id
									   WHERE pay_seat_deadline < '$tod' AND pay_seat_deadline != '0000-00-00'", "10","student.php");
													
		
						if($rs->getTotalNum() > "0") {
									
							while ($getarray = $rs->fetchArray()) {
							
							extract($getarray);
										
							$studs .= "<div class='stud_rows'><h1>
							<img src=\"img/icon_stud_small.GIF\" align=\"left\"/>$firstname $middlename $lastname $chinesename</h1>
							Nb: $stud_nb | Seet deposit fee payment expired $pay_seat_deadline |
							<a href='student-hm.php?stud_id=$stud_id'>View profile</a></div>";
								
							}
								$outstandingpayment = "<br><br>$studs <br>" . $rs->getPageNb("");
									
						} else {
									
								$outstandingpayment = "<br>Nothing found! <br><br>$addlink";
										
						}
						
						
						$t->set_var("MAINSTAGE"," <div class=\"SectionHeader\"><h1><img src=\"img/icon_payment_white.gif\" /></h1></div><br><h2>Seat deposit fee outstanding payments</h2>$outstandingpayment");
						
						

		
		
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>