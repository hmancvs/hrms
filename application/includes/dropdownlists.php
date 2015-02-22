<?php

	# This class require_onces functions to access and use the different drop down lists within
	# this application

	/**
	 * function to return the results of an options query as array. This function assumes that
	 * the query returns two columns optionvalue and optiontext which correspond to the corresponding key
	 * and values respectively. 
	 * 
	 * The selection of the names is to avoid name collisions with database reserved words
	 * 
	 * @param String $query The database query
	 * 
	 * @return Array of values for the query 
	 */
	function getOptionValuesFromDatabaseQuery($query) {
		$conn = Doctrine_Manager::connection(); 
		$result = $conn->fetchAll($query);
		$valuesarray = array();
		foreach ($result as $value) {
			$valuesarray[$value['optionvalue']]	= htmlentities($value['optiontext']);
		}
		return decodeHtmlEntitiesInArray($valuesarray);
	}
	# function to generate months
	function getAllMonths() {
		$months = array(
		"January" => "January",		
		"February" => "February",
		"March" => "March",
		"April" => "April",
		"May" => "May",		
		"June" => "June",
		"July" => "July",
		"August" => "August",
		"September" => "September",		
		"October" => "October",
		"November" => "November",
		"December" => "December"	
		);
		return $months;
	}
	
	# function to generate months
	function getAllMonthsAsNumbers() {
		$months = array(
		"01" => "January",		
		"02" => "February",
		"03" => "March",
		"04" => "April",
		"05" => "May",		
		"06" => "June",
		"07" => "July",
		"08" => "August",
		"09" => "September",		
		"10" => "October",
		"11" => "November",
		"12" => "December"	
		);
		return $months;
	}
	# function to generate months
	function getShortMonthsAsNumbers($current='') {
		$months = array(
		"01" => "Jan",		
		"02" => "Feb",
		"03" => "Mar",
		"04" => "Apr",
		"05" => "May",		
		"06" => "Jun",
		"07" => "Jul",
		"08" => "Aug",
		"09" => "Sep",		
		"10" => "Oct",
		"11" => "Nov",
		"12" => "Dec"	
		);
		if(!isEmptyString($current)){
			return $months[$current];
		}
		return $months;
	}
	# split a date into day month and year
	function splitDate($date) {
		if(isEmptyString($date)){
			return array();
		}
		$date = date('Y-n-j',strtotime($date));
		$date_parts = explode('-', $date);
		// debugMessage($date_parts);
		return $date_parts;	
	}
	# function to generate months
	function getMonthsAsNumbers() {
		$months = array(
		"01" => "01",		
		"02" => "02",
		"03" => "03",
		"04" => "04",
		"05" => "05",		
		"06" => "06",
		"07" => "07",
		"08" => "08",
		"09" => "09",		
		"10" => "10",
		"11" => "11",
		"12" => "12"	
		);
		return $months;
	}
	# function to generate months short names
	function getAllMonthsAsShortNames($current ='') {
		$months = array(
		"1" => "Jan",		
		"2" => "Feb",
		"3" => "Mar",
		"4" => "Apr",
		"5" => "May",		
		"6" => "Jun",
		"7" => "Jul",
		"8" => "Aug",
		"9" => "Sept",		
		"10" => "Oct",
		"11" => "Nov",
		"12" => "Dec"	
		);
		if(!isEmptyString($current)){
			return $months[$current];
		}
		return $months;
	}
	
	function getMonthName($number) {
		$months = getAllMonthsAsNumbers();
		return $months[$number];
	}
	# determine days of week
	function getDaysOfWeek($current ='') {
		$days = array(
				"1" => "Monday",
				"2" => "Tuesday",
				"3" => "Wednesday",
				"4" => "Thursday",
				"5" => "Friday",
				"6" => "Saturday",
				"7" => "Sunday",
		);
		if(!isEmptyString($current)){
			return $days[$current];
		}
		return $days;
	}
	
	# function to generate years
	function getAllYears($yearsback="", $yearsahead="") {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		$start_year = date("Y") - $aconfig->dateandtime->mindate;
		if(!isEmptyString($yearsback)){
			$start_year = date("Y") - $yearsback;
		}
		$end_year = date("Y") + $aconfig->dateandtime->maxdate;
		if(!isEmptyString($yearsahead)){
			$end_year = date("Y") + $yearsahead;
		}
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return array_reverse($years, true);
	}
	function getYearsInRage($start, $ahead) {
		$aconfig = Zend_Registry::get("config");
		$years = array();
		$start_year = date("Y") - $aconfig->dateandtime->mindate;
		if(!isEmptyString($start)){
			$start_year = $start;
		}
		$end_year = date("Y") + $aconfig->dateandtime->maxdate;
		if(!isEmptyString($ahead)){
			$end_year = $ahead;
		}
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i;
		}
		return array_reverse($years, true);
	}
	
	# function to generate future years
	function getFutureYears() {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		$start_year = date("Y");
		
		$end_year = date("Y") + $aconfig->dateandtime->mindate;
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return $years;
	}
        # function to generate years
	function getMultipleYears() {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		$start_year = date("Y") - $aconfig->dateandtime->mindateofbirth;
		
		$end_year = date("Y");
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return array_reverse($years, true);
	}
	 # function to generate years
	function getSubscribeBirthYears() {				
		$aconfig = Zend_Registry::get("config"); 
		$years = array(); 
		// $start_year = (date("Y")) - 100;
		$start_year = 1900;
		
		$end_year = (date("Y"));
		for($i = $start_year; $i <= $end_year; $i++) {
			$years[$i] = $i; 
		}		
		//return the years in descending order from the last year to the first and add true to maintain the array keys
		return array_reverse($years, true);
	}
	# function to generate years
	function getMonthDays() {
		$days = array(); 
		$start_day = 1;
	
		$end_day = 31;
		for($i = $start_day; $i <= $end_day; $i++) {
			$days[$i] = $i; 
		}		
		//return the years in descending order from 2009 down to the start year and true to maintain the array keys
		return $days;
	}
	# get the first day of a month
	function getFirstDayOfMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month,1,$year));
	}
	# get the last day of a month
	function getLastDayOfMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month+1,0,$year));
	}
	# get the first day of current month
	function getFirstDayOfNextMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month,2,$year));
	}
	# get the last day of the next month
	function getLastDayOfNextMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month+2,0,$year));
	}
	# get the first day of last month
	function getFirstDayOfLastMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month,-1,$year));
	}
	# get the last day of the last month
	function getLastDayOfLastMonth($month,$year) {
		return date("Y-m-d", mktime(0,0,0, $month-1,0,$year));
	}
	# get the first day of the current year and month
	function getFirstDayOfCurrentMonth(){
		return date("Y-m-d", mktime (0,0,0, date("n"),1, date("Y")));
	}
	# get the last day of the last month
	function getLastDayOfCurrentMonth() {
		return date("Y-m-d", mktime(0,0,0, date("n")+1,0, date("Y")));
	}
	function getFirstDateOfMonth($date){
		return date("Y-m-d", mktime (0,0,0, date("n", strtotime($date)),1, date("Y", strtotime($date))));
	}
	function getLastDateOfMonth($date) {
		return date("Y-m-d", mktime(0,0,0, date("n", strtotime($date))+1,0, date("Y", strtotime($date))));
	}
	# return array of months between two dates
	function get_months($date1, $date2) {
		$time1  = strtotime($date1);
		$time2  = strtotime($date2);
		$my     = date('mY', $time2);
		$shortmonths = getShortMonthsAsNumbers();
		
		$months[date('Y',$time1).date('m',$time1)] = array('yearmonth'=>date('Y',$time1).date('m',$time1), 'year'=>date('Y', $time1), 'monthnumber'=>date('m', $time1), 'monthfull'=>date('F', $time1), 'monthshort'=>$shortmonths[date('m', $time1)], 'monthdisplay'=>$shortmonths[date('m', $time1)].' '.date('Y', $time1));
	
		while($time1 < $time2) {
			$time1 = strtotime(date('Y-m-d', $time1).' +1 month');
			if(date('mY', $time1) != $my && ($time1 < $time2)){
				$months[date('Y',$time1).date('m',$time1)] = array('yearmonth'=>date('Y',$time1).date('m',$time1), 'year'=>date('Y', $time1), 'monthnumber'=>date('m', $time1), 'monthfull'=>date('F', $time1), 'monthshort'=>$shortmonths[date('m', $time1)], 'monthdisplay'=>$shortmonths[date('m', $time1)].' '.date('Y', $time1));
			}
		}
	
		$months[date('Y',$time2).date('m',$time2)] = array('yearmonth'=>date('Y',$time2).date('m',$time2), 'year'=>date('Y', $time2), 'monthnumber'=>date('m', $time2), 'monthfull'=>date('F', $time2), 'monthshort'=>$shortmonths[date('m', $time2)], 'monthdisplay'=>$shortmonths[date('m', $time2)].' '.date('Y', $time2));
		return $months;
	}
	# determine the weeks between a period
	function get_weeks($date1, $date2) {
		$time1  = strtotime($date1);
		$time2  = strtotime($date2);
		$my     = date('Y', $time2).(date('W', $time2)-1);
		$shortmonths = getShortMonthsAsNumbers();
		
		$weeks[date('Y', $time1).(date('W', $time1)-1)] = array('yearmonth'=>date('Y',$time1).date('m',$time1), 'year'=>date('Y', $time1), 'monthnumber'=>date('m', $time1), 'monthfull'=>date('F', $time1), 'monthshort'=>$shortmonths[date('m', $time1)], 'monthdisplay'=>$shortmonths[date('m', $time1)].' '.date('Y', $time1), 'yearweek'=> date('Y', $time1).(date('W', $time1)-1), 'week'=>(date('W', $time1)-1));
		
		while($time1 < $time2) {
			$time1 = strtotime(date('Y-m-d', $time1).' +7 day');
			if(date('Y', $time1).(date('W', $time1)-1) != $my && ($time1 < $time2)){
				$weeks[date('Y',$time1).(date('W', $time1)-1)] = array('yearmonth'=>date('Y',$time1).date('m',$time1), 'year'=>date('Y', $time1), 'monthnumber'=>date('m', $time1), 'monthfull'=>date('F', $time1), 'monthshort'=>$shortmonths[date('m', $time1)], 'monthdisplay'=>$shortmonths[date('m', $time1)].' '.date('Y', $time1), 'yearweek'=> date('Y', $time1).(date('W', $time1)-1), 'week'=>(date('W', $time1)-1));
			}
		}
		$weeks[date('Y', $time2).(date('W', $time2)-1)] = array('yearmonth'=>date('Y',$time2).date('m',$time2), 'year'=>date('Y', $time2), 'monthnumber'=>date('m', $time2), 'monthfull'=>date('F', $time2), 'monthshort'=>$shortmonths[date('m', $time2)], 'monthdisplay'=>$shortmonths[date('m', $time2)].' '.date('Y', $time2), 'yearweek'=> date('Y', $time2).(date('W', $time2)-1), 'week'=>(date('W', $time2)-1));
		
		return $weeks;
	}
	# determine no of days between two dates
	function getDaysBetweenDates($date1, $date2) {
		$time1  = strtotime($date1);
		$time2  = strtotime($date2);
		return ($time2-$time1)/(24*60*60);
	}
    /**
	 * Return an array containing the countries in the world
	 *
	 * @return Array Containing 2 digit country codes as the key, and the name of a couuntry as the value
	 */
	function getCountries($value = ''){
		$country_list = array(
			"GB" => "United Kingdom",
			"US" => "United States",
			"AF" => "Afghanistan",
			"AL" => "Albania",
			"DZ" => "Algeria",
			"AS" => "American Samoa",
			"AD" => "Andorra",
			"AO" => "Angola",
			"AI" => "Anguilla",
			"AQ" => "Antarctica",
			"AG" => "Antigua And Barbuda",
			"AR" => "Argentina",
			"AM" => "Armenia",
			"AW" => "Aruba",
			"AU" => "Australia",
			"AT" => "Austria",
			"AZ" => "Azerbaijan",
			"BS" => "Bahamas",
			"BH" => "Bahrain",
			"BD" => "Bangladesh",
			"BB" => "Barbados",
			"BY" => "Belarus",
			"BE" => "Belgium",
			"BZ" => "Belize",
			"BJ" => "Benin",
			"BM" => "Bermuda",
			"BT" => "Bhutan",
			"BO" => "Bolivia",
			"BA" => "Bosnia And Herzegowina",
			"BW" => "Botswana",
			"BV" => "Bouvet Island",
			"BR" => "Brazil",
			"IO" => "British Indian Ocean Territory",
			"BN" => "Brunei Darussalam",
			"BG" => "Bulgaria",
			"BF" => "Burkina Faso",
			"BI" => "Burundi",
			"KH" => "Cambodia",
			"CM" => "Cameroon",
			"CA" => "Canada",
			"CV" => "Cape Verde",
			"KY" => "Cayman Islands",
			"CF" => "Central African Republic",
			"TD" => "Chad",
			"CL" => "Chile",
			"CN" => "China",
			"CX" => "Christmas Island",
			"CC" => "Cocos (Keeling) Islands",
			"CO" => "Colombia",
			"KM" => "Comoros",
			"CG" => "Congo",
			"CD" => "Congo, The Democratic Republic Of The",
			"CK" => "Cook Islands",
			"CR" => "Costa Rica",
			"CI" => "Cote D'Ivoire",
			"HR" => "Croatia (Local Name: Hrvatska)",
			"CU" => "Cuba",
			"CY" => "Cyprus",
			"CZ" => "Czech Republic",
			"DK" => "Denmark",
			"DJ" => "Djibouti",
			"DM" => "Dominica",
			"DO" => "Dominican Republic",
			"TP" => "East Timor",
			"EC" => "Ecuador",
			"EG" => "Egypt",
			"SV" => "El Salvador",
			"GQ" => "Equatorial Guinea",
			"ER" => "Eritrea",
			"EE" => "Estonia",
			"ET" => "Ethiopia",
			"FK" => "Falkland Islands (Malvinas)",
			"FO" => "Faroe Islands",
			"FJ" => "Fiji",
			"FI" => "Finland",
			"FR" => "France",
			"FX" => "France, Metropolitan",
			"GF" => "French Guiana",
			"PF" => "French Polynesia",
			"TF" => "French Southern Territories",
			"GA" => "Gabon",
			"GM" => "Gambia",
			"GE" => "Georgia",
			"DE" => "Germany",
			"GH" => "Ghana",
			"GI" => "Gibraltar",
			"GR" => "Greece",
			"GL" => "Greenland",
			"GD" => "Grenada",
			"GP" => "Guadeloupe",
			"GU" => "Guam",
			"GT" => "Guatemala",
			"GN" => "Guinea",
			"GW" => "Guinea-Bissau",
			"GY" => "Guyana",
			"HT" => "Haiti",
			"HM" => "Heard And Mc Donald Islands",
			"VA" => "Holy See (Vatican City State)",
			"HN" => "Honduras",
			"HK" => "Hong Kong",
			"HU" => "Hungary",
			"IS" => "Iceland",
			"IN" => "India",
			"ID" => "Indonesia",
			"IR" => "Iran (Islamic Republic Of)",
			"IQ" => "Iraq",
			"IE" => "Ireland",
			"IL" => "Israel",
			"IT" => "Italy",
			"JM" => "Jamaica",
			"JP" => "Japan",
			"JO" => "Jordan",
			"KZ" => "Kazakhstan",
			"KE" => "Kenya",
			"KI" => "Kiribati",
			"KP" => "Korea, Democratic People's Republic Of",
			"KR" => "Korea, Republic Of",
			"KW" => "Kuwait",
			"KG" => "Kyrgyzstan",
			"LA" => "Lao People's Democratic Republic",
			"LV" => "Latvia",
			"LB" => "Lebanon",
			"LS" => "Lesotho",
			"LR" => "Liberia",
			"LY" => "Libyan Arab Jamahiriya",
			"LI" => "Liechtenstein",
			"LT" => "Lithuania",
			"LU" => "Luxembourg",
			"MO" => "Macau",
			"MK" => "Macedonia, Former Yugoslav Republic Of",
			"MG" => "Madagascar",
			"MW" => "Malawi",
			"MY" => "Malaysia",
			"MV" => "Maldives",
			"ML" => "Mali",
			"MT" => "Malta",
			"MH" => "Marshall Islands",
			"MQ" => "Martinique",
			"MR" => "Mauritania",
			"MU" => "Mauritius",
			"YT" => "Mayotte",
			"MX" => "Mexico",
			"FM" => "Micronesia, Federated States Of",
			"MD" => "Moldova, Republic Of",
			"MC" => "Monaco",
			"MN" => "Mongolia",
			"MS" => "Montserrat",
			"MA" => "Morocco",
			"MZ" => "Mozambique",
			"MM" => "Myanmar",
			"NA" => "Namibia",
			"NR" => "Nauru",
			"NP" => "Nepal",
			"NL" => "Netherlands",
			"AN" => "Netherlands Antilles",
			"NC" => "New Caledonia",
			"NZ" => "New Zealand",
			"NI" => "Nicaragua",
			"NE" => "Niger",
			"NG" => "Nigeria",
			"NU" => "Niue",
			"NF" => "Norfolk Island",
			"MP" => "Northern Mariana Islands",
			"NO" => "Norway",
			"OM" => "Oman",
			"PK" => "Pakistan",
			"PW" => "Palau",
			"PA" => "Panama",
			"PG" => "Papua New Guinea",
			"PY" => "Paraguay",
			"PE" => "Peru",
			"PH" => "Philippines",
			"PN" => "Pitcairn",
			"PL" => "Poland",
			"PT" => "Portugal",
			"PR" => "Puerto Rico",
			"QA" => "Qatar",
			"RE" => "Reunion",
			"RO" => "Romania",
			"RU" => "Russian Federation",
			"RW" => "Rwanda",
			"KN" => "Saint Kitts And Nevis",
			"LC" => "Saint Lucia",
			"VC" => "Saint Vincent And The Grenadines",
			"WS" => "Samoa",
			"SM" => "San Marino",
			"ST" => "Sao Tome And Principe",
			"SA" => "Saudi Arabia",
			"SN" => "Senegal",
			"SC" => "Seychelles",
			"SL" => "Sierra Leone",
			"SG" => "Singapore",
			"SK" => "Slovakia (Slovak Republic)",
			"SI" => "Slovenia",
			"SB" => "Solomon Islands",
			"SO" => "Somalia",
			"ZA" => "South Africa",
			"GS" => "South Georgia, South Sandwich Islands",
			"ES" => "Spain",
			"LK" => "Sri Lanka",
			"SH" => "St. Helena",
			"PM" => "St. Pierre And Miquelon",
			"SD" => "Sudan",
			"SR" => "Suriname",
			"SJ" => "Svalbard And Jan Mayen Islands",
			"SZ" => "Swaziland",
			"SE" => "Sweden",
			"CH" => "Switzerland",
			"SY" => "Syrian Arab Republic",
			"TW" => "Taiwan",
			"TJ" => "Tajikistan",
			"TZ" => "Tanzania, United Republic Of",
			"TH" => "Thailand",
			"TG" => "Togo",
			"TK" => "Tokelau",
			"TO" => "Tonga",
			"TT" => "Trinidad And Tobago",
			"TN" => "Tunisia",
			"TR" => "Turkey",
			"TM" => "Turkmenistan",
			"TC" => "Turks And Caicos Islands",
			"TV" => "Tuvalu",
			"UG" => "Uganda",
			"UA" => "Ukraine",
			"AE" => "United Arab Emirates",
			"UM" => "United States Minor Outlying Islands",
			"UY" => "Uruguay",
			"UZ" => "Uzbekistan",
			"VU" => "Vanuatu",
			"VE" => "Venezuela",
			"VN" => "Viet Nam",
			"VG" => "Virgin Islands (British)",
			"VI" => "Virgin Islands (U.S.)",
			"WF" => "Wallis And Futuna Islands",
			"EH" => "Western Sahara",
			"YE" => "Yemen",
			"YU" => "Yugoslavia",
			"ZM" => "Zambia",
			"ZW" => "Zimbabwe"
		);
		return $country_list;
	}
	/**
	 * Return full name of a country
	 *
	 * @return String Name of country
	 */
	function getFullCountryName($countrycode) {
		$countriesarray = getCountries();
		return $countriesarray[$countrycode];
	}
	/**
	 * Return an array containing the 2 digit US state codes and names of the states
	 *
	 * @return Array Containing 2 digit state codes as the key, and the name of a US state as the value
	 */
	function getStates() {
		$state_list = array('AL'=>"Alabama",  
			'AK'=>"Alaska",  
			'AZ'=>"Arizona",  
			'AR'=>"Arkansas",  
			'CA'=>"California",  
			'CO'=>"Colorado",  
			'CT'=>"Connecticut",  
			'DE'=>"Delaware",  
			'DC'=>"District Of Columbia",  
			'FL'=>"Florida",  
			'GA'=>"Georgia",  
			'HI'=>"Hawaii",  
			'ID'=>"Idaho",  
			'IL'=>"Illinois",  
			'IN'=>"Indiana",  
			'IA'=>"Iowa",  
			'KS'=>"Kansas",  
			'KY'=>"Kentucky",  
			'LA'=>"Louisiana",  
			'ME'=>"Maine",  
			'MD'=>"Maryland",  
			'MA'=>"Massachusetts",  
			'MI'=>"Michigan",  
			'MN'=>"Minnesota",  
			'MS'=>"Mississippi",  
			'MO'=>"Missouri",  
			'MT'=>"Montana",
			'NE'=>"Nebraska",
			'NV'=>"Nevada",
			'NH'=>"New Hampshire",
			'NJ'=>"New Jersey",
			'NM'=>"New Mexico",
			'NY'=>"New York",
			'NC'=>"North Carolina",
			'ND'=>"North Dakota",
			'OH'=>"Ohio",  
			'OK'=>"Oklahoma",  
			'OR'=>"Oregon",  
			'PA'=>"Pennsylvania",  
			'RI'=>"Rhode Island",  
			'SC'=>"South Carolina",  
			'SD'=>"South Dakota",
			'TN'=>"Tennessee",  
			'TX'=>"Texas",  
			'UT'=>"Utah",  
			'VT'=>"Vermont",  
			'VA'=>"Virginia",  
			'WA'=>"Washington",  
			'WV'=>"West Virginia",  
			'WI'=>"Wisconsin",  
			'WY'=>"Wyoming");
		
		return $state_list; 
	}
	/**
	 * Return full name of a US state
	 *
	 * @return String Name of state
	 */
	function getFullStateName($state) {
		$statesarray = getStates();
		return $statesarray[$state];
	}
   
	# determine signup contact categories
	function getContactUsCategories(){
		$query = "SELECT l.lookuptypevalue as optionvalue, l.lookupvaluedescription as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name =  'CONTACTUS_CATEGORIES' ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# all listable variable groupings
	function getAllists(){
		$conn = Doctrine_Manager::connection();
		$all_lists = $conn->fetchAll("SELECT l.id as id, l.displayname as name FROM lookuptype AS l WHERE l.listable = 1 order by l.displayname ASC ");
		return $all_lists;
	}
	# all listable variable groupings as lookuptype
	function getListableLookupTypes($current = ''){
		$query = "SELECT l.id as optionvalue, l.displayname as optiontext FROM lookuptype AS l WHERE l.listable = 1 order by l.displayname ASC ";
		$array = getOptionValuesFromDatabaseQuery($query);
		return $array;
	}	
	# user types
	function getUserType($value = '', $ignorelist =''){
		$custom_query = "";
		if(!isEmptyString($ignorelist)){
			$custom_query .= " AND a.id NOT IN(".$ignorelist.") ";
		}
		
		$query = "SELECT a.id as optionvalue, a.name as optiontext FROM aclgroup a where a.id <> '' ".$custom_query." order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		return $array;
	}
	function getSystemUsers($value = ''){
		$query = "SELECT u.id as optionvalue, concat(u.firstname,' ',u.lastname) as optiontext FROM useraccount as u Left Join aclusergroup AS g ON u.id = g.userid WHERE g.groupid != '8' AND u.isactive = 1 ORDER BY optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		return $array;
	}
	# user status
	function getUserStatus($value = ''){
		$array = array(0 =>'Inactive', 1 => 'Active', 2=>'Deactivated');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		return $array;
	}
	# product status values
	function getActiveStatus($value = ''){
		$array = array('1' => 'Enabled', '0' =>'Disabled');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		return $array;
	}
	# check for level one categories
	function getLevelOneCategories($value = ''){
		$query = "SELECT c.id as optionvalue, c.name as optiontext FROM category c where c.level = 1 order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			return $array[$value];
		}
		return $array;
	}
	
	# determine the application config variables
	function getConfigLookups() {
		$conn = Doctrine_Manager::connection();
		$all_users = $conn->fetchAll("SELECT * FROM appconfig where id <> '' group by section order by sectiondisplay ");
		return $all_users;
	}
	
	# categories in category table
	function getCategories($sectorid = '', $parentid = ''){
		$custom_query = '';
		if(!isEmptyString($sectorid)){
			$custom_query .= " AND c.sectorid = '".$sectorid."' ";
		}
		if(!isEmptyString($parentid)){
			$custom_query .= " AND c.parentid = '".$parentid."' ";
		}
		$query = "SELECT c.id as optionvalue, c.name as optiontext FROM category AS c WHERE c.status = 1 ".$custom_query." order by c.id ASC ";
		return getOptionValuesFromDatabaseQuery($query);
	}
	
	# latest system user 
	function getLatestUsers($limit){
		$conn = Doctrine_Manager::connection();
		$all_users = $conn->fetchAll("SELECT u.*, IF(u.displayname <> '', u.displayname, concat(u.firstname, ' ', u.lastname, ' ', u.othername)) as name FROM useraccount as u WHERE u.id <> '' order by u.datecreated DESC, u.id DESC limit ".$limit);
		return $all_users;
	}
	function getUsers($type = '', $limit = '', $ignoretype = '', $ignorelist = '', $wherequery = '', $hasemail = false, $hasphone = false){
		$custom_query = '';
		if(!isEmptyString($type)){
			$custom_query .= " AND u.type = '".$type."' ";
		}
		if(!isEmptyString($ignoretype)){
			$custom_query .= " AND u.type != '".$ignoretype."' ";
		}
		if(!isEmptyString($ignorelist)){
			$custom_query .= " AND u.id NOT IN(".$ignorelist.") ";
		}
		if(!isEmptyString($wherequery)){
			$custom_query .= $wherequery;
		}
		if($hasemail){
			$custom_query .= " AND u.email <> '' ";
		}
		if($hasphone){
			$custom_query .= " AND u.phone <> '' ";
		}
		$limit_query = '';
		if(!isEmptyString($limit)){
			$limit_query= ' LIMIT '.$limit;
		}
		$valuesquery = "SELECT u.id AS optionvalue, IF(u.displayname <> '', u.displayname, concat(u.firstname, ' ', u.lastname, ' ', u.othername)) as optiontext FROM useraccount u WHERE u.id <> '' ".$custom_query." GROUP BY u.id ORDER BY optiontext ASC ".$limit_query;
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# fetch all user with an email
	function getUsersWithEmail($isuser = false){
		$custom_query = "";
		if($isuser){
			$custom_query = " AND (u.type <> '' OR u.type IS NOT NULL) ";
		}
		$valuesquery = "SELECT u.id AS optionvalue, IF(u.displayname <> '', concat(u.displayname,' [',u.email,']'), concat(u.firstname, ' ', u.lastname, ' ', u.othername,' [',u.email,']')) as optiontext FROM useraccount as u WHERE u.email <> '' ".$custom_query." ORDER BY optiontext ASC ";
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# fetch all members with a phone
	function getUsersWithPhone($isuser = false){
		$custom_query = "";
		if($isuser){
			$custom_query = " AND (u.type <> '' OR u.type IS NOT NULL) ";
		}
		$valuesquery = "SELECT u.id AS optionvalue, IF(u.displayname <> '', concat(u.displayname,' [',u.phone,']'), concat(u.firstname, ' ', u.lastname, ' ', u.othername,' [',u.phone,']')) as optiontext FROM useraccount as u WHERE u.phone <> '' ".$custom_query." ORDER BY optiontext ASC ";
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	function getUserDetails($type = '', $limit = '', $status = 1, $user ='', $start = '', $end ='', $emails=''){
		$custom_query = '';
		if(!isEmptyString($type)){
			$custom_query .= " AND u.type = '".$type."' ";
		}
		if(!isEmptyString($emails)){
			$custom_query .= " AND u.email in(".$emails.")";
		}
		$limit_query = '';
		if(!isEmptyString($limit)){
			$limit_query= ' LIMIT '.$limit;
		}
		$status_query = ' u.status = 1 ';
		if(!isEmptyString($status) && $status == 0){
			$status_query = " u.status = 0 ";
		}
		if(!isEmptyString($status) && $status == 2){
			$status_query = " (u.status = 1 || u.status = 0) ";
		}
		if(!isEmptyString($status) && $status == 'x'){
			$status_query = " (u.status <> '') ";
		}
		if(!isEmptyString($user)){
			$custom_query = " AND u.id = '".$user."' ";
		}
		if(!isEmptyString($start) && !isEmptyString($end)){
			$limit_query = ' LIMIT '.$start.','.$end;
		}
		
		$conn = Doctrine_Manager::connection();
		$query = "SELECT u.id AS id, u.firstname as firstname, concat(u.firstname, ' ', u.lastname, ' ', u.othername) as name, u.email as email FROM useraccount as u WHERE u.id <> '' AND (".$status_query.") ".$custom_query." GROUP BY u.id ORDER BY name ASC ".$limit_query;
		// debugMessage($query);
		$all_lists = $conn->fetchAll($query);
		return $all_lists;
	}
	
	function getTimesheetUsers(){
		$query = "SELECT u.id AS optionvalue, concat(u.firstname, ' ', u.lastname, ' ', u.othername) AS optiontext FROM useraccount as u WHERE u.id <> '' AND u.istimesheetuser = 1 ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	function getUserIDFromUsername($username){
		$valuesquery = "SELECT u.id FROM useraccount as u WHERE u.id <> '' AND u.username = '".$username."' ";
		// debugMessage($valuesquery);
		$conn = Doctrine_Manager::connection();
		$result = $conn->fetchOne($valuesquery);
		return $result;
		// return true;
	}
	# determine the resources
	function getResources(){
		$query = "SELECT r.name AS optiontext, r.id AS optionvalue FROM aclresource AS r ORDER BY optiontext";
		return getOptionValuesFromDatabaseQuery($query);
	}
	# determine the dropdown value for a lookuptype
	function getDatavariables($lookuptypetext = '', $value = '', $checkempty = false){
		$query = "SELECT l.lookuptypevalue as optionvalue, trim(l.lookupvaluedescription) as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name = '".$lookuptypetext."' ";
		// debugMessage($query); exit();
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
		return $array;
	}
	# determine the departments
	function getDepartments($value ='', $checkempty = false){
		$query = "SELECT d.id as optionvalue, d.name as optiontext FROM department d where d.id <> '' order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
		return $array;
	}
	# determine the work shifts
	function getWorkShifts($value ='', $checkempty = false){
		$query = "SELECT s.id as optionvalue, concat(s.name,' (', TIME_FORMAT(s.starttime, '%H%iHRS'), ' - ', TIME_FORMAT(s.endtime, '%H%iHRS'),')') as optiontext FROM shift s where s.id <> '' order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
		return $array;
	}
	# determine if user has checked in today
	function isCheckedIn($userid, $date){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT id FROM timesheet AS t where t.`userid` = '".$userid."' AND TO_DAYS(t.datein) = TO_DAYS('".$date."') AND t.timein <> '' AND t.timeout is null "; // debugMessage($query);
		$result = $conn->fetchOne($query); // debugMessage($result);
		if(!isEmptyString($result)){
			return true;
		}
		return false;
	}
	function getWeekTimesheetsForUser($userid, $startdate, $enddate){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT t.userid, t.timesheetdate, t.`status`, t.hours, t.datein, t.dateout, t.timein, t.timeout, WEEKDAY(t.timesheetdate)+1 as weekno from timesheet t where t.userid = '".$userid."' and TO_DAYS(t.timesheetdate) BETWEEN TO_DAYS('".$startdate."') AND TO_DAYS('".$enddate."') ";   //debugMessage($query);
		$result = $conn->fetchAll($query); // debugMessage($result);
		
		return $result;
	}
	
	function getAttendanceStatuses($status = ''){
		$values = array('0'=>'On Duty', '1'=>'Logged', '2'=>'Pending Approval', '3'=>'Approved', '4'=>'Rejected');
		if(!isEmptyString($status)){
			return $values[$status];
		}
		return $values;
	}
	
	function getTimesheetStatuses($status = '') {
		$values = array('0'=>'On Duty', '1'=>'Logged', '2'=>'Submitted', '3'=>'Approved', '4'=>'Rejected', '5'=>'Overdue');
		if(!isEmptyString($status)){
			return $values[$status];
		}
		return $values;
	}
	function getWeekDays(){
		return array(1=>'Monday', 2=>'Tuesday', 3=>'Wednesday', 4=>'Thursday', 5=>'Friday', 6=>'Saturday', 7=>'Sunday');
	}
	/**
	 * Determine the first day of a week
	 * @param String $date the date of the week
	 * @return String the first date of a week
	 */
	function getWeekStartDate($date) {
	    $ts = strtotime($date);
	    $start = (date('w', $ts) == 1) ? $ts : strtotime('last monday', $ts);
	    return date('Y-m-d', $start);
	}
	/**
	 * Determine the first day of a week
	 * @param String $date the date of the week
	 * @return String the first date of a week
	 */
	function getWeekEndDate($date) {
		$ts = strtotime($date);
		$start = (date('w', $ts) == 7) ? $ts : strtotime('this sunday', $ts);
		return date('Y-m-d', $start);
	}
	# determine the date after adding x days
	function getDateAfterDays($date, $days) {
		return date('Y-m-d', strtotime('+'.$days.' days', strtotime($date)));
	}
	# determine the date after adding x days
	function getDateBeforeDays($date, $days) {
		return date('Y-m-d', strtotime('-'.$days.' days', strtotime($date)));
	}
	function getShortWeekDays(){
		return array(1=>'Mon', 2=>'Tue', 3=>'Wed', 4=>'Thur', 5=>'Fri', 6=>'Sat', 7=>'Sun');
	}
	function getMondayOfWeek($week, $year) {
		$timestamp = mktime( 0, 0, 0, 1, 1,  $year ) + ((7+1-(date( 'N', mktime( 0, 0, 0, 1, 1,  $year ) )))*86400) + ($week-2)*7*86400 + 1 ;
		return date('Y-m-d', $timestamp);
	}
	function getSundayOfWeek($week, $year) {
		$monday = getMondayOfWeek($week, $year); 
		return date('Y-m-d', strtotime('+6 days', strtotime($monday)));
	}
	# fetch all benefits data. option for addition where cond
	function getAllBenefitsDetails($customquery = ""){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * from benefittype where id <> '' ".$customquery." order by name ";   //debugMessage($query);
		$result = $conn->fetchAll($query); // debugMessage($result);
	
		return $result;
	}
	# determine the monetary benefits as a dropdown
	function getBenefits($value ='', $checkempty = false){
		$query = "SELECT b.id as optionvalue, b.name as optiontext FROM benefittype b where b.id <> '' order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
		return $array;
	}
	# fetch all benefits data. option for addition where condition
	function getEmployeeBenefits($userid, $type , $customquery = ""){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * from userbenefit where userid = '".$userid."' AND type = '".$type."' ".$customquery." order by id ";   // debugMessage($query);
		$result = $conn->fetchAll($query); // debugMessage($result);
	
		return $result;
	}
	# count number of cash benefits
	function countCashBenefits(){
		$conn = Doctrine_Manager::connection();
		// $query = "SELECT COUNT(*) + (SELECT COUNT(*) FROM benefittype) FROM timeofftype	 "; // debugMessage($query);
		$query = "SELECT COUNT(*) FROM benefittype"; // debugMessage($query);
		$result = $conn->fetchOne($query); // debugMessage($result);
		return $result;
	}
	# count number of time off benefits
	function countTimeBenefits(){
		$conn = Doctrine_Manager::connection();
		// $query = "SELECT COUNT(*) + (SELECT COUNT(*) FROM benefittype) FROM timeofftype	 "; // debugMessage($query);
		$query = "SELECT COUNT(*) FROM timeofftype"; // debugMessage($query);
		$result = $conn->fetchOne($query); // debugMessage($result);
		return $result;
	}
	# determine cash benefit terms
	function getAllBenefitTerms($value ='', $checkempty = false){
		$array =  array(1=>'Assign as Credit(Addition) to Salary', 2=>'Assign as Debit(Deduction) to Salary');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
		
		return $array;
	}
	# determine the time off types
	function getTimeoffTypes($value ='', $checkempty = false){
		$query = "SELECT b.id as optionvalue, b.name as optiontext FROM timeofftype b where b.id <> '' order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
		return $array;
	}
	# fetch all benefits data. option for addition where cond
	function getAllTimeoffDetails($customquery = ""){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * from timeofftype where id <> '' ".$customquery." order by id ";   //debugMessage($query);
		$result = $conn->fetchAll($query); // debugMessage($result);
	
		return $result;
	}
	# determine year month dropdown
	function getYearMonthDropdown($value ='', $checkempty = false){
		$array =  array('1'=>'Per Year', '2'=>'Per Month');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
	
		return $array;
	}
	# determine day hours dropdown
	function getHoursDaysDropdown($value ='', $checkempty = false){
		$array =  array('1'=>'Hours', '2'=>'Days');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
	
		return $array;
	}
	# determine ther benefit modes
	function getBenefitTypes($value ='', $checkempty = false){
		$array =  array('1'=>'Cash Benefit', '2'=>'Time-off Benefit');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
	
		return $array;
	}
	# determine ther benefit modes
	function getTrxnTypes($value ='', $checkempty = false){
		$array =  array('1'=>'Credit', '2'=>'Debit');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
	
		return $array;
	}
	# determine timeoff status
	function getTimeoffStatuses($value ='', $checkempty = false){
		$array =  array(0=>'Requested', 1=>'Approved', 2=>'Rejected', 3=>'On Leave',4=>'Taken');
		if(!isEmptyString($value)){
			if(!isArrayKeyAnEmptyString($value, $array)){
				return $array[$value];
			} else {
				return '';
			}
		}
		if($checkempty && isEmptyString($value)){
			return '';
		}
	
		return $array;
	}
	# determine number of hours accrued in the current financial period
	function getHoursAccrued($userid, $type=1, $start ='2015-01-01', $end='2015-12-31'){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT sum(timeofflength) FROM ledger where userid = '".$userid."' AND timeoffid = '".$type."' AND TO_DAYS(trxndate) BETWEEN TO_DAYS('".$start."') AND TO_DAYS('".$end."') AND ledgertype = '2' AND trxntype = '1' "; //debugMessage($query);
		$result = $conn->fetchOne($query); //debugMessage($result);
		return $result;
	}
	# determine the number of hours taken in the current financial period
	function getHoursTaken($userid, $type=1, $start ='2015-01-01', $end='2015-12-31'){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT sum(duration) FROM timeoff where userid = '".$userid."' AND typeid = '".$type."' AND TO_DAYS(startdate) BETWEEN TO_DAYS('".$start."') AND TO_DAYS('".$end."') AND status = '1' "; //debugMessage($query);
		$result = $conn->fetchOne($query); //debugMessage($result);
		return $result;
	}
	# determine number of hours available in the current financial period
	function getHoursAvailable($userid, $type=1, $start ='2015-01-01', $end='2015-12-31'){
		$accrued = getHoursAccrued($userid, $type, $start, $end); //debugMessage($accrued);
		$taken = getHoursTaken($userid, $type, $start, $end); //debugMessage($taken);
		$available = $accrued - $taken; // debugMessage($available);
		return $available < 0 ? 0 : number_format($available, 2);
	}
	# fetch all timeoff requests for a user 
	function getTimeoffRequests($userid ='', $start ='2015-01-01', $end='2015-12-31'){
		$conn = Doctrine_Manager::connection();
		$customquery = "";
		if(!isEmptyString($userid)){
			$customquery = " AND t.userid = '".$userid."' ";
		}
		$query = "SELECT t.id, t.userid, t.typeid, p.name as type, t.`status`, t.duration, t.durationtype, t.startdate as startdate, t.enddate as enddate, t.returndate, t.starttime, t.endtime, t.returntime, p.calendarcolor, 
		IF(u.displayname <> '', u.displayname, concat(u.firstname, ' ', u.lastname, ' ', u.othername)) as `user`
		from timeoff t 
		inner join timeofftype p on t.typeid = p.id
		inner join useraccount u on t.userid = u.id
		where t.id <> '' ".$customquery." AND TO_DAYS(t.startdate) BETWEEN TO_DAYS('".$start."') AND TO_DAYS('".$end."') AND t.status = 1 order by t.startdate desc, t.id ";  //debugMessage($query);
		$result = $conn->fetchAll($query); //debugMessage($result);
	
		return $result;
	}
?>
