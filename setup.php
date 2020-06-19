<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"content" => "setupmain.htm",
		"setupuser" => "setup_user.html",
		"setupuserrights" => "setup_userrights.html",
		"setupcountries" => "setup_countries.html"));


	$t->set_var(LOGINNAME, $_SESSION[uid]);
	

	/*--------------------------- Check the user level -------------------*/
	
		if(checklevel("accesssetup", $mylevel) == "0"){
			message("You have no permission to access this page", "index.php", "3");
			exit();
		}
		
		
	/* ------------------- drop a user --------------------------------- */

		if(($_GET[dropuser] == "true")) {
			
			$del = mysql_query("DELETE FROM user WHERE user_id='$_GET[drop_user_id]' LIMIT 1");
					
			message("User deleted", "setup.php?t=user");
			exit();				

		}
		

	/* ------------------- drop a level --------------------------------- */

		if(($_GET[droplevel] == "true")) {
		
			//first check if there are students with that nation. If yes, than don't deltete
			$check = mysql_query("SELECT COUNT(*) AS countlevel FROM user WHERE user.level='$_GET[level_id]'");
			$getarray = mysql_fetch_array($check);
				if($getarray[countlevel] > "0") {
					
					message("Can't delete this level. Some user are still set to this level", "setup.php?t=levels");
					exit();
							
				} else {
				
					$del = mysql_query("DELETE FROM user_level WHERE level_id='$_GET[level_id]' LIMIT 1");
					
					message("Level deleted", "setup.php?t=levels");
					exit();				
					
				}
		}

	/* ------------------- drop a nation --------------------------------- */

		if(($_GET[dropnation] == "true")) {
		
			//first check if there are students with that nation. If yes, than don't deltete
			$check = mysql_query("SELECT COUNT(*) AS countnations FROM student WHERE student.nationality='$_GET[nation_id]'");
			$getarray = mysql_fetch_array($check);
				if($getarray[countnations] > "0") {
					
					message("Can't delete this country. Update all students with this country first", "student.php?nation=$_GET[nation_id]&submit=show+results");
					exit();
							
				} else {
				
					$del = mysql_query("DELETE FROM nations WHERE nation_id='$_GET[nation_id]' LIMIT 1");
					
					message("Country deleted", "setup.php?t=countries");
					exit();				
					
				}
		}

	/* ------------------- submit a new country --------------------------------- */

		if(isset($_GET[submit])) {
		
			if($_GET[nationname] != ""){
			
				$add = mysql_query("INSERT INTO nations SET nation_name = '$_GET[nationname]'");
				
				message("$_GET[nationname] added", "setup.php?t=countries");
				exit();
				
			} 
		}

/* ------------------------------------------------------------------------------------------- */
/* ---------------------------------------- Show forms --------------------------------------- */
/* ------------------------------------------------------------------------------------------- */


	if($_GET[t] == "countries") {
	
		/* ------------------- show countries --------------------------------- */
		
		$get = mysql_query("SELECT * FROM nations ORDER BY nation_name");
		while($getarray = mysql_fetch_array($get)) {
		
			$nationsout .= "<div class='countries_rows'><h1>$getarray[nation_name] 
							<a href='student.php?nation=$getarray[nation_id]&submit=show+results'>show all students</a> | 
							<a href='setup.php?dropnation=true&nation_id=$getarray[nation_id]'>drop</a></h1></div>";
		
		}
		
		$t->set_var("COUNTRYROWS", $nationsout);
		$t->parse(MAINSTAGE, "setupcountries");
		
	} elseif($_GET[t] == "levels") {

		/* ------------------- show level --------------------------------- */
		
		$get = mysql_query("SELECT * FROM user_level ORDER BY level_id");
		while($getarray = mysql_fetch_array($get)) {
		
			$levelsout .= "<div class='countries_rows'><h1>$getarray[level_name] 
							<a href='level-edit.php?level_id=$getarray[level_id]'>edit</a> | 
							<a href='setup.php?droplevel=true&level_id=$getarray[level_id]'>drop</a></h1></div>";
		
		}
		
		$t->set_var("LEVELROWS", $levelsout);

		$t->parse(MAINSTAGE, "setupuserrights");	
		

	} elseif($_GET[t] == "user") {

		/* ------------------- show user --------------------------------- */
		
		$get = mysql_query("SELECT user_id AS this_user_id, uid AS this_user_uid, user_realname AS this_user_realname 
							FROM user
							WHERE is_superadmin != '1' 
							ORDER BY uid");
		while($getarray = mysql_fetch_array($get)) {
		
			$userout .= "<div class='countries_rows'><h1>$getarray[this_user_realname] | uid: $getarray[this_user_uid]  
							<a href='user-edit.php?user_id=$getarray[this_user_id]'>edit</a> | 
							<a href='setup.php?dropuser=true&drop_user_id=$getarray[this_user_id]'>drop</a></h1></div>";
		
		}
		
		$t->set_var("USERROWS", $userout);

		$t->parse(MAINSTAGE, "setupuser");		
	
	
	} else {
	
			$t->set_var(MAINSTAGE, "Choose from the navigation on the right");
	}
	
	
$t->parse(CONTENT, "content");		
$t->pparse(MAIN, "body");
?>