<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"searchform" => "searchform.htm",
		"main" => "parentsaccounts.htm"));

	
	$t->set_var(LOGINNAME, $_SESSION[uid]);

		
		//--------------------------- Search query ----------------------------------//
		
		$where = "account_id > '0'";
		
		if($_GET[acc_uid] != "") {
			$where .= " AND acc_uid LIKE '%$_GET[acc_uid]%'";
		}
		
		if($_GET[acc_pwd] != "") {
			$where .= " AND acc_pwd LIKE '%$_GET[acc_pwd]%'";
		}
		
		if($_GET[acc_email] != "") {
			$where .= " AND acc_email LIKE '%$_GET[acc_email]%'";
		}

		
		//----------------------------- The Output ----------------------------------//
		
		$rs = new MysqlPagedResultSet("SELECT account_id, acc_uid, acc_pwd, acc_email 
										FROM parents_account WHERE $where","20","parentsaccounts.php");
		if($rs->getTotalNum() > "0") {
		
		
			//Output a top headline with number of results and stuff
			//let's just use a table here for the 2 column thing, css tai mafan
			$topnavipages = "<div class=\"SectionHeader\"><br><img src=\"img/txt_parentsaccounts.gif\"/></div><br>
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
							
				$studs .= "<div class='stud_rows'><h1>$acc_uid</h1>
							Password: $acc_pwd  | Email: $acc_email | 
							<a href='editparentsaccount.php?account_id=$account_id'>Edit</a> | 
							<a href='editparentsaccount.php?deleteaccount=$account_id'>Delete</a></div>";
			
			
			}
			
		
			$t->set_var(MAINSTAGE, "$topnavipages $studs");
		
		} else {

			$t->set_var(MAINSTAGE, "No Accounts yet. <a href=\"http://suis.xieheedu.com/testing/editparentsaccount.php\">Add a new Account here</a>");		
		
		} 
			
		
	
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>