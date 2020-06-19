<?PHP

// date_default_timezone_set("Asia/Shanghai");	
	
/*-------------------------------------- Connect to the db --------------------------------------*/

	
		function dbConnect () {
		
			//Connect to the Database
			//$dbcnx = mysql_connect ("localhost", "da_admin", "DkvG09ug") or die();
			//$dbcnx = mysql_connect ("localhost", "root", "") or die();
			$dbcnx = mysql_connect ("localhost", "root", "4dm1nXmy5ql") or die();
		
			if(!$dbcnx) {
				echo("Could not establis a connection to the database, sorry");
				exit();
			} 
				
			//Just in case something went wrong
			if (!mysql_select_db("suis") ) {
				echo("No db connection, sorry");
				exit();
			}
			
			return $dbcnx;
		}



/*---------------------------------- Change to chinese time ---------------------------------------*/


		function showdate($date, $name) {
		
		//Accepts a PHP date Format dd-mm-yy and returns form drow
		//down menues with the given date in it 
		
			   $datarr = explode("-",$date);
			   $tagheute = $datarr[2];
			   $monatheute = $datarr[1];
			   $jahrheute = $datarr[0];
		
		
		//Tagesauswahl benötigt die Variable $tagheute
		
			 $day_list =  "<select name='" . $name . "day'>";
			
				  for($i=1; $i<=31; $i++) {
				  
					if ($i==$tagheute) {
						$day_list .= "<option value='$i' selected>$i</option>";
					} else {
						$day_list .= "<option value='$i'>$i</option>";
					}
				  }
			$day_list .= "</select>";
						
		
		//Monatsauswahl benötigt $monatheute
				 $month_list =  "<select name='" . $name . "month'>";
				
				  for($i=1; $i<=12; $i++) {
				  
					  if ($i==$monatheute) {
					  $month_list .= "<option value='$i' selected>$i</option>";
					  
					  } else {
					  $month_list .= "<option value='$i'>$i</option>";
					  }
				   }
					  $month_list .= "</select>";
					 
					 
		//Jahresauswahl benötigt $jahrheute
				 $year_list =  "<select name='" . $name . "year'>";
			 
		
			 $m = array("2005", "2006");
				
				  foreach($m as $element) {
				  
					  if ($element==$jahrheute) {
						  $year_list .= "<option value='$element' selected>$element</option>";
					  } else {
						  $year_list .= "<option value='$element'>$element</option>";
					  }
				  }
						  $year_list .= "</select>";
			
			$complete_drop = "$day_list $month_list $year_list";
			
			return $complete_drop;		     
		}



/*---------------------------------- Change to chinese time ---------------------------------------*/

		function change_to_chinese($timestamp){
				$server_offset = date( "Z" ); 
				$user_offset = 6 * 3600; 
				$timestamp = $timestamp + ($server_offset + $user_offset); 
				$timestamp = date('d.m/h.ia', $timestamp);
			return($timestamp);
		}
			

			
/*--------------- Class to output paged results of an database query -------------------------------*/

		class MysqlPagedResultSet {
		
		var $results;
		var $pageSize;
		var $page;
		var $row;
		var $anz;
		var $status_message;
		var $pathto;
		
			function MysqlPagedResultSet($query,$pageSize,$pathto) {
				global $resultpage; // für ältere PHP Versionen
				//$resultpage = $_GET['resultpage']; // für neuere PHP Versionen
		
				$this->results = mysql_query($query);
				$this->pageSize = $pageSize;
				$this->pathto = $pathto;
				if((int)$resultpage <= 0) $resultpage = 1;
			
				if($resultpage > $this->getNumPages())
					$resultpage = $this->getNumPages();
				$this->setPageNum($resultpage);
			}
		
			
			function getNumPages() {
				
				if (!$this->results) return FALSE;
				return ceil(mysql_num_rows($this->results) /(float)$this->pageSize);
			}
			
			function getTotalNum() {
			
				$this->anz = mysql_num_rows($this->results);
				return $this->anz;
			}
			
			function setPageNum($pageNum) {
			
				if ($pageNum > $this->getNumPages() or
					$pageNum <= 0) return FALSE;
				$this->page = $pageNum;
				$this->row = 0;
				mysql_data_seek($this->results,($pageNum-1) * $this->pageSize);
			}
			
			function getPageNum() {
			
				return $this->page;
			}
			
			function isLastPage() {
			
				return ($this->page >= $this->getNumPages());
			}
			
			function isFirstPage() {
			
				return ($this->page <= 1);
			}
			
			function fetchArray() {
			
				if(!$this->results) return FALSE;
				if($this->row >= $this->pageSize) return FALSE;
				$this->row++;
				return mysql_fetch_array($this->results);
			}
			
			function getPageNav($queryvars = '') {
			
				if($this->getNumPages() > 1) {
				}
			
				if(!$this->isFirstPage()){
						$pages .= "<a href=$this->pathto?resultpage=".
								($this->getPageNum()-1).'&'.$queryvars.'><img src=\'http://www.smartshanghai.com/newimg/prevpagetxt.gif\' border=\'0\'></a> ';
				}
				
		
				if (!$this->isLastPage()){
					$pages .= " <a href=$this->pathto?resultpage=".
					($this->getPageNum()+1).'&'.$queryvars.'><img src=\'http://www.smartshanghai.com/newimg/nextpagetxt.gif\' border=\'0\'></a>';
				}
		
				return $pages;
			}
			
		function getPageNb($queryvars = '')
		   {
			$nav = "Pages ";
			
			if ($this->getNumPages() > 1)
			  $start = max($this->getPageNum() - 4, 1);
			  $stop = min($this->getPageNum() + 4, $this->getNumPages());
			  if ($start > 1)
			  {
				 $nav .= "<a href=\"$this->pathto?resultpage=1&amp;"
						 .$queryvars.'">First</a> ';
				 $nav .= '... ';
			  }
			  
			  for ($i=$start; $i<=$stop; $i++)
			  {
				if ($i==$this->getPageNum())
				  $nav .= "[$i] ";
				else
				  $nav .= "<a href=\"$this->pathto?resultpage={$i}&amp;".
						  $queryvars."\">$i</a> ";
			  }
		
			  if ($stop < $this->getNumPages())
			  {
				$nav .= '... ';
				$nav .= "<a href=\"$this->pathto?resultpage=".
						 ($this->getNumPages()).'&amp;'.$queryvars.'">Last </a>';
			  }
		  
		
			
			return $nav;
		}   
			
		}

/*--------------- Display a message -------------------------------*/


function message($msg,$zu)  {
  ?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=gb2312">
  <title>: : Shanghai United International School : :</title>
  <meta http-equiv ="Refresh" content = "3 ; url=<?PHP echo("$zu"); ?>">
   <style>
 
	 body {
		margin: 0 auto;
		padding: 0;
		font-family: "Lucida Grande", verdana, arial, helvetica, sans-serif;
		font-size: 12px;
		color: #333;
		background-color: #e7e7e7;
		text-align: center;
	}
	
  	#Header {
		margin-top: 15%;
		height: 200px;
    	background-color: #ffffff;
		border-top: 1px solid #999999;
		border-bottom: 1px solid #999999;
  	}

  	#Header h1 {
		font-size: 11px;
		font-weight:normal;
		padding-top: 20px;
    	color: #b8b8b8;
  	}


 	 #Header h2 {
	 	padding-top: 10px;
		font-size: 17px;
    	color: #444444;
  	}

  	#Header h2 a:link, #Header h2 a:visited {
    	color: #FFFFFF;
    	text-decoration: none;
  	}
	
 	 #Header h3 {
	 	padding-top: 20px;
		font-size: 10px;
    	color: #b8b8b8;
		font-weight:normal;
  	}

  	#Header h3 a:link, #Header h2 a:visited {
    	color: #747285;
    	text-decoration: none;
  	}

 
</style>
</head>
<body>
<div id="Statusbar">
 <div id="ContentFrame">
	<div id="Header">	 
      <h1>: : SUIS Student administration desk : :</h1>
	   <h2><?php echo("$msg"); ?></h2>
	   <h3>If your browser doesn't redirect you, or if you don't want to wait any longer, please click <a href="<?PHP echo("$zu"); ?>">here</a></h3>	 
  </div>
</div>
</body></html>

<?PHP
}

		
/*--------------- Convert a Unix Timestamp to Mysql  -------------------------------*/

	
		function UnixToMysql($timestamp)
		{
			// Accepts a unix timestamp in seconds since 1970
			// and returns the mySQL timestamp - format YYYYMMDDHHMMSS
			$time = date('YmdHis', $timestamp);
			return $time;
			}
			
		function MysqlToUnix($timestamp,$style) {
		
			$timestamp = (string)$timestamp;
			$yyyy = substr($timestamp, 0, 4);
			$month = substr($timestamp, 4, 2);
			$dd = substr($timestamp, 6, 2);
			$hh = substr($timestamp, 8, 2);
			$mm = substr($timestamp, 10, 2);
			$ss = substr($timestamp, 12, 2);
			
			if($style == "dateonly") {
				$human_date = "$dd.$month.$yyyy";
			} elseif ($style == "short") {
				$human_date = "$dd.$month.$yyyy / $hh.$mm";
			} elseif ($style == "timeonly") {
				$human_date = "$hh.$mm";
			} elseif ($style == "unix") {
				$human_date = "$hh$mm";	
			} else {
				$human_date = "am $dd.$month.$yyyy um $hh.$mm Uhr";
			}
			
			return $human_date;
		
		}


/*----------------------- generate a dropdown menue ------------------------------------
*
* this function takes an array and generates a drop-down-menue. The parameters are
* 1. The array with the values for the drop-down
* 2. The name of the drop down menue
* 3. The selected value. Leave blank if non should be selected
* 4. Blank value or nor
*/

		function dropdown($drop_array,$drop_name,$selected,$blank) {
			
			$drop  = "<select name='$drop_name' style='width:200px; margin-right: 5px;'>";
			if($blank == "yes") {
				$drop .= "<option value=''></option>";
			}
		
			
			foreach($drop_array as $key=>$element) {
				if($key == $selected) {
						$drop .= "<option value='$key' selected>$element</option>";
				} else {
						$drop .= "<option value='$key'>$element</option>";
				}
			}
				
			$drop .= "</select>";
			
			RETURN $drop;
		}
		
		function cut_string($string,$length){
			$string = ( strlen( $string) > $length ) ? substr( $string, 0,($length)  ) . '..' : $string ;
			RETURN $string;
		}
		
		
		function date_for_drop($day,$month,$year){
				if(($month != "") AND ($day != "") AND ($year != "")){
					$start = mktime(0,0,0,$month,$day,$year);
					$date = date("Y-m-d",$start);
				} else {
					$date = date("Y-m-d");
				}
			return $date;
		}
		
		
	
/*----------------------- generate a dropdown menue ------------------------------------*/
	
		
		class date_to_dropdown {
			
			var $day;
			var $month;
			var $year;
			var $null;
			var $drop_name;
			
				
				function datedropdown($date, $null, $year, $showday, $drop_name){
							
					$this->explode($date);
					$this->null = $null;
					
					$showday == "yes" ? $datedrop .= $this->output_days($drop_name) : $datedrop .= "";
					$datedrop .= $this->output_month($months, $drop_name);
					$year == "yes" ? $datedrop .= $this->output_year($future_only, $drop_name) : $datedrop .= "";
					
					return $datedrop;		
				}
				
				function explode($date){
					if($date != "") {
						$datarr = explode("-",$date);
						$this->day = $datarr[2];
						$this->month = $datarr[1];
						$this->year = $datarr[0];
					}
				}
				
				function open_drop($name, $drop_name){
					$listvalue = "<select name='" . $name . "_" . $drop_name . "' style='margin-right: 5px'>";
					
					$listvalue .= "<option value=''></option>";

						
					return $listvalue;
				}
				
				function list_value($id,$name,$sel){
					if ($id==$sel) {
						$listvalue = "<option value='$id' selected>$name</option>";     
					} else {
						$listvalue = "<option value='$id'>$name</option>";
					}
					return $listvalue;
				}
				
				function close_drop(){
					$listvalue = "</select>";
					return $listvalue;
				}
				
				function output_days($drop_name){
				
					//aufmachen
						$days .= $this->open_drop("day", $drop_name);
					//durchzaehlen
						for($i=1; $i<32; $i++) {
							$days .= $this->list_value($i,$i,$this->day);
						}	
					//zumachen
						$days .= $this->close_drop();
					
					return $days;
				}
				
				function output_month($months, $drop_name){
		
					//aufmachen
						$month .= $this->open_drop(month, $drop_name);	
					//durchzaehlen
						for($i=1; $i<13; $i++) {
							$month .= $this->list_value($i,$i,$this->month);
						}	
					//zumachen
						$month .= $this->close_drop();
					
					return $month;
				}
				
				function output_year($future_only, $drop_name){
				
					//erstmal das array schreiben mit den Jahren
						$this_year = date(Y);
					
					//aufmachen
						$year .= $this->open_drop(year, $drop_name);			
					//durchzaehlen
						for($i=1950; $i<2040; $i++) {
							$year .= $this->list_value($i,$i,$this->year);
						}			
					//zumachen
						$year .= $this->close_drop();
					
					return $year;
				}
					
		}


/*--------------- Display a checkbox with given values  -------------------------------*/


		function checkbox($isselected, $name){
			if($isselected == "1"){
				$cbox = "<input type='checkbox' name='$name' value='1' checked>";
			} else {
				$cbox = "<input type='checkbox' name='$name' value='1'>";
			}
			return $cbox;
		}



/*------------------------- Sends an email  --------------------------------------------*/



		function mailme($recipient, $recipientemail, $subject, $message, $fromname, $fromemail) {
		
			// recipients 
				$recipient .= "<$recipientemail>";
		
			// subject 
				$subject = "$subject";
		
			// additional header pieces for errors, From cc's, bcc's, etc 
				$headers .= "From: $fromname <$fromemail>\n";
				$headers .= "X-Sender: <$fromemail>\n"; 
				//$headers .= "X-Priority: 1\n"; // Urgent message!
				$headers .= "Return-Path: <$fromemail>\n";  // Return path for errors
		
			// If you want to send html mail, uncomment the following line 
				$headers .= "Content-Type: text/html; charset=iso-8859-1\n"; // Mime type
		
			// and now mail it! 
				mail($recipient, $subject, $message, $headers);
		}


/*------------------------- Generate a password  --------------------------------------------*/

	function generatePassword ($length = 8) {

		  // start with a blank password
		  $password = "";
		
		  // define possible characters
		  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; 
			
		  // set up a counter
		  $i = 0; 
			
		  // add random characters to $password until $length is reached
		  while ($i < $length) { 
		
			// pick a random character from the possible ones
			$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
				
			// we don't want this character if it's already in the password
			if (!strstr($password, $char)) { 
			  $password .= $char;
			  $i++;
			}
		
		  }
		
		  // done!
		  return $password;

}


/*------------------------- Generate a Username for parents  ----------------------------*/

	function generateParentsUID($firstname,$lastname) {
		
		//first try, just the name put together
			$firsttry = "$firstname$lastname";
		
			
				$quickcheck = mysql_query("SELECT COUNT(*) AS nbrows FROM parents_account WHERE acc_uid='$firsttry'");
				$getarray = mysql_fetch_array($quickcheck);
							
					if($getarray[nbrows] > "0") {
					
					//second try
					
						//ok, then we have to add a number
							$possible = "0123456789"; 
					
				 			// add random characters to $password until $length is reached
						  	while ($i < "3") { 
						
							// pick a random character from the possible ones
								$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
							 	$randnb .= $char;
							 	$i++;
						
						  	}
					
							$nexttry = "$firstname$lastname$randnb";
							
							$quickcheck = mysql_query("SELECT COUNT(*) AS nbrows FROM parents_account WHERE acc_uid='$nexttry'");
							$getarray = mysql_fetch_array($quickcheck);
							
							if($getarray[nbrows] > "0") {
							
								
								// add random characters to $password until $length is reached
						  		while ($i < "4") { 
						
								// pick a random character from the possible ones
									$char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
							 		$randnbnew .= $char;
							 		$i++;
						
						  		}
								
								$thirdtry = "$firstname$lastname$randnbnew";
								return $thirdtry;
							
							} else {
							
								return $nexttry;
							
							}
							
							
					
					} else {
						return $firsttry;
					}
	
	}

/*------------------------- Check the level  --------------------------------------------*/

	function checklevel($section, $mylevel) {
		$check = mysql_query("SELECT $section AS thissection FROM user_level WHERE level_id=$mylevel");
		$getarray = mysql_fetch_array($check);
		$thissection = $getarray[thissection];
		
		return $thissection;
	
	}

?>
