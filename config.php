<?PHP
	// Datenbankverbindung
		$dbhost = "localhost"; 
		$dbuser = "smartshanghai";
		$dbpass = "7ygvcft^";
		$dbname = "smartshanghai";
		
		$root = "//localhost/afp/";
		
		$status_array = array(
		'0' => "inactive",
		'1' => "active");

		$preferedname_array = array(
		'0' => "English",
		'1' => "Chinese");
		
		$sex_array = array(
		'1' => "Male",
		'2' => "Female");
		
		$enrollement_array = array(
		'1' => "WS 2005",
		'2' => "SS 2006",
		'3' => "WS 2006",
		'4' => "SS 2007",
		'5' => "WS 2007",
		'6' => "SS 2008",
		'7' => "WS 2008",
		'8' => "SS 2009");
		
		$descent_array = array(
		'1' => "unknown",
		'2' => "Asian",
		'3' => "Black",
		'4' => "Hispanic / Latino",
		'5' => "Middle-Eastern",
		'6' => "White",
		'7' => "Mixed",
		'8' => "Other");
		
		$immunizations_array = array(
		'1' => "Measles",
		'2' => "Mumps",
		'3' => "Rebella",
		'4' => "Diptheris/Tetanus",
		'5' => "Pertussis (Whooping Cough)",
		'6' => "Polio",
		'7' => "TB",
		'8' => "Typhoid",
		'9' => "Hepatitis B");
		
		$diseas_array = array(
		'1' => "Frequent headaches",
		'2' => "Eye /ear problem",
		'3' => "Head injury",
		'4' => "Epilepsy/Seizures",
		'5' => "Astema",
		'6' => "Measles",
		'7' => "Rubella",
		'8' => "Frequent Stomachaches ",
		'9' => "Heart Disease",
		'10' => "Diabetes",
		'11' => "Menstrual Problems",
		'12' => "Head Injury",
		'13' => "Kidney Disease",
		'14' => "Infectious Disease",
		'15' => "Gastrointestinal Disease",
		'15' => "ADHD",
		'16' => "Blood Disorder",
		'17' => "Cancer",
		'18' => "Allergies - Environmental",
		'19' => "Allergies - Food",
		'20' => "Allergies - Drug",
		'21' => "Allergies - Cloth",
		'22' => "Other");
		
		$medical_others_array = array(
		'1' => "Gifted or talented program",
		'2' => "Language and speech disorder ",
		'3' => "Global delays, developmentally delayed ",
		'4' => "Dyslexia / dyspraxia / dysgraphia ",
		'5' => "Learning disability ",
		'6' => "Hyperactive",
		'7' => "Psycholinguistic disorder",
		'8' => "Emotional/ behavioral disorder",
		'9' => "Attention Deficit Disorder",
		'10' => "Autism / Asbergers ",
		'11' => "Physiotherapy",
		'12' => "Hearing impaired ",
		'13' => "Other");
		
		$contactlenses_array = array(
		'0' => "No",
		'1' => "Glasses",
		'2' => "Contact lenses",
		'3' => "Mixed");
		
		$lang_english_home_array = array(
		'0' => "No",
		'1' => "10%",
		'2' => "20%",
		'3' => "30%",
		'4' => "40%",
		'5' => "50%",
		'6' => "60%",
		'7' => "70%",
		'8' => "80%",
		'9' => "90%",
		'10' => "only english");
		
		$lang_english_level_array = array(
		'0' => "0",
		'1' => "1",
		'2' => "2",
		'3' => "3",
		'4' => "4",
		'5' => "5");
		
		$lang_chinese_level_array = array(
		'0' => "0",
		'1' => "1",
		'2' => "2",
		'3' => "3",
		'4' => "4",
		'5' => "5");
		
		$lang_maths_level_array = array(
		'0' => "English Maths",
		'1' => "Chinese Maths");
		
		$lang_ort_level_array = array(
		'0' => "0",
		'1' => "1",
		'2' => "2",
		'3' => "3",
		'4' => "4",
		'5' => "5",
		'6' => "6",
		'7' => "7",
		'8' => "8",
		'9' => "9",
		'10' => "10",
		'12' => "12",
		'13' => "13",
		'14' => "14",
		'15' => "15",
		'16' => "16",
		'17' => "17",
		'18' => "18",
		'19' => "19",
		'20' => "20");
		
		$legalcustodian_array = array(
		'0' => "Unclear",
		'1' => "Both parents",
		'2' => "Father",
		'3' => "Mother",
		'4' => "Other");
		
		$parentslanguageskills_array = array(
		'0' => "Unknown",
		'1' => "None",
		'2' => "Beginning",
		'3' => "Intermediate",
		'4' => "Advanced");
		
		$dorm_array = array(
		'0' => "Unknown",
		'1' => "Using school dorm",
		'2' => "Not using school dorm");
		
		$adbe_array = array(
		'0' => "Occasionally",
		'1' => "1",
		'2' => "2",
		'3' => "3",
		'4' => "Often");
		
		$payment_array = array(
		'0' => "Unpaid",
		'1' => "Paid");
		
		$payment_by_array = array(
		'0' => "Father",
		'1' => "Mother",
		'2' => "Both");
		
		$payment_method_array = array(
		'0' => "Cash",
		'1' => "Card",
		'2' => "Wire");
		
		$userlevel_array = array(
		'0' => "No access",
		'1' => "Read",
		'2' => "Write");
		
		$attend_array = array(
		'0' => "attending",
		'1' => "Attending - late",
		'2' => "Not attending - excused",
		'3' => "Not attending - unexcused");
		
		$gradesarray = array(
		'1' => "1",
		'2' => "2",
		'3' => "3",
		'4' => "4",
		'5' => "5",
		'6' => "6",
		'7' => "7",
		'8' => "8",
		'9' => "9",
		'10' => "10",
		'11' => "11");
		
		$newsletterstatus_array = array(
		'0' => "No newsletter",
		'1' => "Regular newsletter",
		'2' => "Parent Advisor group");
		
		$newsletterlists_array = array(
		'0' => "All parents",
		'1' => "Parent Advisor Group",
		'2' => "Teachers");
		
?>
