<?php

class LookupType extends BaseEntity  {
	
	public function setTableDefinition() {
		parent::setTableDefinition();
		
		$this->setTableName('lookuptype');
		$this->hasColumn('name', 'string', 50, array('notnull' => true, 'unique' => true, 'notblank' => true));
		$this->hasColumn('displayname', 'string', 50, array('notnull' => true, 'notblank' => true));
		$this->hasColumn('description', 'string', 255);
		$this->hasColumn('listable', 'integer', null, array('default' => 1));
		$this->hasColumn('updatable', 'integer', null, array('default' => 1));
		$this->hasColumn('addbutnodelete', 'integer', null, array('default' => 0));
	}
	
	public function setUp() {
		parent::setUp();
		$this->hasMany("LookupTypeValue as values", 
							array(
								'local' => 'id',
								'foreign' => 'lookuptypeid'
							)); 
	}
	
	/**
	 * Return the values of the options for the lookup type
	 * 
	 * @return Array containing the lookup types for the values or false if an error occurs
	 *
	 */
	function getOptionValues() {		
		$optionvaluesquery = "SELECT lv.lookuptypevalue as optiontext, lv.lookuptypevalue as optionvalue FROM lookuptype AS l , 
		lookuptypevalue AS lv WHERE l.id =  lv.lookuptypeid AND l.name ='".$this->getName()."' ORDER BY optiontext ";
		return getOptionValuesFromDatabaseQuery($optionvaluesquery);
	}
	
  /**
	 * Return the values of the options for the lookup type
	 * 
	 * @param String $orderby The column to order the results by, either optiontext - the text or optionvalue the value 
	 * 
	 * @return Array containing the lookup types for the values or false if an error occurs
	 *
	 */
	function getOptionValuesAndDescription($orderby = "optiontext") {		
		$optionvaluesquery = "SELECT lv.lookupvaluedescription as optiontext, lv.lookuptypevalue as optionvalue FROM lookuptype AS l , 
		lookuptypevalue AS lv WHERE l.id =  lv.lookuptypeid AND l.name ='".$this->getName()."' ORDER BY ".$orderby;
		return getOptionValuesFromDatabaseQuery($optionvaluesquery);
	}
	/**
	 * Return the values of the options for the lookup type
	 * 
	 * @return Array containing the lookup types for the values or false if an error occurs
	 *
	 */
	function getOptionValuesFromQuery() {		
		# get the query to execute
		$conn = Doctrine_Manager::connection(); 
		$query = $conn->fetchRow("SELECT querystring FROM lookupquery WHERE name = '".$this->getName()."'");
		# debugMessage($query); 
		if (isEmptyString($query['querystring'])) {
			return array(); 
		} else {
			return getOptionValuesFromDatabaseQuery($query['querystring']);
		}
	}
	/**
	 * Return the option values for a number of type names
	 *
	 * @param Array $typenames The names of the lookup types
	 * @return Array Containing the values of the lookup types
	 */
	function getOptionValuesFromMultipleTypes($typenames) {
		// get the values for each type
		$values = array(); 
		foreach($typenames as $name) {
			$this->setName($name); 
			$values = array_merge_maintain_keys($values, $this->getOptionValues());
			
		}
		// sort the option values alphabetically
		sort($values); 
		return $values; 
	}
	
	/**
	 * Get the description of a lookup value 
	 * 
	 * @param String $lookuptype The lookup type 
	 * @param String $lookuptypevalue The current value of the lookup type whose description is to be loaded
	 * 
	 * @return String 
	 */
	static function getLookupValueDescription($lookuptype, $lookuptypevalue) {
		$sql = "SELECT lv.lookupvaluedescription FROM lookuptypevalue lv INNER JOIN lookuptype l ON (lv.lookuptypeid = l.id AND l.`name` = '".$lookuptype."' AND lv.lookuptypevalue = '".$lookuptypevalue."')";
		$conn = Doctrine_Manager::connection(); 
		
		return $conn->fetchOne($sql); 
	}
	# return all the variable data 
	function getAllDataValues($type = '') {
		$conn = Doctrine_Manager::connection();
		$resultvalues = $conn->fetchAll("SELECT * FROM lookuptypevalue WHERE lookuptypeid = '".$this->getID()."' order by lookupvaluedescription asc ");
		if($this->getName() == 'BENEFIT_TYPES'){
			$resultvalues = $conn->fetchAll("SELECT c.id as id, c.id as lookuptypevalue, c.name as lookupvaluedescription, c.defaultamount as alias, c.amounttype as alias2 FROM benefittype c order by c.name asc ");
		}
		return $resultvalues;	
	}
	function getNextInsertIndex(){
		$conn = Doctrine_Manager::connection(); 
		$resultvalues = $conn->fetchOne("SELECT lookuptypevalue FROM lookuptypevalue WHERE lookuptypeid = '".$this->getID()."' order by CAST(lookuptypevalue AS SIGNED) desc limit 1 ");
		if($this->getName() == 'BENEFIT_TYPES'){
			$resultvalues = $conn->fetchOne("SELECT c.id as lookuptypevalue FROM benefittype c order by CAST(lookuptypevalue AS SIGNED) desc limit 1 ");
		}
		return intval($resultvalues)+1;
	}
	# determine if lookup value is updateble
	function updatesAllowed() {
		return $this->getupdatable() == 1 ? true : false;
	}
	# determine if lookup value is updateble
	function addNoDeleteAllowed() {
		return $this->getaddbutnodelete() == 0 ? true : false;
	}
}
?>