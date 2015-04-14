<?php 

class Document extends BaseRecord {
	
    public function setTableDefinition() {
		#add the table definitions from the parent table
		parent::setTableDefinition();
		$this->setTableName('document');
		$this->hasColumn('id', 'integer', null, array('primary' => true, 'autoincrement' => true));
		$this->hasColumn('userid', 'integer', null, array('default' => NULL));
		$this->hasColumn('companyid', 'integer', null, array('default' => NULL));
		$this->hasColumn('type', 'integer', null, array('notblank' => true));
        $this->hasColumn('filename', 'string', 255, array('notblank' => true));
         $this->hasColumn('originalfile', 'string', 255);
        $this->hasColumn('title', 'string', 255);
       	$this->hasColumn('description','string', 500);
       	$this->hasColumn('dateuploaded', 'date', null, array('default' => NULL));
       	$this->hasColumn('uploadedbyid', 'integer', null, array('default' => NULL)); /* */
		
    }
	/**
    * Contructor method for custom functionality - add the fields to be marked as dates
    */
	public function construct() {
		parent::construct();
       $this->addDateFields(array("dateuploaded"));
       
       // set the custom error messages
       $this->addCustomErrorMessages(array(
       									"filename.notblank" => $this->translate->_("document_filename_error"),
       									"type.notblank" => $this->translate->_("document_type_error")
       								));
    }
	
	/*	
	 * Relationships for the model
	 */
	public function setUp() {
		parent::setUp(); 
		
		$this->hasOne('UserAccount as user',
						array(
							'local' => 'userid',
							'foreign' => 'id'
						)
		);
		$this->hasOne('UserAccount as uploadedby',
				array(
						'local' => 'uploadedbyid',
						'foreign' => 'id'
				)
		);
	}
	/*
	 * Pre process model data
	 */
	function processPost($formvalues) {
		// trim spaces from the name field
		if(isArrayKeyAnEmptyString('type', $formvalues)){
			unset($formvalues['type']); 
		}
		if(isArrayKeyAnEmptyString('uploadedbyid', $formvalues)){
			unset($formvalues['uploadedbyid']); 
		}
		if(isArrayKeyAnEmptyString('userid', $formvalues)){
			unset($formvalues['userid']);
		}
		if(isArrayKeyAnEmptyString('companyid', $formvalues)){
			$formvalues['companyid'] = getCompanyID();
		}
		if(!isArrayKeyAnEmptyString('oldfilename', $formvalues)){
			$formvalues['originalfile'] = $formvalues['oldfilename'];
		}
		if(!isArrayKeyAnEmptyString('FileInput', $formvalues)){
			$formvalues['originalfile'] = $formvalues['FileInput'];
		}
		if(!isArrayKeyAnEmptyString('oldfilename', $formvalues) && isArrayKeyAnEmptyString('title', $formvalues)){
			$formvalues['title'] = $formvalues['oldfilename'];
		}
		// debugMessage($formvalues); exit();
		parent::processPost($formvalues);
	}
}
?>