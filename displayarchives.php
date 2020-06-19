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
	
	

		$resultpage = $_GET[resultpage];
						
						
						
		//------------------------- Build the search query ------------------------ //
					
			$where = "WHERE student.archived = '1'";
					

		//----------------------------- The Query ----------------------------------//
		
		$rs = new MysqlPagedResultSet("SELECT student.status, student.stud_id, student.stud_nb, student.temp_stud_nb, 
										student.firstname, student.middlename, student.lastname, 
									   	student.chinesename, student.preferedname, student.sex, 
									   	student.enrolled, classes.class_name, student.appliesforgrade 
									   	FROM student
									  	LEFT JOIN bus_lookup ON bus_lookup.stud_id=student.stud_id
									  	LEFT JOIN classes ON student.class_id=classes.class_id
									  	$where",
										"40","displayarchives.php");
		if($rs->getTotalNum() > "0") {
		
		
			//mysearch
					$mysearch = "Displaying all archived user";
							
		
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
				

				
				$studs .= "<div class='stud_rows'><h1>
							<img src=\"img/icon_stud_small.GIF\" align=\"left\"/>
							$firstname $middlename $lastname $chinesename (<font color=\"#005aff\">Archived</font>)</h1>
							Nb: $temp_stud_nb | $sex_array[$sex] | 
							<a href=\"student-hm.php?stud_id=$stud_id\">View</a></div>";
			
			}
			

			
			$t->set_var(MAINSTAGE, "$topnavipages $studs");
		
		//no results
		} else {
		
			message("No results match your query", "student.php");
			exit();
			
		}
			
	
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>