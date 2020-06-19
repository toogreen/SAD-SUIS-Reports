<?php
include ("login.php");
include ("template.inc");
include ("upload_class.php");
//include ("reports_variables.php");

dbConnect ('');

/* ---------------- IF PRINT MANY PAGES VERSION, DO BELOW ----------------- */

//Where condition.. Either show all, or for one class, or for one student
			
			$where = "WHERE reports.rid > '0'";

			
			// IF CLASS_ID GOES HERE 
			if($_GET[class_id] != "") {
				
				$where .= " AND student.class_id='$_GET[class_id]'";	
			}
		
			
			// IF STUDENT_ID GOES HERE 
			if($_GET[stud_id] != "") {
			
				$where .= " AND rsid='$_GET[stud_id]'";
			
			}
	
	
			// IF INTERIM IS SPECIFIED 
			if($_GET[interim] != "") {
			
				$where .= " AND interim='$_GET[interim]'";
	
			
			}

			// IF SCHOOL YEAR IS SPECIFIED 
			if($_GET[syear] != "") {
			
				$where .= " AND syear='$_GET[syear]'";
			
			}


				
			$rs = new MysqlPagedResultSet("SELECT * FROM reports 
									LEFT JOIN student ON student.stud_id = reports.rsid
								$where", "100","student-report.php");			
			
						if($rs->getTotalNum() > "0") {
									
					
							while ($getarray = $rs->fetchArray()) {
							$stud_id = $getarray[rsid]; 



$t = new Template("templates");


	

							// SET TEXT VARIABLES FOR YEAR	S 			
								$thisyear = 2000 + $getarray[syear]; 							   
							   $nextyear = $thisyear + 1; 				
								 $t->set_var(SYEAR,"$thisyear-$nextyear");

								// SET VARIABLES FOR EMPTY FORM 
								$t->set_var("FORM_INPUT_STARTS","&nbsp;");
								$t->set_var("FORM_INPUT_ENDS","&nbsp;");
								
								// INTERIM REPORT FIXED 
								$interim = $getarray[interim];
								
								$t->set_var("INTERIM","$interim");
								$t->set_var("INTERIM_EDIT","$interim");
								
								// CHINESE 
								$t->set_var("CT","$getarray[ct]"); $t->set_var("C1","$getarray[c1]"); $t->set_var("C2","$getarray[c2]"); 
								
										// if empty field, display N/A or nothing 
										if ($getarray[c3] == 0) { $t->set_var("C3","N/A"); } else { $t->set_var("C3","$getarray[c3]"); }
								
										// if empty field, display N/A or nothing 
										if ($getarray[c4] == 0) { $t->set_var("C4","N/A"); } else { $t->set_var("C4","$getarray[c4]"); }
									
								// ENGLISH							
								$t->set_var("ET","$getarray[et]"); $t->set_var("E1","$getarray[e1]"); $t->set_var("E2","$getarray[e2]");							

										// if empty field, display N/A or nothing 
										if ($getarray[e3] == 0) { $t->set_var("E3","N/A"); } else { $t->set_var("E3","$getarray[e3]"); }
								
										// if empty field, display N/A or nothing 
										if ($getarray[e4] == 0) { $t->set_var("E4","N/A"); } else { $t->set_var("E4","$getarray[e4]"); }
				
								
											
								// MATHS							
								$t->set_var("MT","$getarray[mt]"); $t->set_var("M1","$getarray[m1]"); $t->set_var("M2","$getarray[m2]"); $t->set_var("M3","$getarray[m3]");
								
								// UOI 							
								$t->set_var("UT","$getarray[ut]"); $t->set_var("U1","$getarray[u1]"); $t->set_var("U2","$getarray[u2]");	$t->set_var("U3","$getarray[u3]");
								
								// SCIENCE						
								$t->set_var("ST","$getarray[st]"); $t->set_var("S1","$getarray[s1]"); $t->set_var("S2","$getarray[s2]");	$t->set_var("S3","$getarray[s3]");
								
								// HISTORY / GEOGRAPHY						
								$t->set_var("HGT","$getarray[hgt]"); $t->set_var("HG1","$getarray[hg1]"); $t->set_var("HG2","$getarray[hg2]");	$t->set_var("HG3","$getarray[hg3]");
								
								// DESIGN AND TECHNOLOGY / ART					
								$t->set_var("DT","$getarray[dt]"); $t->set_var("D1","$getarray[d1]"); $t->set_var("D2","$getarray[d2]");	$t->set_var("D3","$getarray[d3]");
								
								// CHINESE CULTURE					
								$t->set_var("CCT","$getarray[cct]"); $t->set_var("CC1","$getarray[cc1]"); $t->set_var("CC2","$getarray[cc2]");	$t->set_var("CC3","$getarray[cc3]");
								
								// ICT 					
								//->set_var("ICT","$getarray[ict]"); $t->set_var("IC1","$getarray[ic1]"); $t->set_var("IC2","$getarray[ic2]");	$t->set_var("IC3","$getarray[ic3]");
								
								// MANUALLY SET VARIABLES FOR ICT
								$ICT = $getarray[ict];  // Title - Name of teacher
								$IC1 = $getarray[ic1]; 	// Effort
								$IC2 = $getarray[ic2];	// Progress
								$IC3 = $getarray[ic3];	// Attainment
								
														
								// MUSIC					
								$t->set_var("MUT","$getarray[mut]"); $t->set_var("MU1","$getarray[mu1]"); $t->set_var("MU2","$getarray[mu2]");	$t->set_var("MU3","$getarray[mu3]");
								// PE					
								$t->set_var("PET","$getarray[pet]"); $t->set_var("PE1","$getarray[pe1]"); $t->set_var("PE2","$getarray[pe2]");	$t->set_var("PE3","$getarray[pe3]");
								// ART 美术				
								$t->set_var("ARTT","$getarray[artt]"); $t->set_var("ART1","$getarray[art1]"); $t->set_var("ART2","$getarray[art2]");	$t->set_var("ART3","$getarray[art3]");
							
								// PERFORMANCE SCORES							
								$t->set_var("B1","$getarray[b1]");
								$t->set_var("B2","$getarray[b2]");
								$t->set_var("B3","$getarray[b3]");
								$t->set_var("B4","$getarray[b4]");
								$t->set_var("B5","$getarray[b5]");
								$t->set_var("B6","$getarray[b6]");
								$t->set_var("B7","$getarray[b7]");
								$t->set_var("ABS","$getarray[abs]");
								$t->set_var("COMMENT1","$getarray[comment1]");
								$t->set_var("COMMENT2","$getarray[comment2]");	
								$t->set_var("COMMENT3","$getarray[comment3]");	
								$t->set_var("COMMENT4","$getarray[comment4]");	
								$t->set_var("COMMENT5","$getarray[comment5]");
								$t->set_var("COMMENT6","$getarray[comment6]");		
								
								

								
	/*------------------------------------ CHECK Attendance for ABSENT  ----------------------------*/
												
								$getatt = mysql_query("SELECT att_												date, attend_id, attend.att_stud_id, att_status 
																FROM attend 
																WHERE attend.att_stud_id='$stud_id'
																AND att_status > '1'
																AND att_date > '$thisyear-09-1'
																ORDER BY att_date");
															
										if(mysql_num_rows($getatt) > "0"){
											
											$numdaysmissed = mysql_num_rows($getatt);
														
											$t->set_var("ATTENDENCE","$numdaysmissed");
																			
										} else {
										
											$t->set_var("ATTENDENCE","0");
											
										}
					
										
		 /*------------------------------------ CHECK Attendance for LATE  ----------------------------*/
												
								$getatt = mysql_query("SELECT att_date, attend_id, attend.att_stud_id, att_status 
																FROM attend 
																WHERE attend.att_stud_id='$stud_id'
																AND att_status = '1' 
																AND att_date > '$thisyear-09-1'
																ORDER BY att_date");
															
										if(mysql_num_rows($getatt) > "0"){
											
											$numdayslate = mysql_num_rows($getatt);
														
											$t->set_var("LATE","$numdayslate");
																			
										} else {
										
											$t->set_var("LATE","0");
											
										}


	$t->set_file(array(
			"body" => "admin_nav_report.htm",
			"report_header" => "student_report_header.htm",
			"main1" => "report_layout.htm",
			"main2" => "report_layout.htm",
			"main3" => "report_layout.htm",
			"main4" => "report_layout4.htm",
			//"form" => "student_report_form.htm",
			"table_general" => "student_report_table_general.htm",
			"table_subjects_base" => "student_report_table_subjects_base.htm",
			// SUBJECTS ROWS FOR UOI			
			"table_subjects_stream_0_1" => "student_report_table_subjects_uoi_1.htm",
			"table_subjects_stream_0_2" => "student_report_table_subjects_uoi_1.htm",
			"table_subjects_stream_0_3" => "student_report_table_subjects_uoi_1.htm",
			"table_subjects_stream_0_4" => "student_report_table_subjects_uoi_4.htm",
			// SUBJECTS ROWS FOR ICE  
			"table_subjects_stream_1_1" => "student_report_table_subjects_ice_1.htm",
			"table_subjects_stream_1_2" => "student_report_table_subjects_ice_1.htm",
			"table_subjects_stream_1_3" => "student_report_table_subjects_ice_1.htm",
			"table_subjects_stream_1_4" => "student_report_table_subjects_ice_4.htm",
			// TABLES FOR PERFORMANCE 
			"table_performance1" => "student_report_table_performance1.htm",
			"table_performance2" => "student_report_table_performance2.htm",
			"table_performance3" => "student_report_table_performance3.htm",
			"table_performance4" => "student_report_table_performance4.htm",
			// TABLES FOR COMMENTS, SIGNATURES, ETC. 
			"table_comment1" => "student_report_table_comment.htm",
			"table_comment2" => "student_report_table_comment.htm",
			"table_comment3" => "student_report_table_comment.htm",
			"table_comment4" => "student_report_table_comment4.htm",
			"table_signatures" => "student_report_table_signatures.htm",
			"table_performance_criteria" => "student_report_table_performance_criteria.htm",
			"table_grade_criteria" => "student_report_table_grade_criteria.htm",
			"nodata" => "nodata.htm"));

	// HEADER FOR admin_nav_a4.htm 
	$t->set_var(REPORTHEADER,"Interim Report");
	
	$t->set_var(LOGINNAME, $_SESSION[uid]);
	$t->set_var(LASTLOGIN, $_SESSION[lastlogin]);

	/*------------------------------------ Set main redundant variables ----------------------------*/
	$t->set_var(FONTFACE,"VERDANA");
	$t->set_var(FONTSIZE,"-2");	
	$t->set_var(NUMBERSIZE,"-2");
	$t->set_var(NUMCOLSIZE,"5%"); 
	$t->set_var(TEXT_INTERIM,"Interim Report Number");
	$t->set_var(TEXT_GC1,"<b>Subject Grades<br>学科</b>");
	$t->set_var(TEXT_GC2,"<b>Teacher<br><nobr>任课教师</nobr></b>");
	$t->set_var(TEXT_GC3,"<b>Effort<br><nobr>努力程度 </nobr></b>");
	$t->set_var(TEXT_GC4,"<b>Progress<br><nobr>取得的进步</nobr> </b>");
	$t->set_var(TEXT_GC5,"<b>Attainment*<br><nobr>目标达到程度 </nobr></b>");
	$t->set_var(TEXT_GC6,"<b>CAL/EAL* </b> ");
	$t->set_var(TEXT_SC,"Chinese 中文");
	$t->set_var(TEXT_SE,"English 英语");
	$t->set_var(TEXT_SM,"Mathematics 数学");	
	$t->set_var(TEXT_SU,"Units of Inquiry 探究");
	$t->set_var(TEXT_SS,"Science 探究");
	$t->set_var(TEXT_SH,"History/Geography 历史/地理");
	$t->set_var(TEXT_SD,"<nobr>Design & Technology/Art</nobr><br> 设计工艺学/美术");
	$t->set_var(TEXT_SCC,"Chinese Culture 中国文化");
	$t->set_var(TEXT_SIC,"ICT 信息技术");
	$t->set_var(TEXT_SMU,"Music 音乐");
	$t->set_var(TEXT_SPE,"PE 体育");
	$t->set_var(TEXT_ART,"Art 美术");
	$t->set_var(TEXT_B1,"<b>Participates in class</b> <br>课堂参与度");
	$t->set_var(TEXT_B2,"<b>Co-operates well with others</b>	<br>与他人友好合作");
	$t->set_var(TEXT_B3,"<b>Communicates confidently</b> <br>能自信地与人沟通");
	$t->set_var(TEXT_B4,"<b>Submits a good quality of work and homework</b><br><i>Relates to the quality achievable by the individual student.</i><br>作业质量（与学生个人完成的作业质量直接相关）");
	$t->set_var(TEXT_B5,"<b>Independence</b><br><i>Carries out tasks independently</i><br>独立自主 （独立完成学习任务）");
	$t->set_var(TEXT_B6,"<b>Personal organization</b><br><i>Arrives prepared for the lesson</i><br>自理能力（作好课前准备）");
	$t->set_var(TEXT_B7,"<b>Behaves appropriately</b><br>行为规范）");
	$t->set_var(TEXT_ABS,"<b>Number of days absent</b><br>缺勤天数");
	$t->set_var(TEXT_LATE,"<b>Number of days late </b><br>迟到天数");	
	$t->set_var(TEXT_DATE,"June 2010");	
	
		


	/*------------------------------------ Show student profile ----------------------------*/


$get = mysql_query("SELECT * FROM student WHERE stud_id='$stud_id'");
				if(mysql_num_rows($get) > "0"){
					$getarray = mysql_fetch_array($get);
					extract($getarray);			
						
						$firstname = $firstname;
						
						//Main Name
						if($preferedname == "0") {
							$t->set_var("MAINNAME","$firstname $middlename $lastname");
						} else {
							$t->set_var("MAINNAME","$chinesename");
						}
	
	
						//Student Number
						if($status == "0") {
							$t->set_var("STUDNB","$temp_stud_nb");
						} else {
							$t->set_var("STUDNB","$stud_nb");						
						}
						
										
						$t->set_var("PREINTRES","$intpre");		
						
						//Make last name capitals	
						$lastname_cap = $lastname;
						$lastname_cap = strtoupper($lastname_cap);						
						
						//General
						$t->set_var("RID","$rid");	
						$t->set_var("RSID","$rsid");
						$t->set_var("INTERIM","$interim");
						$t->set_var("STREAM","$stream");			
						$t->set_var("STUDID","$stud_id");	
						$t->set_var("STATUS","$status_array[$status]");	
						$t->set_var("PROFILECREATED","$createdate");			
						$t->set_var("LASTNAME","$lastname_cap");
						$t->set_var("ENROLLED","$enrolled");
						$t->set_var("FIRSTNAME","$firstname");
						$t->set_var("MIDDLENAME","$middlename");
						$t->set_var("CHINESENAME","$chinesename");
						$t->set_var("SEX","$sex_array[$sex]");
						$t->set_var("PREFNAMEDROP", $preferedname_array[$preferedname]);
						$t->set_var("DOBDROP", $dob);
						$t->set_var("SEXDROP", $sex_array[$sex]);
						$t->set_var("DESCENTDROP", $descent_array[$descent]);
						$t->set_var("PLACEOFBIRTH","$pob");
						$t->set_var("PASSPORTNB","$passport_nb");
						$t->set_var("PASSPORTEXP","$passport_exp");
						$t->set_var("CURRENTGRADE","$currentgrade");
						$t->set_var("EXPLENGTHSTAY","$exp_length_stay");
												


						/*----------------------------------- Classroom ------------------------------------*/
						
						
							
							if($_GET[editclassroom] != "true") {
							
								if($class_id == "0") {
								
									$t->set_var("CLASSNAME", "No Classroom yet");
									
								} else {
								
									//get the classroom name and stuff
									$select = mysql_query("SELECT class_name, class_ht, class_stream FROM classes WHERE class_id='$class_id'");
									$getarray0 = mysql_fetch_array($select);
									
									$t->set_var("CLASSNAME", $getarray0[class_name]);
									$t->set_var("CLASSHT",$getarray0[class_ht]);	
									$t->set_var("CLASSSTREAM",$getarray0[class_stream]);				

								}

							}
							
	// ADDED THE FOLLOWING IN JUNE 2010 TO CATER FOR BOTH PYP AND ICE IN FINAL REPORTS COMMENTS AND MAKE FINAL COMMENT BOX VARIABLE
	if ($getarray0[class_stream] != 1) {
		
		$t->set_var(TEXT_COMMENT_VARIABLE,"Home Group and Units of Inquiry 班 活 及探究");
	
	} else {
		
		$t->set_var(TEXT_COMMENT_VARIABLE,"Home Group / Science and Projects 班 活 科学与工程");
	}


	// ADDED THE FOLLOWING IN JUNE 2010 to NOT show ICT if its a grade 1 or 2 class.
	if (
		$getarray0[class_name] != '1A' && $getarray0[class_name] != '1B' && $getarray0[class_name] != '1C'  && $getarray0[class_name] != '1D' &&
		$getarray0[class_name] != '2A' && $getarray0[class_name] != '2B' && $getarray0[class_name] != '2C'  && $getarray0[class_name] != '2D'
		) {
	
		$t->set_var(ICT_CELL,"
		<tr><td height='15' align='left'><font size='-2'>ICT 信息技术</font></td>
		<td height='15' align='left'><font size='-2'>$ICT</font></td><td height='15' align='center'><font size='-2'>$IC1</font></td>
		<td height='15' align='center'><font size='-2'>$IC2</font>  </td><td height='15' align='center'><font size='-2'>$IC3</font></td></tr>
		");
		
	} else {
		
		$t->set_var(ICT_CELL,"");
	
	}	

						

						/*----------------------------------- Last update ------------------------------------*/
						
							//lets do another query for this, as SQL is much better to get a nice date output than PHP
							//just can't do it in the first query
							
									$get = mysql_query("SELECT lastupdate_user, DATE_FORMAT(lastupdate_general, '%b %D %y, %H:%i') AS lupdated 
													FROM student 
													WHERE stud_id='$stud_id'");
													
									if(mysql_num_rows($get) > "0"){
									$getarray = mysql_fetch_array($get);
								
									extract($getarray);	
									
									$t->set_var("LUPDATE","$lupdated");
								
								}
								
								
							//and who did it ... ?
							
								$get = mysql_query("SELECT uid AS lastupdateuser FROM user WHERE user_id='$lastupdate_user'");
								if(mysql_num_rows($get) > "0"){
									$getarray = mysql_fetch_array($get);
									extract($getarray);	
									
									
									$t->set_var("LUPDATEUSER","$lastupdateuser");
								
								}
								
							
								
									
		/*------------------------------------ Reports  ----------------------------*/
						
						//$interim_nb=$_GET[interim_nb];
						//$rid=$_GET[rid];
		
		
		//TO MAKE SURE EARLIER REPORTS ARE FROM THE SAME YEAR, FIND OUT WHICH YEAR IS THIS CURRENT REPORT FOR BY QUERYING ITS ID DATA
		$getreportyear = mysql_query("SELECT * FROM reports");
			if(mysql_num_rows($getreportyear) > "0"){
				$getarrayreportyear = mysql_fetch_array($getreportyear);
				$reportyear = $getarrayreportyear[syear];
			}
						
			// GET DATA FROM PREVIOUS INTERIM REPORT 1 AND SET VARIABLES FOR ITS COLUMN 											
						$getreport1 = mysql_query("SELECT * FROM reports WHERE rsid='$stud_id' AND interim='1' AND syear='$reportyear'");
						if(mysql_num_rows($getreport1) > "0"){						
							$getarray1 = mysql_fetch_array($getreport1); 
							
							// PERFORMANCE SCORES		
							$t->set_var("INTERIM_1","$getarray1[interim]");					
							$t->set_var("B1_1","$getarray1[b1]");
							$t->set_var("B2_1","$getarray1[b2]");
							$t->set_var("B3_1","$getarray1[b3]");
							$t->set_var("B4_1","$getarray1[b4]");
							$t->set_var("B5_1","$getarray1[b5]");
							$t->set_var("B6_1","$getarray1[b6]");
							$t->set_var("B7_1","$getarray1[b7]");
						} else {
							// PERFORMANCE SCORES NOT AVAILABLE		
							$t->set_var("INTERIM_1","N/A");
							$t->set_var("B1_1","N/A");
							$t->set_var("B2_1","N/A");
							$t->set_var("B3_1","N/A");
							$t->set_var("B4_1","N/A");
							$t->set_var("B5_1","N/A");
							$t->set_var("B6_1","N/A");
							$t->set_var("B7_1","N/A");
						}
						
			// GET DATA FROM PREVIOUS INTERIM REPORT 2 AND SET VARIABLES FOR ITS COLUMN 											
						$getreport2 = mysql_query("SELECT * FROM reports WHERE rsid='$stud_id' AND interim='2' AND syear='$reportyear'");
						if(mysql_num_rows($getreport2) > "0"){						
							$getarray2 = mysql_fetch_array($getreport2); 
							
							// PERFORMANCE SCORES		
							$t->set_var("INTERIM_2","$getarray2[interim]");					
							$t->set_var("B1_2","$getarray2[b1]");
							$t->set_var("B2_2","$getarray2[b2]");
							$t->set_var("B3_2","$getarray2[b3]");
							$t->set_var("B4_2","$getarray2[b4]");
							$t->set_var("B5_2","$getarray2[b5]");
							$t->set_var("B6_2","$getarray2[b6]");
							$t->set_var("B7_2","$getarray2[b7]");
						} else {
							// PERFORMANCE SCORES NOT AVAILABLE		
							$t->set_var("INTERIM_2","N/A");
							$t->set_var("B1_2","N/A");
							$t->set_var("B2_2","N/A");
							$t->set_var("B3_2","N/A");
							$t->set_var("B4_2","N/A");
							$t->set_var("B5_2","N/A");
							$t->set_var("B6_2","N/A");
							$t->set_var("B7_2","N/A");
						}
						
						// GET DATA FROM PREVIOUS INTERIM REPORT 3 AND SET VARIABLES FOR ITS COLUMN 											
						$getreport3 = mysql_query("SELECT * FROM reports WHERE rsid='$stud_id' AND interim='3' AND syear='$reportyear'");
						if(mysql_num_rows($getreport3) > "0"){						
							$getarray3 = mysql_fetch_array($getreport3); 

							// PERFORMANCE SCORES		
							$t->set_var("INTERIM_3","$getarray3[interim]");					
							$t->set_var("B1_3","$getarray3[b1]");
							$t->set_var("B2_3","$getarray3[b2]");
							$t->set_var("B3_3","$getarray3[b3]");
							$t->set_var("B4_3","$getarray3[b4]");
							$t->set_var("B5_3","$getarray3[b5]");
							$t->set_var("B6_3","$getarray3[b6]");
							$t->set_var("B7_3","$getarray3[b7]");
						} else {
							// PERFORMANCE SCORES NOT AVAILABLE		
							$t->set_var("INTERIM_3","N/A");
							$t->set_var("B1_3","N/A");
							$t->set_var("B2_3","N/A");
							$t->set_var("B3_3","N/A");
							$t->set_var("B4_3","N/A");
							$t->set_var("B5_3","N/A");
							$t->set_var("B6_3","N/A");
							$t->set_var("B7_3","N/A");
						}
						
						// GET DATA FROM CURRENTLY SELECTED REPORTS
						$getreport = mysql_query("SELECT * FROM reports WHERE rid='$rid'");
							
						// IF ITS NOT EMPTY, GET THESE VARIABLES AND DISPLAY THEM 
						if(mysql_num_rows($getreport) > "0"){						
						//$getarray = mysql_fetch_array($getreport);			
							
						$rsid=$getarray[rsid];	
						$interim=$getarray[interim];	
						$stream=$getarray[stream];						

							// HOMEROOM TEACHER AND CLASS						
							$t->set_var("HT","$getarray[ht]");
							$t->set_var("CLASS","$getarray[class]");		
							
							// SET TEXT VARIABLES FOR YEAR	S 			
								$thisyear = 2000 + $getarray[syear]; 							   
							   $nextyear = $thisyear + 1; 				
								 $t->set_var(SYEAR,"$thisyear-$nextyear");
								 


							
							// IF EDITING IS NOT ON, SET NON-EDITABLE VARIABLES 
							if ($edit != "1") {
							
							
								

													
						

							

						} else {
							$t->set_var("INTERIM","No Interim Reports selected, or database empty!");
						}
											
												
			}

}


		//$t->parse(MAINSTAGE, "form");
		if ( $getarray  > "0"){ 
			$t->parse(REPORT_HEADER, "report_header");
			$t->parse(TABLE_GENERAL, "table_general");
			$t->parse(TABLE_SUBJECTS, "table_subjects_base");
			$t->parse(TABLE_SUBJECTS_STREAM, "table_subjects_stream_$getarray0[class_stream]_$interim");
			$t->parse(TABLE_PERFORMANCE, "table_performance$interim");
			$t->parse(TABLE_COMMENT, "table_comment$interim");
			$t->parse(TABLE_SIGNATURES, "table_signatures");
			$t->parse(TABLE_PERFORMANCE_CRITERIA, "table_performance_criteria");
			$t->parse(TABLE_GRADE_CRITERIA, "table_grade_criteria");
			$t->parse(CONTENT, "main$interim");
			} ELSE {
			$t->parse(CONTENT, "nodata");
		}
		$t->pparse(MAIN, "body");




// =========== END OF WHILE MANY ARE SHOWN ==========*/ 
							}

						
 						
}
// =========== END OF IF STUDENT_ID EMPTY ==========*/
//}
/* ==================================   END OF IF MULTIPLE PRINT ON  ============== = */

?>
