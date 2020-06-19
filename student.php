<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"searchform" => "searchform.htm",
		"main" => "student.htm"));


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


//-------------- set variable to print students A4 pages off if not specified --------------//
	$t->set_var("BUTTON_PRINTALLA4","");	

	if($_GET[submit]) {
	
	
			$stud_id = $_GET[stud_id];
			$lastname = $_GET[lastname];
			$firstname = $_GET[firstname];
			$middlename = $_GET[middlename];
			$chinesename = $_GET[chinesename];
			$fathername = $_GET[fathername];
			$mothername = $_GET[mothername];
			$sex = $_GET[sex];
			$enrolled = $_GET[enrolled];
			$descent = $_GET[descent];
			$nation = $_GET[nation];
			$month = $_GET[month];
			$year = $_GET[year];
			$bus = $_GET[bus];
			$enrolled_day_from = $_GET[enrolled_day_from];
			$enrolled_year_from = $_GET[enrolled_year_from];
			$enrolled_day_until = $_GET[enrolled_day_until];
			$enrolled_year_until = $_GET[enrolled_year_until];
			$classname = $_GET[classname];
			$pay_tut = $_GET[pay_tut];
			$pay_appl = $_GET[pay_appl];
			$pay_seat = $_GET[pay_seat];
			$pay_dorm = $_GET[pay_dorm];
			$pay_uni = $_GET[pay_uni];
			$status = $_GET[status];
			$appliesforgrade = $_GET[appliesforgrade];
			$resultpage = $_GET[resultpage];
						
						
						
		//------------------------- Build the search query ------------------------ //
					
					$where = "WHERE student.archived != '1'";
					
					if($status != "") {
						$where .= " AND student.status = '$status'";
					}

					if($appliesforgrade > "0") {
						$where .= " AND student.appliesforgrade = '$appliesforgrade'";
						$searchphrase[] .= " Applies for grade: <b>$appliesforgrade</b> ";
					}
					
					if($lastname != "") {
						$where .= " AND lastname LIKE '%$lastname%'";
						$searchphrase[] .= " Family Name: <b>$lastname</b> ";
					}
					
					if($firstname != "") {
						$where .= " AND firstname LIKE '%$firstname%'";
						$searchphrase[] .= " First name: <b>$firstname</b> ";
					}
					
					if($fathername != "") {
						$where .= " AND fathername LIKE '%$fathername%'";
						$searchphrase[] .= " Farther's name: <b>$fathername</b> ";
					}
					
					if($mothername != "") {
						$where .= " AND mothername LIKE '%$mothername%'";
						$searchphrase[] .= " Mother's name: <b>$mothername</b> ";
					}
					
					if($chinesename != "") {
						$where .= " AND chinesename LIKE '%$chinesename%'";
						$searchphrase[] .= " Chinese name: <b>$chinesename</b> ";
					}
										
					if($nation > "0") {
						$where .= " AND nationality = '$nation'";
						$get = mysql_query("SELECT nation_name FROM nations WHERE nation_id='$nation'");
						$getarray = mysql_fetch_array($get);
						$searchphrase[] .= " Nationality: <b>$getarray[nation_name]</b> ";
					}
					
					if($sex != "") {
						$where .= " AND sex = '$sex'";
						$searchphrase[] .= " Gender: <b>$sex_array[$sex]</b> ";
					}
		
					if($descent != "") {
						$where .= " AND descent = '$descent'";
						$searchphrase[] .= " Descent: <b>$descent_array[$descent]</b> ";
					}
					
					
					if($month != "") {
						$where .= " AND DATE_FORMAT(dob, '%m' ) = '$month'";
						$searchphrase[] .= " DOB month: <b>$month</b> ";
					}
		
					if($year != "") {
						$where .= " AND DATE_FORMAT(dob, '%Y' ) = '$year'";
						$searchphrase[] .= " DOB year: <b>$year</b> ";
					}
					
					if($bus != "") {
						$where .= " AND bus = '$bus' ORDER BY student.firstname";

						$get = mysql_query("SELECT bus_name FROM bus WHERE bus_id='$bus'");
						$getarray = mysql_fetch_array($get);
						$searchphrase[] .= " on bus: <b>$getarray[bus_name]</b> ";
					}
					
					if($enrolled_year_from != ""){
						$where .= " AND DATE_FORMAT(enrolled, '%Y' ) >= '$enrolled_year_from'";
						$searchphrase[] .= " Enrolled after or in year: <b>$enrolled_year_from</b> ";
					}
					
					if($enrolled_month_from != ""){
						$where .= " AND DATE_FORMAT(enrolled, '%m' ) >= '$enrolled_month_from'";
						$searchphrase[] .= " Enrolled after or in month: <b>$enrolled_month_from</b> ";
					}
					
					if($enrolled_year_until != ""){
						$where .= " AND DATE_FORMAT(enrolled, '%Y' ) <= '$enrolled_year_until'";
						$searchphrase[] .= " Enrolled before or in year: <b>$enrolled_year_until</b> ";
					}
					
					if($enrolled_month_until != ""){
						$where .= " AND DATE_FORMAT(enrolled, '%m' ) <= '$enrolled_month_until'";
						$searchphrase[] .= " Enrolled before or in month: <b>$enrolled_month_until</b> ";
					}
					
					if($classname != "") {
						$where .= " AND student.class_id = '$classname' ORDER BY student.firstname";
						
						//get all classnames
						$get = mysql_query("SELECT class_name FROM classes WHERE class_id='$classname'");
						$getarray = mysql_fetch_array($get);
						$searchphrase[] .= " Classroom: <b>$getarray[class_name]</b> ";
						
						// Since a class in particular is specified, let's create and enable a button printing
						$button_printalla4 = "<a href='student-a4-print.php?class_id=$classname&interim=$interim&syear=$syear&print=1'><img src='img/print.png' border='0' alt=''>&nbsp;&nbsp;VIEW AND/OR PRINT all of the above on A4 sheets</a>";
						$t->set_var("BUTTON_PRINTALLA4",$button_printalla4);
					}
					
					if($pay_tut != "") {
						$where .= " AND student.pay_tut = '$pay_tut'";
						$searchphrase[] .= " Tuition fee: <b>$payment_array[$pay_tut]</b> ";
					}
					
				
					if($pay_appl != "") {
						$where .= " AND student.pay_appl = '$pay_appl'";
						$searchphrase[] .= " Application fee: <b>$payment_array[$pay_appl]</b> ";
					}

					if($pay_seat != "") {
						$where .= " AND student.pay_seat = '$pay_seat'";
						$searchphrase[] .= " Seat deposit fee: <b>$payment_array[$pay_seat]</b> ";
					}

					if($pay_bus != "") {
						$where .= " AND student.pay_bus = '$pay_bus'";
						$searchphrase[] .= " Bus: <b>$payment_array[$pay_bus]</b> ";
					}

					if($pay_dorm != "") {
						$where .= " AND student.pay_dorm = '$pay_dorm'";
						$searchphrase[] .= " Dorm: <b>$payment_array[$pay_dorm]</b> ";
					}

					if($pay_uni != "") {
						$where .= " AND student.pay_uni = '$pay_uni'";
						$searchphrase[] .= " Uniform: <b>$payment_array[$pay_uni]</b> ";
					}
					
					

		//----------------------------- The Query ----------------------------------//
		
		$rs = new MysqlPagedResultSet("SELECT student.status, student.stud_id, student.stud_nb, student.temp_stud_nb, 
										student.firstname, student.middlename, student.lastname, 
									   	student.chinesename, student.preferedname, student.sex, 
									   	student.enrolled, classes.class_name, student.appliesforgrade 
									   	FROM student
									  	LEFT JOIN bus_lookup ON bus_lookup.stud_id=student.stud_id
									  	LEFT JOIN classes ON student.class_id=classes.class_id
									  	$where",
										"30","student.php");
		if($rs->getTotalNum() > "0") {
		
		
			//mysearch
					$mysearch = "Status: <b>$status_array[$status]</b>";
					if($searchphrase != "") {
						foreach($searchphrase as $element) {
							$mysearch .= " <i>and</i> $element";
						}
					}
							
		
			//Output a top headline with number of results and stuff
			//let's just use a table here for the 2 column thing, css tai mafan
			$topnavipages = "<div class=\"SectionHeader\"><img src=\"img/txt_results.gif\"/></div><br>
						<div class='bluebox'>
						<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td>" . $rs->getTotalNum() . " record(s) found</td>
								<td align='center'>" . 
								$rs->getPageNb("lastname=$lastname&firstname=$firstname&chinesename=$chinesename&enrolled=$enrolled&nationality=$nationality&month=$month&year=$year&sex=$sex&descent=$descent&fathername=$fathername&mothername=$mothername&classname=$classname&submit=show&searchmode=$searchmode&status=$status") . "</td>
								</tr>
							</table>
							<br>
							Your search: " . $mysearch . "</div>
						<br>";
			
			//And the output all the results
			while ($GetDataArray = $rs->fetchArray()) {
			extract($GetDataArray);
				
				//status
				if($status == "0") {
				
				$studs .= "<div class='stud_rows'><h1>
							<img src=\"img/icon_stud_small.GIF\" align=\"left\"/>
							$firstname $middlename $lastname $chinesename (<font color='#ff0096'>inactive</font>)</h1>
							Nb: $temp_stud_nb | $sex_array[$sex] | Applies for grade: $appliesforgrade | 
							<a href='student-hm.php?stud_id=$stud_id'>View</a> | <a href='student-hm.php?stud_id=$stud_id'>Delete</a></div>";
							
				} else {
				
				$studs .= "<div class='stud_rows'><h1>
							<img src=\"img/icon_stud_small.GIF\" align=\"left\"/>
							$firstname $middlename $lastname $chinesename</h1>
							Nb: $stud_nb | $sex_array[$sex] | Class: $class_name | Enrolled: $enrolled | 
							<a href='student-hm.php?stud_id=$stud_id'>View</a> |
							<a href='student-a4.php?stud_id=$stud_id'>A4</a> | 
							<a href=comment_edit.php?new=true&stud_id=$stud_id>+ comment</a></div>";
				}
														
				

			
			
			}
			
			// Add the export box 
			
				$exportbox = "<div class='greybox'><img src=\"img/txt_exportstudentprofiles.gif\" />
							<form action=\"export.php\" method=\"get\" style=\"margin-top: 10px; margin-bottom: 10px;\">
							Export as <select name=\"export_format\" id=\"export_format\" style=\"width: 150px;\">
										<option value=\"excel\">Excel sheet</option>
										<option value=\"pdf\">PDF file</option>
										<option value=\"text\">Printversion (text only)</option>
										</select> with filename 
										<input name=\"filename\" type=\"text\" style=\"width: 150px; font-size: 12px;\" />
										<input name=\"go\" type=\"button\" value=\"go\" style=\"width: 50px; font-size: 11px;\"/> 
							</form>
							</div>";
			
			$t->set_var(MAINSTAGE, "$topnavipages $studs $exportbox");
		
		//no results
		} else {
		
			message("No results match your query", "student.php");
			exit();
			
		}
			
		
	} else {
	
	//----------------------------- Show the form ----------------------------------//
	

			//drop down menu with years
				$this_year = date(Y);
				$yeardrop = "<select name='year' style='margin-right: 5px'><option value=''></option>";
				
				for($i=1950; $i<$this_year; $i++) {
					$yeardrop .= "<option value='$i'>$i</option>";
				}
				
				$yeardrop .= "</select>";	
			
			
			//enrollment from year
				$enrolled_year_from_drop = "<select name='enrolled_year_from' style='margin-right: 5px'><option value=''></option>";
				
				for($i=1950; $i<2020; $i++) {
					$enrolled_year_from_drop .= "<option value='$i'>$i</option>";
				}
				
				$enrolled_year_from_drop .= "</select>";
				
				$t->set_var("ENROLLEDYEAR_FROM", $enrolled_year_from_drop);	
				
				
			//enrollment until year
				$enrolled_year_until_drop = "<select name='enrolled_year_until' style='margin-right: 5px'><option value=''></option>";
				
				for($i=1950; $i<2020; $i++) {
					$enrolled_year_until_drop .= "<option value='$i'>$i</option>";
				}
				
				$enrolled_year_until_drop .= "</select>";
				
				$t->set_var("ENROLLEDYEAR_UNTIL", $enrolled_year_until_drop);	
			

			//get all the busses
				$get = mysql_query("SELECT bus_id, bus_name, bus_totalcapacity, bus_capacityused FROM bus");
														
						if(mysql_num_rows($get) > "0"){
							while($getarray = mysql_fetch_array($get)){
										
								$busdrop .= "<option value='$getarray[bus_id]'>$getarray[bus_name]</option>";
							}
						}
						
				$t->set_var("BUSDROP", "<select name=\"bus\" style=\"width: 200px;\"><option value='' selected></option>$busdrop</select>");
				
						
			//get all the classes
				$get = mysql_query("SELECT class_id, class_name FROM classes");
														
						if(mysql_num_rows($get) > "0"){
							while($getarray = mysql_fetch_array($get)){
										
								$classesdrop .= "<option value='$getarray[class_id]'>$getarray[class_name]</option>";
							}
						}
									

				$t->set_var("CLASSESDROP", "<select name=\"classname\" style=\"width: 200px;\">
							<option value='' selected></option>$classesdrop</select>");
				
				
				$t->set_var("GRADEDROP", dropdown($gradesarray,"appliesforgrade","","yes"));
				
				
			//get all the nations
				$get = mysql_query("SELECT nation_id, nation_name FROM nations ORDER BY nation_name");
														
						if(mysql_num_rows($get) > "0"){
							while($getarray = mysql_fetch_array($get)){
										
								$nationsdrop .= "<option value='$getarray[nation_id]'>$getarray[nation_name]</option>";
							}
						}
									

				$t->set_var("NATIONSDROP", "<select name=\"nation\" style=\"width: 200px;\"><option value='' selected></option>$nationsdrop</select>");
				
				
			//payment stuff
				$t->set_var("PAYTUT", dropdown($payment_array,"pay_tut", "2", "yes"));
				$t->set_var("PAYAPPL", dropdown($payment_array,"pay_appl", "2", "yes"));
				$t->set_var("PAYSEAT", dropdown($payment_array,"pay_seat", "2", "yes"));
				$t->set_var("PAYBUS", dropdown($payment_array,"pay_bus", "2", "yes"));
				$t->set_var("PAYDORM", dropdown($payment_array,"pay_dorm", "2", "yes"));
				$t->set_var("PAYUNI", dropdown($payment_array,"pay_uni", "2", "yes"));
			
					
			$t->set_var("YEAR", $yeardrop);
			$t->set_var("SEXDROP", dropdown($sex_array,"sex","","yes"));
			$t->set_var("DESCENT", dropdown($descent_array,"descent","","yes"));

			$t->parse(MAINSTAGE, "searchform");
	
	}

$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>
