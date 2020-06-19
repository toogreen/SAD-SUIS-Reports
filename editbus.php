<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");

dbConnect ('');
	
$t = new Template("templates");

$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "bus.htm",
		"form" => "busdetails.htm"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);
	
	
	
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
	
						$bus_id = $_POST[bus_id];
						$bus_name = $_POST[bus_name];
						$bus_route = $_POST[bus_route];
						$bus_totalcapacity = $_POST[bus_totalcapacity];
					
					
			//---------------- make the text save --------------------

						$bus_name = addslashes($bus_name);				
				
								
			//--------------------- set query -------------------------
			
						$set = "bus_name = '$bus_name',
								bus_totalcapacity = '$bus_totalcapacity',
								bus_route = '$bus_route'";
								
				
						
			//-------------------------- Update ------------------------------ 
			
			
				if($bus_id != "") {
				
						//if it's an update, we need to check that the capacity value hasn't been set to 
						//a value that is small than the current number of students on this bus. 
						
						$check = mysql_query("SELECT bus_totalcapacity, bus_capacityused FROM bus WHERE bus_id='$bus_id'");
						$getarray = mysql_fetch_array($check);
						
							if($bus_totalcapacity < $getarray[bus_capacityused]){
								message("Error. Capacity is smaller than number of students on this bus!", "transport.php");
								exit();
							}						  
				
						$update = mysql_query("UPDATE bus SET $set WHERE bus_id='$bus_id'");
						
						message("Bus has been updated", "transport.php");
						exit();
				
				} else {
					
						$update = mysql_query("INSERT INTO bus SET $set");	
						
						message("Bus has been created", "transport.php");
						exit();				
					
				}
					
				
/* -------------------------------------------------------------------------------------------- */	
/* ------------------------------------ Display the form -------------------------------------- */
/* -------------------------------------------------------------------------------------------- */

	
	} else {

			//---- Number of seats in a bus -------
			for($i=0; $i<150; $i++) {
					$capacityarray[] .= $i;
			}											

		/*------------------------------------ Edit student profile ----------------------------*/
		
		
			if($_GET[bus_id] != ""){
			
				$bus_id = $_GET[bus_id];
				$get = mysql_query("SELECT * FROM bus WHERE bus_id='$bus_id'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);
											
						$t->set_var("BUSID","$bus_id");		
						$t->set_var("BUSNAME","$bus_name");			
						$t->set_var("BUSROUTE","$bus_route");
						$t->set_var("CAPACITY", dropdown($capacityarray,"bus_totalcapacity","$bus_totalcapacity","no"));

						
					}
					
		/*------------------------------- Create new student profile ----------------------------------*/

		
			} else {
			
		
						//General
									
						$t->set_var("BUSID","$bus_id");		
						$t->set_var("BUSNAME","$bus_name");			
						$t->set_var("BUSROUTE","$bus_route");
						$t->set_var("CAPACITY", dropdown($capacityarray,"bus_totalcapacity","$bus_totalcapacity","no"));
				

			} // if isset $bus_id
			
		} // if isset $submit
			


		$t->parse(MAINSTAGE, "form");
		$t->parse(CONTENT, "main");		
		$t->pparse(MAIN, "body");
		
	
	
?>