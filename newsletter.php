<?php
include ("login.php");
include ("template.inc");
require("class.phpmailer.php");


dbConnect ('');
	
$t = new Template("templates");
$t->set_file(array(
		"body" => "admin_nav.htm",
		"main" => "newsletter.htm",
		"form" => "newsletter_create.htm",
		"confirm" => "newsletter_confirm.htm"));

				
		$t->set_var(LOGINNAME, $_SESSION[uid]);


	/* -------------------------------- Show the preview ------------------------------ */	

	if(isset($_POST[createpreview])) {
	
			$newsletter_txt = $_POST[newsletter_txt];
			$newsletter_subject = $_POST[newsletter_subject];
			$newsletter_fromemail = $_POST[newsletter_fromemail];
			$newsletter_list = $_POST[newsletter_list];

			$newsletter_txt = str_replace("\n", "<BR>", $newsletter_txt);
			$newsletter_txt = str_replace("\n", "<br>", $newsletter_txt);
			
			//if it's new, add it to the db
			
			$set = "newsletter_txt='$newsletter_txt', newsletter_list='$newsletter_list', 
			newsletter_fromemail='$newsletter_fromemail', newsletter_subject='$newsletter_subject'";
			
			$newsletter_id = $_POST[newsletter_id];
			
			if($newsletter_id == "") {
				$insert = mysql_query("INSERT INTO newsletter SET $set");
				$newsletter_id = mysql_insert_id();
			} else {
				$update = mysql_query("UPDATE newsletter SET $set WHERE newsletter_id='$newsletter_id'");			
			}
					
			//calculate the number of recipients
				if($newsletter_list == "0") {
					$countit = mysql_query("SELECT COUNT(*) AS nbrecipients FROM parents_account");
				} elseif($newsletter_list == "1") {
					$countit = mysql_query("SELECT COUNT(*) AS nbrecipients FROM parents_account WHERE newsletter_status='2'");
				} else {
					$countit = mysql_query("SELECT COUNT(*) AS nbrecipients FROM user"); 
				}
				$countarray = mysql_fetch_array($countit);
				extract($countarray);
			
			$t->set_var(NEWSLETTERID, $newsletter_id);
			$t->set_var(NEWSLETTERLIST, $newsletterlists_array[$newsletter_list]);
			$t->set_var(NBRECIPIENT, $nbrecipients);
			$t->set_var(SENDERADDRESS, "$newsletter_fromemail");
			$t->set_var(SUBJECT, "$newsletter_subject");	
			$t->set_var(PREVIEW, "$newsletter_txt");			
			$t->parse(MAINSTAGE,"confirm");
	
	
	/* -------------------------------- Edit the newsletter ------------------------------ */
						
	} elseif(isset($_POST[editnewsletter])) {
				
			$get = mysql_query("SELECT * FROM newsletter WHERE newsletter_id='$_POST[newsletter_id]'");
			if(mysql_num_rows($get) > "0") {
			
				$getarray = mysql_fetch_array($get);
				extract($getarray);
	
				$newsletter_txt = str_replace("<BR>", "\n", $newsletter_txt);
				$newsletter_txt = str_replace("<br>", "\n", $newsletter_txt);
			
				$t->set_var(SENDERADDRESS, "$newsletter_fromemail");
				$t->set_var(SUBJECT, "$newsletter_subject");	
				$t->set_var(TXT, "$newsletter_txt");			
		
				$t->set_var(LISTS, dropdown($newsletterlists_array,"newsletter_list","$newsletter_list","no"));
				$t->set_var(NEWSLETTERID, "$_POST[newsletter_id]");
									
				$t->parse(MAINSTAGE,"form");
			
			} 
			
	/* -------------------------------- Send the newsletter ------------------------------ */
						
	} elseif(isset($_POST[sendnewsletter])) {
							
			$get = mysql_query("SELECT * FROM newsletter WHERE newsletter_id='$_POST[newsletter_id]'");
			if(mysql_num_rows($get) > "0") {
			
				$getarray = mysql_fetch_array($get);
				extract($getarray);
				
				$newsletter_txt = str_replace("\n", "<BR>", $newsletter_txt);
				$newsletter_txt = str_replace("\n", "<br>", $newsletter_txt);
	
			} 
			
				//get the recipients
				if($newsletter_list == "0") {
					$get = mysql_query("SELECT acc_email AS sendto FROM parents_account");
				} elseif($newsletter_list == "1") {
					$get = mysql_query("SELECT acc_email AS sendto FROM parents_account WHERE newsletter_status='2'");
				} else {
					$get = mysql_query("SELECT user_email AS sendto FROM user"); 
				}
				if(mysql_num_rows($get) > "0"){  
					while ($getarray = mysql_fetch_array($get)){
					extract($getarray);
					
					//put the send part here
						$mail = new PHPMailer();
						$mail->From = "$newsletter_fromemail";
						$mail->FromName = "Shanghai United International School";
						$mail->Body = $newsletter_txt;
						$mail->isHTML(true);

						$mail->ClearAddresses();
					
						$mail->AddAddress("$sendto");
						$mail->Subject = "$newsletter_subject";
					
						$mail->Send();
					
					
					}
				}
				
				//update the newsletter archives
				$update = mysql_query("UPDATE newsletter SET newsletter_sent = '1' WHERE newsletter_id='$_POST[newsletter_id]'");
				
				message("Newsletter sent", "newsletter.php");
				exit();
				
				

	/* -------------------------------- Show the empty form ------------------------------ */		
	
	} else {

			$t->set_var(SENDERADDRESS, "");
			$t->set_var(SUBJECT, "");	
			$t->set_var(TXT, "");	
				
			$t->set_var(LISTS, dropdown($newsletterlists_array,"newsletter_list","$newsletter_list","no"));
			$t->set_var(NEWSLETTERID, "$_POST[newsletter_id]");
								
			$t->parse(MAINSTAGE,"form");
	
	
	
	}
	
	
	/* -------------------------------- Archives on the righ ------------------------------ */	
		
	
		$get = mysql_query("SELECT newsletter_id AS archivesid, newsletter_txt AS archivestxt, 
							DATE_FORMAT(newsletter_date, '%a, %b %D - %r') AS archivessenttime, 
							newsletter_subject AS archivessubject 
							FROM newsletter 
							WHERE newsletter_sent='1'
							ORDER BY archivessenttime DESC
							LIMIT 10");
		if(mysql_num_rows($get) > "0") {
			
			while($getarray = mysql_fetch_array($get)) {
			
				$arch_txt = cut_string($getarray[archivestxt], "300");
				$arch_txt = str_replace("<BR>", "", $arch_txt);
				$arch_txt = str_replace("<br>", "", $arch_txt);
				$arch_txt = wordwrap($arch_txt, 40, "\n", 1);
				
				$archivesrows .= "<div class='newsletter_archives_rows'>$getarray[archivessenttime] <br>
								$getarray[archivessubject] 
								<br><br>$arch_txt <a href='shownewsletter.php?e=$getarray[archivesid]'>show</a><br><br></div>";
				
			}

			$t->set_var(ARCHIVES, "<br>$archivesrows");
					
		} else {
		
			$t->set_var(ARCHIVES, "<br>no data yet");
		
		}
		
		
			
	
$t->parse(CONTENT, "main");		
$t->pparse(MAIN, "body");
?>