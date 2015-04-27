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
	# determine days of week
	function getShortDaysOfWeek($current ='') {
		$days = array(
				"1" => "Mon",
				"2" => "Tue",
				"3" => "Wed",
				"4" => "Thur",
				"5" => "Fri",
				"6" => "Sat",
				"7" => "Sun",
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
		return isArrayKeyAnEmptyString($countrycode, $countriesarray) ? '' : $countriesarray[$countrycode];
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
		$query = "SELECT u.id as optionvalue, IF(isnull(u.othername), concat(u.firstname,' ',u.lastname), concat(u.firstname,' ',u.lastname,' ',u.othername)) as optiontext FROM useraccount as u Left Join aclusergroup AS g ON u.id = g.userid WHERE g.groupid != '8' AND u.isactive = 1 ORDER BY optiontext ";
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
		$all_users = $conn->fetchAll("SELECT u.*, IF(isnull(u.othername), concat(u.firstname,' ',u.lastname), concat(u.firstname,' ',u.lastname,' ',u.othername)) as name FROM useraccount as u WHERE u.id <> '' order by u.datecreated DESC, u.id DESC limit ".$limit);
		return $all_users;
	}
	function getUsers($type = '', $limit = '', $ignoretype = '', $ignorelist = '', $wherequery = '', $hasemail = false, $hasphone = false){
		$companyid = getCompanyID();
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
		$custom_query .= " AND u.companyid = '".$companyid."' ";
		
		$limit_query = '';
		if(!isEmptyString($limit)){
			$limit_query= ' LIMIT '.$limit;
		}
		$valuesquery = "SELECT u.id AS optionvalue, IF(isnull(u.othername), concat(u.firstname,' ',u.lastname), concat(u.firstname,' ',u.lastname,' ',u.othername)) as optiontext FROM useraccount u WHERE u.id <> '' ".$custom_query." GROUP BY u.id ORDER BY optiontext ASC ".$limit_query;
		// debugMessage($valuesquery);
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# fetch all members with an email
	function getUsersWithEmail(){
		$companyid = getCompanyID();
		$custom_query = " AND u.companyid = '".$companyid."' ";
		$valuesquery = "SELECT u.id AS optionvalue, IF(isnull(u.othername), concat(u.firstname,' ',u.lastname,' [',u.email,']'), concat(u.firstname,' ',u.lastname,' ',u.othername,' <',u.email,'>')) as optiontext FROM useraccount u WHERE u.email <> '' ".$custom_query." ORDER BY optiontext ASC ";
		return getOptionValuesFromDatabaseQuery($valuesquery);
	}
	# fetch all members with a phone
	function getUsersWithPhone(){
		$companyid = getCompanyID();
		$custom_query = " AND u.companyid = '".$companyid."' ";
		$valuesquery = "SELECT u.id AS optionvalue, IF(isnull(u.othername), concat(u.firstname,' ',u.lastname,' [',u.phone,']'), concat(u.firstname,' ',u.lastname,' ',u.othername,' <',u.phone,'>')) as optiontext FROM useraccount u WHERE u.phone <> '' ".$custom_query." ORDER BY optiontext ASC ";
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
		$query = "SELECT u.id AS optionvalue, concat(u.firstname, ' ', u.lastname, ' ', u.othername) AS optiontext FROM useraccount as u WHERE u.id <> '' AND u.type = 2 ORDER BY optiontext";
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
		$companyid = getCompanyID();
		$company_query = "";
		if($lookuptypetext == 'EMPLOYEE_POSITIONS'){
			if($companyid == DEFAULT_COMPANYID){
				$company_query = " AND (l.companyid = '".$companyid."' OR l.companyid is null) ";
			} else {
				$company_query = " AND l.companyid = '".$companyid."' ";
			}
		}
		
		$query = "SELECT l.lookuptypevalue as optionvalue, trim(l.lookupvaluedescription) as optiontext FROM lookuptypevalue AS l INNER JOIN lookuptype AS v ON l.lookuptypeid = v.id WHERE v.name = '".$lookuptypetext."' ".$company_query." ";
		// debugMessage($query); // exit();
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
		$companyid = getCompanyID();
		if($companyid == DEFAULT_COMPANYID){
			$company_query = " AND (d.companyid = '".$companyid."' OR d.companyid is null) ";
		} else {
			$company_query = " AND (d.companyid = '".$companyid."') ";
		}
		
		$query = "SELECT d.id as optionvalue, d.name as optiontext FROM department d where d.id <> '' ".$company_query." order by optiontext ";
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
		$result = getCheckInEntry($userid, $date);
		if(!isEmptyString($result['timein']) && isEmptyString($result['timeout'])){
			return true;
		}
		return false;
	}
	# determine if user has checked in today
	function getCheckInEntry($userid, $date = ''){
		$where_query = "";
		if(!isEmptyString($date)){
			$where_query = " AND TO_DAYS(t.datein) = TO_DAYS('".$date."') ";
		}
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * FROM timesheet AS t where t.`userid` = '".$userid."' order by t.timesheetdate desc, t.id desc limit 1 ";  // debugMessage($query);
		$result = $conn->fetchRow($query); 
		if(!$result){
			$timesheet = new Timesheet();
			$result = $timesheet->toArray();
		}
		// debugMessage($result);
		return $result;
	}
	# determine payroll for month and year
	function getPayrolls($start, $end){
		$companyid = getCompanyID();
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * FROM payroll AS p where p.`companyid` = '".$companyid."' AND MONTH(p.startdate) = MONTH('".$start."') ";  // debugMessage($query);
		$result = $conn->fetchRow($query); 
		if(!$result){
			$payroll = new Payroll();
			$result = $payroll->toArray();
		}
		// debugMessage($result);
		return $result;
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
	function getBenefitStatuses($status = '') {
		$values = array('0'=>'Requested', '1'=>'Approved', '4'=>'Rejected');
		if(!isEmptyString($status)){
			return $values[$status];
		}
		return $values;
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
	function getBenefits($showall = 1, $value ='', $checkempty = false){
		$query = "SELECT b.id as optionvalue, b.name as optiontext FROM benefittype b where b.id <> '' order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		if($showall == 1){
			unset($array[1]); unset($array[NSSFID]); unset($array[PAYEID]); // unset($array[ADVANCE]);
 		}
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
		// $query = "SELECT COUNT(*) + (SELECT COUNT(*) FROM benefittype) FROM leavetype	 "; // debugMessage($query);
		$query = "SELECT COUNT(*) FROM benefittype"; // debugMessage($query);
		$result = $conn->fetchOne($query); // debugMessage($result);
		return $result;
	}
	# count number of leave benefits
	function countTimeBenefits(){
		$conn = Doctrine_Manager::connection();
		// $query = "SELECT COUNT(*) + (SELECT COUNT(*) FROM benefittype) FROM leavetype	 "; // debugMessage($query);
		$query = "SELECT COUNT(*) FROM leavetype"; // debugMessage($query);
		$result = $conn->fetchOne($query); // debugMessage($result);
		return $result;
	}
	# determine cash benefit terms
	function getAllBenefitTerms($value ='', $checkempty = false){
		$array =  array(1=>'Credit Salary', 2=>'Debit Salary');
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
	# determine payroll type for the employee
	function getPayrollTypes($value ='', $checkempty = false){
		$array =  array(1=>'Payable Daily', 2=>'Payable Weekly', 3=>'Payable Fortnightly', 4=>'Payable Monthly');
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
	# determine the leave types
	function getLeaveTypes($value ='', $checkempty = false){
		$query = "SELECT b.id as optionvalue, b.name as optiontext FROM leavetype b where b.id <> '' order by optiontext ";
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
	function getCompanies($status ='1'){
		$session = SessionWrapper::getInstance();
		$custom_query = "";
		if(!isEmptyString($status)){
			$custom_query .= " AND c.status = '".$status."' ";
		}
		$myquery = "";
		if($session->getVar('userid') != 81){
			$myquery = " AND c.createdby <> 81 ";
		}
		$query = "SELECT c.id as optionvalue, c.name as optiontext FROM company c where (c.id <> '' ".$myquery.") ".$custom_query." order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		return $array;
	}
	# fetch all benefits data. option for addition where cond
	function getAllLeaveDetails($customquery = ""){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * from leavetype where id <> '' ".$customquery." order by id ";   //debugMessage($query);
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
		$array =  array('1'=>'Cash Benefit', '2'=>'Leave Time');
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
	# determine leave status
	function getLeaveStatuses($value ='', $checkempty = false){
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
		$query = "SELECT sum(IF(lengthtype = 2, leavelength * lengthtype, leavelength)) FROM ledger where userid = '".$userid."' AND leaveid = '".$type."' AND TO_DAYS(trxndate) BETWEEN TO_DAYS('".$start."') AND TO_DAYS('".$end."') AND ledgertype = '2' AND trxntype = '1' AND status = 1 "; //debugMessage($query);
		$result = $conn->fetchOne($query); //debugMessage($result);
		
		$rquery = "SELECT IF(u.accrualtype = 2, u.accrualvalue * 8, u.accrualvalue) FROM userbenefit u where u.userid = '".$userid."' AND u.type = 2 AND u.leavetypeid = '".$type."' AND u.accrualfrequency = '1' "; // debugMessage($rquery);
		$rresult = $conn->fetchOne($rquery);
		
		return formatNumber($result+$rresult);
	}
	# determine the number of hours taken in the current financial period
	function getHoursTaken($userid, $type=1, $start ='2015-01-01', $end='2015-12-31'){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT sum(duration) FROM `leave` where userid = '".$userid."' AND typeid = '".$type."' AND TO_DAYS(startdate) BETWEEN TO_DAYS('".$start."') AND TO_DAYS('".$end."') AND TO_DAYS(enddate) < TO_DAYS('".$end."') AND status = '4' "; //debugMessage($query);
		$result = $conn->fetchOne($query); //debugMessage($result);
		return formatNumber($result);
	}
	# determine number of hours available in the current financial period
	function getHoursAvailable($userid, $type=1, $start ='2015-01-01', $end='2015-12-31'){
		$accrued = getHoursAccrued($userid, $type, $start, $end); //debugMessage($accrued);
		$taken = getHoursTaken($userid, $type, $start, $end); //debugMessage($taken);
		$available = $accrued - $taken; // debugMessage($available);
		return $available < 0 ? 0 : formatNumber($available);
	}
	# fetch all leave requests for a user 
	function getLeaveRequests($userid ='', $start ='2015-01-01', $end='2015-12-31'){
		$conn = Doctrine_Manager::connection();
		$customquery = "";
		/*if(!isEmptyString($userid)){
			$customquery = " AND t.userid = '".$userid."' ";
		}*/
		$companyid = getCompanyID();
		
		$query = "SELECT t.id, t.userid, t.typeid, p.name as type, t.`status`, t.duration, t.durationtype, t.startdate as startdate, t.enddate as enddate, t.returndate, t.starttime, t.endtime, t.returntime, p.calendarcolor, 
		IF(isnull(u.othername), concat(u.firstname,' ',u.lastname), concat(u.firstname,' ',u.lastname,' ',u.othername)) as `user`
		from `leave` t 
		inner join leavetype p on t.typeid = p.id
		inner join useraccount u on t.userid = u.id
		where t.id <> '' ".$customquery." AND u.companyid = '".$companyid."' AND TO_DAYS(t.startdate) BETWEEN TO_DAYS('".$start."') AND TO_DAYS('".$end."') AND t.status = 1 order by t.startdate desc, t.id ";  // debugMessage($query);
		$result = $conn->fetchAll($query); // debugMessage($result);
	
		return $result;
	}
	function getDefaultThemeOptions($id = '1', $defaultcompanydata = array()){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT  c.layout, c.topbar, c.sidebar, c.colortheme, c.showsidebar from company c where c.id = '".$id."' ";
		$result = $conn->fetchRow($query); // debugMessage($query); debugMessage($result);
		if(isEmptyString($result['layout'])){
			$result['layout'] = !isArrayKeyAnEmptyString('layout', $defaultcompanydata) ? $defaultcompanydata['layout'] : getDefaultLayout();
		}
		if(isEmptyString($result['topbar'])){
			$result['topbar'] = !isArrayKeyAnEmptyString('topbar', $defaultcompanydata) ? $defaultcompanydata['topbar'] : getDefaultTopBar();
		}
		if(isEmptyString($result['sidebar'])){
			$result['sidebar'] = !isArrayKeyAnEmptyString('sidebar', $defaultcompanydata) ? $defaultcompanydata['sidebar'] : getDefaultSideBar();
		}
		if(isEmptyString($result['colortheme'])){
			$result['colortheme'] = !isArrayKeyAnEmptyString('colortheme', $defaultcompanydata) ? $defaultcompanydata['colortheme'] : getDefaultTheme();
		}
		if(isEmptyString($result['showsidebar'])){
			$result['showsidebar'] = !isArrayKeyAnEmptyString('showsidebar', $defaultcompanydata) ? $defaultcompanydata['showsidebar'] : getDefaultShowSideBar();
		}
		return $result;
	}
	# get the theme colors 
	function getAllThemeColors(){
		$colors = array(
			"red" => "#e51400",
			"orange" => "#f8a31f",
			"green" => "#339933",
			"brown" => "#a05000",
			"blue" => "#368ee0",
			"lime" => "#8cbf26",
			"teal" => "#00aba9",
			"purple" => "#ff0097",
			"pink" => "#6e2049",
			"magenta" => "#a200ff;",
			"grey" => "#333333",
			"darkblue" => "#204e81",
			"lightred" => "#e63a3a",
			"lightgrey" => "#e63a3a",
			"satblue" => "#2c5e7b",
			"satgreen" => "#56af45"
		);
		return $colors;
	}
	# determine payroll reports 
	function getPayrollReports($value ='', $checkempty = false){
		$query = "SELECT p.id as optionvalue, concat('Payroll (', DATE_FORMAT(p.startdate, '%b %D'), ' - ', DATE_FORMAT(p.enddate, '%b %D'),')') as optiontext FROM payroll p where p.status = 2 order by optiontext ";
		$array = getOptionValuesFromDatabaseQuery($query);
		return $array;
	}
	# attendance configuration options
	function getAttendanceTypes($value ='', $checkempty = false){
		$array =  array(
					'0'=>'Employee does not submit timesheets',
					'1' => 'Employee submits timesheets and is paid hourly',
					'2' => 'Employee submits timesheets but is paid monthly'
				);
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
	# the status values for companies
	function getCompanyStatuses(){
		return array('1','Active',0=>'Inactive','2'=>'Pending Approval','3'=>'Rejected');
	}
	# determine country timezones
	function getAllTimezones(){
		$timezones = array (
			'America/Atka' => '(GMT-10:00) America/Atka (Hawaii-Aleutian Standard Time)',
			'America/Anchorage' => '(GMT-9:00) America/Anchorage (Alaska Standard Time)',
			'America/Juneau' => '(GMT-9:00) America/Juneau (Alaska Standard Time)',
			'America/Nome' => '(GMT-9:00) America/Nome (Alaska Standard Time)',
			'America/Yakutat' => '(GMT-9:00) America/Yakutat (Alaska Standard Time)',
			'America/Dawson' => '(GMT-8:00) America/Dawson (Pacific Standard Time)',
			'America/Ensenada' => '(GMT-8:00) America/Ensenada (Pacific Standard Time)',
			'America/Los_Angeles' => '(GMT-8:00) America/Los_Angeles (Pacific Standard Time)',
			'America/Tijuana' => '(GMT-8:00) America/Tijuana (Pacific Standard Time)',
			'America/Vancouver' => '(GMT-8:00) America/Vancouver (Pacific Standard Time)',
			'America/Whitehorse' => '(GMT-8:00) America/Whitehorse (Pacific Standard Time)',
			'Canada/Pacific' => '(GMT-8:00) Canada/Pacific (Pacific Standard Time)',
			'Canada/Yukon' => '(GMT-8:00) Canada/Yukon (Pacific Standard Time)',
			'Mexico/BajaNorte' => '(GMT-8:00) Mexico/BajaNorte (Pacific Standard Time)',
			'America/Boise' => '(GMT-7:00) America/Boise (Mountain Standard Time)',
			'America/Cambridge_Bay' => '(GMT-7:00) America/Cambridge_Bay (Mountain Standard Time)',
			'America/Chihuahua' => '(GMT-7:00) America/Chihuahua (Mountain Standard Time)',
			'America/Dawson_Creek' => '(GMT-7:00) America/Dawson_Creek (Mountain Standard Time)',
			'America/Denver' => '(GMT-7:00) America/Denver (Mountain Standard Time)',
			'America/Edmonton' => '(GMT-7:00) America/Edmonton (Mountain Standard Time)',
			'America/Hermosillo' => '(GMT-7:00) America/Hermosillo (Mountain Standard Time)',
			'America/Inuvik' => '(GMT-7:00) America/Inuvik (Mountain Standard Time)',
			'America/Mazatlan' => '(GMT-7:00) America/Mazatlan (Mountain Standard Time)',
			'America/Phoenix' => '(GMT-7:00) America/Phoenix (Mountain Standard Time)',
			'America/Shiprock' => '(GMT-7:00) America/Shiprock (Mountain Standard Time)',
			'America/Yellowknife' => '(GMT-7:00) America/Yellowknife (Mountain Standard Time)',
			'Canada/Mountain' => '(GMT-7:00) Canada/Mountain (Mountain Standard Time)',
			'Mexico/BajaSur' => '(GMT-7:00) Mexico/BajaSur (Mountain Standard Time)',
			'America/Belize' => '(GMT-6:00) America/Belize (Central Standard Time)',
			'America/Cancun' => '(GMT-6:00) America/Cancun (Central Standard Time)',
			'America/Chicago' => '(GMT-6:00) America/Chicago (Central Standard Time)',
			'America/Costa_Rica' => '(GMT-6:00) America/Costa_Rica (Central Standard Time)',
			'America/El_Salvador' => '(GMT-6:00) America/El_Salvador (Central Standard Time)',
			'America/Guatemala' => '(GMT-6:00) America/Guatemala (Central Standard Time)',
			'America/Knox_IN' => '(GMT-6:00) America/Knox_IN (Central Standard Time)',
			'America/Managua' => '(GMT-6:00) America/Managua (Central Standard Time)',
			'America/Menominee' => '(GMT-6:00) America/Menominee (Central Standard Time)',
			'America/Merida' => '(GMT-6:00) America/Merida (Central Standard Time)',
			'America/Mexico_City' => '(GMT-6:00) America/Mexico_City (Central Standard Time)',
			'America/Monterrey' => '(GMT-6:00) America/Monterrey (Central Standard Time)',
			'America/Rainy_River' => '(GMT-6:00) America/Rainy_River (Central Standard Time)',
			'America/Rankin_Inlet' => '(GMT-6:00) America/Rankin_Inlet (Central Standard Time)',
			'America/Regina' => '(GMT-6:00) America/Regina (Central Standard Time)',
			'America/Swift_Current' => '(GMT-6:00) America/Swift_Current (Central Standard Time)',
			'America/Tegucigalpa' => '(GMT-6:00) America/Tegucigalpa (Central Standard Time)',
			'America/Winnipeg' => '(GMT-6:00) America/Winnipeg (Central Standard Time)',
			'Canada/Central' => '(GMT-6:00) Canada/Central (Central Standard Time)',
			'Canada/East-Saskatchewan' => '(GMT-6:00) Canada/East-Saskatchewan (Central Standard Time)',
			'Canada/Saskatchewan' => '(GMT-6:00) Canada/Saskatchewan (Central Standard Time)',
			'Chile/EasterIsland' => '(GMT-6:00) Chile/EasterIsland (Easter Is. Time)',
			'Mexico/General' => '(GMT-6:00) Mexico/General (Central Standard Time)',
			'America/Atikokan' => '(GMT-5:00) America/Atikokan (Eastern Standard Time)',
			'America/Bogota' => '(GMT-5:00) America/Bogota (Colombia Time)',
			'America/Cayman' => '(GMT-5:00) America/Cayman (Eastern Standard Time)',
			'America/Coral_Harbour' => '(GMT-5:00) America/Coral_Harbour (Eastern Standard Time)',
			'America/Detroit' => '(GMT-5:00) America/Detroit (Eastern Standard Time)',
			'America/Fort_Wayne' => '(GMT-5:00) America/Fort_Wayne (Eastern Standard Time)',
			'America/Grand_Turk' => '(GMT-5:00) America/Grand_Turk (Eastern Standard Time)',
			'America/Guayaquil' => '(GMT-5:00) America/Guayaquil (Ecuador Time)',
			'America/Havana' => '(GMT-5:00) America/Havana (Cuba Standard Time)',
			'America/Indianapolis' => '(GMT-5:00) America/Indianapolis (Eastern Standard Time)',
			'America/Iqaluit' => '(GMT-5:00) America/Iqaluit (Eastern Standard Time)',
			'America/Jamaica' => '(GMT-5:00) America/Jamaica (Eastern Standard Time)',
			'America/Lima' => '(GMT-5:00) America/Lima (Peru Time)',
			'America/Louisville' => '(GMT-5:00) America/Louisville (Eastern Standard Time)',
			'America/Montreal' => '(GMT-5:00) America/Montreal (Eastern Standard Time)',
			'America/Nassau' => '(GMT-5:00) America/Nassau (Eastern Standard Time)',
			'America/New_York' => '(GMT-5:00) America/New_York (Eastern Standard Time)',
			'America/Nipigon' => '(GMT-5:00) America/Nipigon (Eastern Standard Time)',
			'America/Panama' => '(GMT-5:00) America/Panama (Eastern Standard Time)',
			'America/Pangnirtung' => '(GMT-5:00) America/Pangnirtung (Eastern Standard Time)',
			'America/Port-au-Prince' => '(GMT-5:00) America/Port-au-Prince (Eastern Standard Time)',
			'America/Resolute' => '(GMT-5:00) America/Resolute (Eastern Standard Time)',
			'America/Thunder_Bay' => '(GMT-5:00) America/Thunder_Bay (Eastern Standard Time)',
			'America/Toronto' => '(GMT-5:00) America/Toronto (Eastern Standard Time)',
			'Canada/Eastern' => '(GMT-5:00) Canada/Eastern (Eastern Standard Time)',
			'America/Caracas' => '(GMT-4:-30) America/Caracas (Venezuela Time)',
			'America/Anguilla' => '(GMT-4:00) America/Anguilla (Atlantic Standard Time)',
			'America/Antigua' => '(GMT-4:00) America/Antigua (Atlantic Standard Time)',
			'America/Aruba' => '(GMT-4:00) America/Aruba (Atlantic Standard Time)',
			'America/Asuncion' => '(GMT-4:00) America/Asuncion (Paraguay Time)',
			'America/Barbados' => '(GMT-4:00) America/Barbados (Atlantic Standard Time)',
			'America/Blanc-Sablon' => '(GMT-4:00) America/Blanc-Sablon (Atlantic Standard Time)',
			'America/Boa_Vista' => '(GMT-4:00) America/Boa_Vista (Amazon Time)',
			'America/Campo_Grande' => '(GMT-4:00) America/Campo_Grande (Amazon Time)',
			'America/Cuiaba' => '(GMT-4:00) America/Cuiaba (Amazon Time)',
			'America/Curacao' => '(GMT-4:00) America/Curacao (Atlantic Standard Time)',
			'America/Dominica' => '(GMT-4:00) America/Dominica (Atlantic Standard Time)',
			'America/Eirunepe' => '(GMT-4:00) America/Eirunepe (Amazon Time)',
			'America/Glace_Bay' => '(GMT-4:00) America/Glace_Bay (Atlantic Standard Time)',
			'America/Goose_Bay' => '(GMT-4:00) America/Goose_Bay (Atlantic Standard Time)',
			'America/Grenada' => '(GMT-4:00) America/Grenada (Atlantic Standard Time)',
			'America/Guadeloupe' => '(GMT-4:00) America/Guadeloupe (Atlantic Standard Time)',
			'America/Guyana' => '(GMT-4:00) America/Guyana (Guyana Time)',
			'America/Halifax' => '(GMT-4:00) America/Halifax (Atlantic Standard Time)',
			'America/La_Paz' => '(GMT-4:00) America/La_Paz (Bolivia Time)',
			'America/Manaus' => '(GMT-4:00) America/Manaus (Amazon Time)',
			'America/Marigot' => '(GMT-4:00) America/Marigot (Atlantic Standard Time)',
			
			'America/Martinique' => '(GMT-4:00) America/Martinique (Atlantic Standard Time)',
			'America/Moncton' => '(GMT-4:00) America/Moncton (Atlantic Standard Time)',
			'America/Montserrat' => '(GMT-4:00) America/Montserrat (Atlantic Standard Time)',
			'America/Port_of_Spain' => '(GMT-4:00) America/Port_of_Spain (Atlantic Standard Time)',
			'America/Porto_Acre' => '(GMT-4:00) America/Porto_Acre (Amazon Time)',
			'America/Porto_Velho' => '(GMT-4:00) America/Porto_Velho (Amazon Time)',
			'America/Puerto_Rico' => '(GMT-4:00) America/Puerto_Rico (Atlantic Standard Time)',
			'America/Rio_Branco' => '(GMT-4:00) America/Rio_Branco (Amazon Time)',
			'America/Santiago' => '(GMT-4:00) America/Santiago (Chile Time)',
			'America/Santo_Domingo' => '(GMT-4:00) America/Santo_Domingo (Atlantic Standard Time)',
			'America/St_Barthelemy' => '(GMT-4:00) America/St_Barthelemy (Atlantic Standard Time)',
			'America/St_Kitts' => '(GMT-4:00) America/St_Kitts (Atlantic Standard Time)',
			'America/St_Lucia' => '(GMT-4:00) America/St_Lucia (Atlantic Standard Time)',
			'America/St_Thomas' => '(GMT-4:00) America/St_Thomas (Atlantic Standard Time)',
			'America/St_Vincent' => '(GMT-4:00) America/St_Vincent (Atlantic Standard Time)',
			'America/Thule' => '(GMT-4:00) America/Thule (Atlantic Standard Time)',
			'America/Tortola' => '(GMT-4:00) America/Tortola (Atlantic Standard Time)',
			'America/Virgin' => '(GMT-4:00) America/Virgin (Atlantic Standard Time)',
			'Antarctica/Palmer' => '(GMT-4:00) Antarctica/Palmer (Chile Time)',
			'Atlantic/Bermuda' => '(GMT-4:00) Atlantic/Bermuda (Atlantic Standard Time)',
			'Atlantic/Stanley' => '(GMT-4:00) Atlantic/Stanley (Falkland Is. Time)',
			'Brazil/Acre' => '(GMT-4:00) Brazil/Acre (Amazon Time)',
			'Brazil/West' => '(GMT-4:00) Brazil/West (Amazon Time)',
			'Canada/Atlantic' => '(GMT-4:00) Canada/Atlantic (Atlantic Standard Time)',
			'Chile/Continental' => '(GMT-4:00) Chile/Continental (Chile Time)',
			'America/St_Johns' => '(GMT-3:-30) America/St_Johns (Newfoundland Standard Time)',
			
			'America/St_Johns' => '(GMT-3:-30) America/St_Johns (Newfoundland Standard Time)',
			'Canada/Newfoundland' => '(GMT-3:-30) Canada/Newfoundland (Newfoundland Standard Time)',
			'America/Araguaina' => '(GMT-3:00) America/Araguaina (Brasilia Time)',
			'America/Bahia' => '(GMT-3:00) America/Bahia (Brasilia Time)',
			'America/Belem' => '(GMT-3:00) America/Belem (Brasilia Time)',
			'America/Buenos_Aires' => '(GMT-3:00) America/Buenos_Aires (Argentine Time)',
			'America/Catamarca' => '(GMT-3:00) America/Catamarca (Argentine Time)',
			'America/Cayenne' => '(GMT-3:00) America/Cayenne (French Guiana Time)',
			'America/Cordoba' => '(GMT-3:00) America/Cordoba (Argentine Time)',
			'America/Fortaleza' => '(GMT-3:00) America/Fortaleza (Brasilia Time)',
			'America/Godthab' => '(GMT-3:00) America/Godthab (Western Greenland Time)',
			'America/Jujuy' => '(GMT-3:00) America/Jujuy (Argentine Time)',
			'America/Maceio' => '(GMT-3:00) America/Maceio (Brasilia Time)',
			'America/Mendoza' => '(GMT-3:00) America/Mendoza (Argentine Time)',
			'America/Miquelon' => '(GMT-3:00) America/Miquelon (Pierre & Miquelon Standard Time)',
			'America/Montevideo' => '(GMT-3:00) America/Montevideo (Uruguay Time)',
			'America/Paramaribo' => '(GMT-3:00) America/Paramaribo (Suriname Time)',
			'America/Recife' => '(GMT-3:00) America/Recife (Brasilia Time)',
			'America/Rosario' => '(GMT-3:00) America/Rosario (Argentine Time)',
			'America/Santarem' => '(GMT-3:00) America/Santarem (Brasilia Time)',
			'America/Sao_Paulo' => '(GMT-3:00) America/Sao_Paulo (Brasilia Time)',
			'Antarctica/Rothera' => '(GMT-3:00) Antarctica/Rothera (Rothera Time)',
			'Brazil/East' => '(GMT-3:00) Brazil/East (Brasilia Time)',
			'America/Noronha' => '(GMT-2:00) America/Noronha (Fernando de Noronha Time)',
			'Atlantic/South_Georgia' => '(GMT-2:00) Atlantic/South_Georgia (South Georgia Standard Time)',
			
			'Brazil/DeNoronha' => '(GMT-2:00) Brazil/DeNoronha (Fernando de Noronha Time)',
			'America/Scoresbysund' => '(GMT-1:00) America/Scoresbysund (Eastern Greenland Time)',
			'Atlantic/Azores' => '(GMT-1:00) Atlantic/Azores (Azores Time)',
			'Atlantic/Cape_Verde' => '(GMT-1:00) Atlantic/Cape_Verde (Cape Verde Time)',
			'Africa/Abidjan' => '(GMT+0:00) Africa/Abidjan (Greenwich Mean Time)',
			'Africa/Accra' => '(GMT+0:00) Africa/Accra (Ghana Mean Time)',
			'Africa/Bamako' => '(GMT+0:00) Africa/Bamako (Greenwich Mean Time)',
			'Africa/Banjul' => '(GMT+0:00) Africa/Banjul (Greenwich Mean Time)',
			'Africa/Bissau' => '(GMT+0:00) Africa/Bissau (Greenwich Mean Time)',
			'Africa/Casablanca' => '(GMT+0:00) Africa/Casablanca (Western European Time)',
			'Africa/Conakry' => '(GMT+0:00) Africa/Conakry (Greenwich Mean Time)',
			'Africa/Dakar' => '(GMT+0:00) Africa/Dakar (Greenwich Mean Time)',
			'Africa/El_Aaiun' => '(GMT+0:00) Africa/El_Aaiun (Western European Time)',
			'Africa/Freetown' => '(GMT+0:00) Africa/Freetown (Greenwich Mean Time)',
			'Africa/Lome' => '(GMT+0:00) Africa/Lome (Greenwich Mean Time)',
			'Africa/Monrovia' => '(GMT+0:00) Africa/Monrovia (Greenwich Mean Time)',
			'Africa/Nouakchott' => '(GMT+0:00) Africa/Nouakchott (Greenwich Mean Time)',
			'Africa/Ouagadougou' => '(GMT+0:00) Africa/Ouagadougou (Greenwich Mean Time)',
			'Africa/Sao_Tome' => '(GMT+0:00) Africa/Sao_Tome (Greenwich Mean Time)',
			'Africa/Timbuktu' => '(GMT+0:00) Africa/Timbuktu (Greenwich Mean Time)',
			'America/Danmarkshavn' => '(GMT+0:00) America/Danmarkshavn (Greenwich Mean Time)',
			'Atlantic/Canary' => '(GMT+0:00) Atlantic/Canary (Western European Time)',
			'Atlantic/Faeroe' => '(GMT+0:00) Atlantic/Faeroe (Western European Time)',
			'Atlantic/Faroe' => '(GMT+0:00) Atlantic/Faroe (Western European Time)',
			'Atlantic/Madeira' => '(GMT+0:00) Atlantic/Madeira (Western European Time)',
			'Atlantic/Reykjavik' => '(GMT+0:00) Atlantic/Reykjavik (Greenwich Mean Time)',
			'Atlantic/St_Helena' => '(GMT+0:00) Atlantic/St_Helena (Greenwich Mean Time)',
			'Europe/Belfast' => '(GMT+0:00) Europe/Belfast (Greenwich Mean Time)',
			'Europe/Dublin' => '(GMT+0:00) Europe/Dublin (Greenwich Mean Time)',
			'Europe/Guernsey' => '(GMT+0:00) Europe/Guernsey (Greenwich Mean Time)',
			'Europe/Isle_of_Man' => '(GMT+0:00) Europe/Isle_of_Man (Greenwich Mean Time)',
			'Europe/Jersey' => '(GMT+0:00) Europe/Jersey (Greenwich Mean Time)',
			'Europe/Lisbon' => '(GMT+0:00) Europe/Lisbon (Western European Time)',
			'Europe/London' => '(GMT+0:00) Europe/London (Greenwich Mean Time)',
			'Africa/Algiers' => '(GMT+1:00) Africa/Algiers (Central European Time)',
			'Africa/Bangui' => '(GMT+1:00) Africa/Bangui (Western African Time)',
			'Africa/Brazzaville' => '(GMT+1:00) Africa/Brazzaville (Western African Time)',
			'Africa/Ceuta' => '(GMT+1:00) Africa/Ceuta (Central European Time)',
			'Africa/Douala' => '(GMT+1:00) Africa/Douala (Western African Time)',
			'Africa/Kinshasa' => '(GMT+1:00) Africa/Kinshasa (Western African Time)',
			'Africa/Lagos' => '(GMT+1:00) Africa/Lagos (Western African Time)',
			'Africa/Libreville' => '(GMT+1:00) Africa/Libreville (Western African Time)',
			'Africa/Luanda' => '(GMT+1:00) Africa/Luanda (Western African Time)',
			'Africa/Malabo' => '(GMT+1:00) Africa/Malabo (Western African Time)',
			'Africa/Ndjamena' => '(GMT+1:00) Africa/Ndjamena (Western African Time)',
			'Africa/Niamey' => '(GMT+1:00) Africa/Niamey (Western African Time)',
			'Africa/Porto-Novo' => '(GMT+1:00) Africa/Porto-Novo (Western African Time)',
			'Africa/Tunis' => '(GMT+1:00) Africa/Tunis (Central European Time)',
			'Africa/Windhoek' => '(GMT+1:00) Africa/Windhoek (Western African Time)',
			'Arctic/Longyearbyen' => '(GMT+1:00) Arctic/Longyearbyen (Central European Time)',
			
			'Atlantic/Jan_Mayen' => '(GMT+1:00) Atlantic/Jan_Mayen (Central European Time)',
			'Europe/Amsterdam' => '(GMT+1:00) Europe/Amsterdam (Central European Time)',
			'Europe/Andorra' => '(GMT+1:00) Europe/Andorra (Central European Time)',
			'Europe/Belgrade' => '(GMT+1:00) Europe/Belgrade (Central European Time)',
			'Europe/Berlin' => '(GMT+1:00) Europe/Berlin (Central European Time)',
			'Europe/Bratislava' => '(GMT+1:00) Europe/Bratislava (Central European Time)',
			'Europe/Brussels' => '(GMT+1:00) Europe/Brussels (Central European Time)',
			'Europe/Budapest' => '(GMT+1:00) Europe/Budapest (Central European Time)',
			'Europe/Copenhagen' => '(GMT+1:00) Europe/Copenhagen (Central European Time)',
			'Europe/Gibraltar' => '(GMT+1:00) Europe/Gibraltar (Central European Time)',
			'Europe/Ljubljana' => '(GMT+1:00) Europe/Ljubljana (Central European Time)',
			'Europe/Luxembourg' => '(GMT+1:00) Europe/Luxembourg (Central European Time)',
			'Europe/Madrid' => '(GMT+1:00) Europe/Madrid (Central European Time)',
			'Europe/Malta' => '(GMT+1:00) Europe/Malta (Central European Time)',
			'Europe/Monaco' => '(GMT+1:00) Europe/Monaco (Central European Time)',
			'Europe/Oslo' => '(GMT+1:00) Europe/Oslo (Central European Time)',
			'Europe/Paris' => '(GMT+1:00) Europe/Paris (Central European Time)',
			'Europe/Podgorica' => '(GMT+1:00) Europe/Podgorica (Central European Time)',
			'Europe/Prague' => '(GMT+1:00) Europe/Prague (Central European Time)',
			'Europe/Rome' => '(GMT+1:00) Europe/Rome (Central European Time)',
			'Europe/San_Marino' => '(GMT+1:00) Europe/San_Marino (Central European Time)',
			'Europe/Sarajevo' => '(GMT+1:00) Europe/Sarajevo (Central European Time)',
			'Europe/Skopje' => '(GMT+1:00) Europe/Skopje (Central European Time)',
			'Europe/Stockholm' => '(GMT+1:00) Europe/Stockholm (Central European Time)',
			'Europe/Tirane' => '(GMT+1:00) Europe/Tirane (Central European Time)',
			'Europe/Vaduz' => '(GMT+1:00) Europe/Vaduz (Central European Time)',
			'Europe/Vatican' => '(GMT+1:00) Europe/Vatican (Central European Time)',
			'Europe/Vienna' => '(GMT+1:00) Europe/Vienna (Central European Time)',
			'Europe/Warsaw' => '(GMT+1:00) Europe/Warsaw (Central European Time)',
			'Europe/Zagreb' => '(GMT+1:00) Europe/Zagreb (Central European Time)',
			'Europe/Zurich' => '(GMT+1:00) Europe/Zurich (Central European Time)',
			'Africa/Blantyre' => '(GMT+2:00) Africa/Blantyre (Central African Time)',
			'Africa/Bujumbura' => '(GMT+2:00) Africa/Bujumbura (Central African Time)',
			'Africa/Cairo' => '(GMT+2:00) Africa/Cairo (Eastern European Time)',
			'Africa/Gaborone' => '(GMT+2:00) Africa/Gaborone (Central African Time)',
			'Africa/Harare' => '(GMT+2:00) Africa/Harare (Central African Time)',
			'Africa/Johannesburg' => '(GMT+2:00) Africa/Johannesburg (South Africa Standard Time)',
			'Africa/Kigali' => '(GMT+2:00) Africa/Kigali (Central African Time)',
			'Africa/Lubumbashi' => '(GMT+2:00) Africa/Lubumbashi (Central African Time)',
			'Africa/Lusaka' => '(GMT+2:00) Africa/Lusaka (Central African Time)',
			'Africa/Maputo' => '(GMT+2:00) Africa/Maputo (Central African Time)',
			'Africa/Maseru' => '(GMT+2:00) Africa/Maseru (South Africa Standard Time)',
			'Africa/Mbabane' => '(GMT+2:00) Africa/Mbabane (South Africa Standard Time)',
			'Africa/Tripoli' => '(GMT+2:00) Africa/Tripoli (Eastern European Time)',
			'Asia/Amman' => '(GMT+2:00) Asia/Amman (Eastern European Time)',
			'Asia/Beirut' => '(GMT+2:00) Asia/Beirut (Eastern European Time)',
			'Asia/Damascus' => '(GMT+2:00) Asia/Damascus (Eastern European Time)',
			'Asia/Gaza' => '(GMT+2:00) Asia/Gaza (Eastern European Time)',
			'Asia/Istanbul' => '(GMT+2:00) Asia/Istanbul (Eastern European Time)',
			'Asia/Jerusalem' => '(GMT+2:00) Asia/Jerusalem (Israel Standard Time)',
			
			'Asia/Nicosia' => '(GMT+2:00) Asia/Nicosia (Eastern European Time)',
			'Asia/Tel_Aviv' => '(GMT+2:00) Asia/Tel_Aviv (Israel Standard Time)',
			'Europe/Athens' => '(GMT+2:00) Europe/Athens (Eastern European Time)',
			'Europe/Bucharest' => '(GMT+2:00) Europe/Bucharest (Eastern European Time)',
			'Europe/Chisinau' => '(GMT+2:00) Europe/Chisinau (Eastern European Time)',
			'Europe/Helsinki' => '(GMT+2:00) Europe/Helsinki (Eastern European Time)',
			'Europe/Istanbul' => '(GMT+2:00) Europe/Istanbul (Eastern European Time)',
			'Europe/Kaliningrad' => '(GMT+2:00) Europe/Kaliningrad (Eastern European Time)',
			'Europe/Kiev' => '(GMT+2:00) Europe/Kiev (Eastern European Time)',
			'Europe/Mariehamn' => '(GMT+2:00) Europe/Mariehamn (Eastern European Time)',
			'Europe/Minsk' => '(GMT+2:00) Europe/Minsk (Eastern European Time)',
			'Europe/Nicosia' => '(GMT+2:00) Europe/Nicosia (Eastern European Time)',
			'Europe/Riga' => '(GMT+2:00) Europe/Riga (Eastern European Time)',
			'Europe/Simferopol' => '(GMT+2:00) Europe/Simferopol (Eastern European Time)',
			'Europe/Sofia' => '(GMT+2:00) Europe/Sofia (Eastern European Time)',
			'Europe/Tallinn' => '(GMT+2:00) Europe/Tallinn (Eastern European Time)',
			'Europe/Tiraspol' => '(GMT+2:00) Europe/Tiraspol (Eastern European Time)',
			'Europe/Uzhgorod' => '(GMT+2:00) Europe/Uzhgorod (Eastern European Time)',
			'Europe/Vilnius' => '(GMT+2:00) Europe/Vilnius (Eastern European Time)',
			'Europe/Zaporozhye' => '(GMT+2:00) Europe/Zaporozhye (Eastern European Time)',
			'Africa/Addis_Ababa' => '(GMT+3:00) Africa/Addis_Ababa (Eastern African Time)',
			'Africa/Asmara' => '(GMT+3:00) Africa/Asmara (Eastern African Time)',
			'Africa/Asmera' => '(GMT+3:00) Africa/Asmera (Eastern African Time)',
			'Africa/Dar_es_Salaam' => '(GMT+3:00) Africa/Dar_es_Salaam (Eastern African Time)',
			'Africa/Djibouti' => '(GMT+3:00) Africa/Djibouti (Eastern African Time)',
			'Africa/Kampala' => '(GMT+3:00) Africa/Kampala (Eastern African Time)',
			'Africa/Khartoum' => '(GMT+3:00) Africa/Khartoum (Eastern African Time)',
			'Africa/Mogadishu' => '(GMT+3:00) Africa/Mogadishu (Eastern African Time)',
			'Africa/Nairobi' => '(GMT+3:00) Africa/Nairobi (Eastern African Time)',
			'Antarctica/Syowa' => '(GMT+3:00) Antarctica/Syowa (Syowa Time)',
			'Asia/Aden' => '(GMT+3:00) Asia/Aden (Arabia Standard Time)',
			'Asia/Baghdad' => '(GMT+3:00) Asia/Baghdad (Arabia Standard Time)',
			'Asia/Bahrain' => '(GMT+3:00) Asia/Bahrain (Arabia Standard Time)',
			'Asia/Kuwait' => '(GMT+3:00) Asia/Kuwait (Arabia Standard Time)',
			'Asia/Qatar' => '(GMT+3:00) Asia/Qatar (Arabia Standard Time)',
			'Europe/Moscow' => '(GMT+3:00) Europe/Moscow (Moscow Standard Time)',
			'Europe/Volgograd' => '(GMT+3:00) Europe/Volgograd (Volgograd Time)',
			'Indian/Antananarivo' => '(GMT+3:00) Indian/Antananarivo (Eastern African Time)',
			'Indian/Comoro' => '(GMT+3:00) Indian/Comoro (Eastern African Time)',
			'Indian/Mayotte' => '(GMT+3:00) Indian/Mayotte (Eastern African Time)',
			'Asia/Tehran' => '(GMT+3:30) Asia/Tehran (Iran Standard Time)',
			'Asia/Baku' => '(GMT+4:00) Asia/Baku (Azerbaijan Time)',
			'Asia/Dubai' => '(GMT+4:00) Asia/Dubai (Gulf Standard Time)',
			'Asia/Muscat' => '(GMT+4:00) Asia/Muscat (Gulf Standard Time)',
			'Asia/Tbilisi' => '(GMT+4:00) Asia/Tbilisi (Georgia Time)',
			'Asia/Yerevan' => '(GMT+4:00) Asia/Yerevan (Armenia Time)',
			'Europe/Samara' => '(GMT+4:00) Europe/Samara (Samara Time)',
			'Indian/Mahe' => '(GMT+4:00) Indian/Mahe (Seychelles Time)',
			'Indian/Mauritius' => '(GMT+4:00) Indian/Mauritius (Mauritius Time)',
			'Indian/Reunion' => '(GMT+4:00) Indian/Reunion (Reunion Time)',
			
			'Asia/Kabul' => '(GMT+4:30) Asia/Kabul (Afghanistan Time)',
			'Asia/Aqtau' => '(GMT+5:00) Asia/Aqtau (Aqtau Time)',
			'Asia/Aqtobe' => '(GMT+5:00) Asia/Aqtobe (Aqtobe Time)',
			'Asia/Ashgabat' => '(GMT+5:00) Asia/Ashgabat (Turkmenistan Time)',
			'Asia/Ashkhabad' => '(GMT+5:00) Asia/Ashkhabad (Turkmenistan Time)',
			'Asia/Dushanbe' => '(GMT+5:00) Asia/Dushanbe (Tajikistan Time)',
			'Asia/Karachi' => '(GMT+5:00) Asia/Karachi (Pakistan Time)',
			'Asia/Oral' => '(GMT+5:00) Asia/Oral (Oral Time)',
			'Asia/Samarkand' => '(GMT+5:00) Asia/Samarkand (Uzbekistan Time)',
			'Asia/Tashkent' => '(GMT+5:00) Asia/Tashkent (Uzbekistan Time)',
			'Asia/Yekaterinburg' => '(GMT+5:00) Asia/Yekaterinburg (Yekaterinburg Time)',
			'Indian/Kerguelen' => '(GMT+5:00) Indian/Kerguelen (French Southern & Antarctic Lands Time)',
			'Indian/Maldives' => '(GMT+5:00) Indian/Maldives (Maldives Time)',
			'Asia/Calcutta' => '(GMT+5:30) Asia/Calcutta (India Standard Time)',
			'Asia/Colombo' => '(GMT+5:30) Asia/Colombo (India Standard Time)',
			'Asia/Kolkata' => '(GMT+5:30) Asia/Kolkata (India Standard Time)',
			'Asia/Katmandu' => '(GMT+5:45) Asia/Katmandu (Nepal Time)',
			'Antarctica/Mawson' => '(GMT+6:00) Antarctica/Mawson (Mawson Time)',
			'Antarctica/Vostok' => '(GMT+6:00) Antarctica/Vostok (Vostok Time)',
			'Asia/Almaty' => '(GMT+6:00) Asia/Almaty (Alma-Ata Time)',
			'Asia/Bishkek' => '(GMT+6:00) Asia/Bishkek (Kirgizstan Time)',
			'Asia/Dacca' => '(GMT+6:00) Asia/Dacca (Bangladesh Time)',
			'Asia/Dhaka' => '(GMT+6:00) Asia/Dhaka (Bangladesh Time)',
			'Asia/Novosibirsk' => '(GMT+6:00) Asia/Novosibirsk (Novosibirsk Time)',
			'Asia/Omsk' => '(GMT+6:00) Asia/Omsk (Omsk Time)',
			'Asia/Qyzylorda' => '(GMT+6:00) Asia/Qyzylorda (Qyzylorda Time)',
			'Asia/Thimbu' => '(GMT+6:00) Asia/Thimbu (Bhutan Time)',
			'Asia/Thimphu' => '(GMT+6:00) Asia/Thimphu (Bhutan Time)',
			'Indian/Chagos' => '(GMT+6:00) Indian/Chagos (Indian Ocean Territory Time)',
			'Asia/Rangoon' => '(GMT+6:30) Asia/Rangoon (Myanmar Time)',
			'Indian/Cocos' => '(GMT+6:30) Indian/Cocos (Cocos Islands Time)',
			'Antarctica/Davis' => '(GMT+7:00) Antarctica/Davis (Davis Time)',
			'Asia/Bangkok' => '(GMT+7:00) Asia/Bangkok (Indochina Time)',
			'Asia/Ho_Chi_Minh' => '(GMT+7:00) Asia/Ho_Chi_Minh (Indochina Time)',
			'Asia/Hovd' => '(GMT+7:00) Asia/Hovd (Hovd Time)',
			'Asia/Jakarta' => '(GMT+7:00) Asia/Jakarta (West Indonesia Time)',
			'Asia/Krasnoyarsk' => '(GMT+7:00) Asia/Krasnoyarsk (Krasnoyarsk Time)',
			'Asia/Phnom_Penh' => '(GMT+7:00) Asia/Phnom_Penh (Indochina Time)',
			'Asia/Pontianak' => '(GMT+7:00) Asia/Pontianak (West Indonesia Time)',
			'Asia/Saigon' => '(GMT+7:00) Asia/Saigon (Indochina Time)',
			'Asia/Vientiane' => '(GMT+7:00) Asia/Vientiane (Indochina Time)',
			'Indian/Christmas' => '(GMT+7:00) Indian/Christmas (Christmas Island Time)',
			'Antarctica/Casey' => '(GMT+8:00) Antarctica/Casey (Western Standard Time (Australia))',
			'Asia/Brunei' => '(GMT+8:00) Asia/Brunei (Brunei Time)',
			'Asia/Choibalsan' => '(GMT+8:00) Asia/Choibalsan (Choibalsan Time)',
			'Asia/Chongqing' => '(GMT+8:00) Asia/Chongqing (China Standard Time)',
			'Asia/Chungking' => '(GMT+8:00) Asia/Chungking (China Standard Time)',
			'Asia/Harbin' => '(GMT+8:00) Asia/Harbin (China Standard Time)',
			'Asia/Hong_Kong' => '(GMT+8:00) Asia/Hong_Kong (Hong Kong Time)',
			'Asia/Irkutsk' => '(GMT+8:00) Asia/Irkutsk (Irkutsk Time)',
			
			'Asia/Kashgar' => '(GMT+8:00) Asia/Kashgar (China Standard Time)',
			'Asia/Kuala_Lumpur' => '(GMT+8:00) Asia/Kuala_Lumpur (Malaysia Time)',
			'Asia/Kuching' => '(GMT+8:00) Asia/Kuching (Malaysia Time)',
			'Asia/Macao' => '(GMT+8:00) Asia/Macao (China Standard Time)',
			'Asia/Macau' => '(GMT+8:00) Asia/Macau (China Standard Time)',
			'Asia/Makassar' => '(GMT+8:00) Asia/Makassar (Central Indonesia Time)',
			'Asia/Manila' => '(GMT+8:00) Asia/Manila (Philippines Time)',
			'Asia/Shanghai' => '(GMT+8:00) Asia/Shanghai (China Standard Time)',
			'Asia/Singapore' => '(GMT+8:00) Asia/Singapore (Singapore Time)',
			'Asia/Taipei' => '(GMT+8:00) Asia/Taipei (China Standard Time)',
			'Asia/Ujung_Pandang' => '(GMT+8:00) Asia/Ujung_Pandang (Central Indonesia Time)',
			'Asia/Ulaanbaatar' => '(GMT+8:00) Asia/Ulaanbaatar (Ulaanbaatar Time)',
			'Asia/Ulan_Bator' => '(GMT+8:00) Asia/Ulan_Bator (Ulaanbaatar Time)',
			'Asia/Urumqi' => '(GMT+8:00) Asia/Urumqi (China Standard Time)',
			'Australia/Perth' => '(GMT+8:00) Australia/Perth (Western Standard Time (Australia))',
			'Australia/West' => '(GMT+8:00) Australia/West (Western Standard Time (Australia))',
			'Australia/Eucla' => '(GMT+8:45) Australia/Eucla (Central Western Standard Time (Australia))',
			'Asia/Dili' => '(GMT+9:00) Asia/Dili (Timor-Leste Time)',
			'Asia/Jayapura' => '(GMT+9:00) Asia/Jayapura (East Indonesia Time)',
			'Asia/Pyongyang' => '(GMT+9:00) Asia/Pyongyang (Korea Standard Time)',
			'Asia/Seoul' => '(GMT+9:00) Asia/Seoul (Korea Standard Time)',
			'Asia/Tokyo' => '(GMT+9:00) Asia/Tokyo (Japan Standard Time)',
			'Asia/Yakutsk' => '(GMT+9:00) Asia/Yakutsk (Yakutsk Time)',
			'Australia/Adelaide' => '(GMT+9:30) Australia/Adelaide (Central Standard Time (South Australia))',
			'Australia/Broken_Hill' => '(GMT+9:30) Australia/Broken_Hill (Central Standard Time (South Australia/New South Wales))',
			'Australia/Darwin' => '(GMT+9:30) Australia/Darwin (Central Standard Time (Northern Territory))',
			'Australia/North' => '(GMT+9:30) Australia/North (Central Standard Time (Northern Territory))',
			'Australia/South' => '(GMT+9:30) Australia/South (Central Standard Time (South Australia))',
			'Australia/Yancowinna' => '(GMT+9:30) Australia/Yancowinna (Central Standard Time (South Australia/New South Wales))',
			'Antarctica/DumontDUrville' => '(GMT+10:00) Antarctica/DumontDUrville (Dumont-d\'Urville Time)',
			'Asia/Sakhalin' => '(GMT+10:00) Asia/Sakhalin (Sakhalin Time)',
			'Asia/Vladivostok' => '(GMT+10:00) Asia/Vladivostok (Vladivostok Time)',
			'Australia/ACT' => '(GMT+10:00) Australia/ACT (Eastern Standard Time (New South Wales))',
			'Australia/Brisbane' => '(GMT+10:00) Australia/Brisbane (Eastern Standard Time (Queensland))',
			'Australia/Canberra' => '(GMT+10:00) Australia/Canberra (Eastern Standard Time (New South Wales))',
			'Australia/Currie' => '(GMT+10:00) Australia/Currie (Eastern Standard Time (New South Wales))',
			'Australia/Hobart' => '(GMT+10:00) Australia/Hobart (Eastern Standard Time (Tasmania))',
			'Australia/Lindeman' => '(GMT+10:00) Australia/Lindeman (Eastern Standard Time (Queensland))',
			'Australia/Melbourne' => '(GMT+10:00) Australia/Melbourne (Eastern Standard Time (Victoria))',
			'Australia/NSW' => '(GMT+10:00) Australia/NSW (Eastern Standard Time (New South Wales))',
			'Australia/Queensland' => '(GMT+10:00) Australia/Queensland (Eastern Standard Time (Queensland))',
			'Australia/Sydney' => '(GMT+10:00) Australia/Sydney (Eastern Standard Time (New South Wales))',
			'Australia/Tasmania' => '(GMT+10:00) Australia/Tasmania (Eastern Standard Time (Tasmania))',
			'Australia/Victoria' => '(GMT+10:00) Australia/Victoria (Eastern Standard Time (Victoria))',
			'Australia/LHI' => '(GMT+10:30) Australia/LHI (Lord Howe Standard Time)',
			'Australia/Lord_Howe' => '(GMT+10:30) Australia/Lord_Howe (Lord Howe Standard Time)',
			'Asia/Magadan' => '(GMT+11:00) Asia/Magadan (Magadan Time)',
			'Antarctica/McMurdo' => '(GMT+12:00) Antarctica/McMurdo (New Zealand Standard Time)',
			'Antarctica/South_Pole' => '(GMT+12:00) Antarctica/South_Pole (New Zealand Standard Time)',
			'Asia/Anadyr' => '(GMT+12:00) Asia/Anadyr (Anadyr Time)',
			'Asia/Kamchatka' => '(GMT+12:00) Asia/Kamchatka (Petropavlovsk-Kamchatski Time)',
			) ;
		return $timezones;
	}
	# determine timezone from value
	function getFullTimezone($zone) {
		$zonesarray = getAllTimezones();
		return isArrayKeyAnEmptyString($zone, $zonesarray) ? '' : $zonesarray[$zone];
	}
	# determine user preferrence options
	function getUserPreferrenceOptions(){
		$preferrances = array(
			'emailon_tsheet_approvalcompleted' => 'Send me an Email when my Timesheets are Approved',
			'emailon_benefit_approvalcompleted' => 'Send me an Email when my Benefits and Requisitions are Approved',
			'emailon_leave_approvalcompleted' => 'Send me an Email when my Leave Requests are Approved',
			
			'emailon_tsheeton_approvalrequired' => 'Send me an Email when any Timesheets require my Approval',
			'emailon_benefit_approvalrequired' => 'Send me an Email when any Benefits and Requisitions require my Approval',
			'emailon_leave_approvalrequired' => 'Send me an Email when any Leave Requests require my Approval',
			'emailon_payslip_completed' => 'Send me an Email when my Payslips are issued',
			'emailon_directmessage_recieved' => 'Send me an Email when any user sends me a Direct Message'
		);
		return $preferrances;
	}
	# determine if user has checked in today
	function getSessionEntry($userid){
		$conn = Doctrine_Manager::connection();
		$query = "SELECT * FROM shiftschedule AS d where d.`userid` = '".$userid."' AND d.status = 1 order by d.startdate desc, d.id desc limit 1 ";  // debugMessage($query);
		$result = $conn->fetchRow($query); 
		
		if(!$result){
			$shift = new ShiftSchedule();
			$result = $shift->toArray();
		}
		// debugMessage($query);
		return $result;
	}
?>
