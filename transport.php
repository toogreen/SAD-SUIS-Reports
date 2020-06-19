<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"searchform" => "searchform.htm",
		"main" => "bus.htm"));

	
	$t->set_var(LOGINNAME, $_SESSION[uid]);

	
	/*--------------------------- Check the user level -------------------*/
	
		if(checklevel("student_transport", $mylevel) == "0"){
			message("You have no permission to access this page", "index.php", "3");
			exit();
		}


		//----------------------------- The Query ----------------------------------//
		
		$rs = new MysqlPagedResultSet("SELECT bus_id, bus_name, bus_route, bus_totalcapacity, bus_capacityused FROM bus ORDER BY bus_name","100","bus.php" );
		if($rs->getTotalNum() > "0") {
		
		
			//Output a top headline with number of results and stuff
			//let's just use a table here for the 2 column thing, css tai mafan
			$topnavipages = "<div class=\"SectionHeader\"><br><img src=\"img/txt_busses.gif\"/></div><br>
						<div class='bluebox'>
						<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">
							<tr>
								<td>" . $rs->getTotalNum() . " record(s) found</td>
								<td align='center'>" . 
								$rs->getPageNb("") . "</td>
								</tr>
							</table>
						</div>
						<br>";
			
			//And the output all the results
			while ($GetDataArray = $rs->fetchArray()) {
			extract($GetDataArray);
							
				//current capacity
				$curcentcapacity = $bus_totalcapacity - $bus_capacityused;				
							
				$studs .= "<div class='stud_rows'><h1><img src=\"img/icon_bus_small.gif\" align=\"left\"/>$bus_name</h1>
							Route: $bus_route<br>
							Total capacity: $bus_totalcapacity | Current capacity: $curcentcapacity | 
							<a href='student.php?bus=$bus_id&submit=submit'>Show students</a> | 
							<a href='editbus.php?bus_id=$bus_id'>Edit</a> | <a href='editbus.php?deletebus=$bus_id'>Delete</a></div>";
			
			
			}
			
		
			$t->set_var(MAINSTAGE, "$topnavipages $studs");
		
		} else {

			$t->set_var(MAINSTAGE, "No Busses added yet. <a href='busdetails.php'>Add a new bus here</a>");		
		
		} 
			
		
	
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>
