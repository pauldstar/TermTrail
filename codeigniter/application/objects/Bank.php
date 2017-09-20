<?php

class Bank 
{
  // variables for origin bank
  public $bank_id, $school_id, $course_id, $owner_id, $bank_type, $bank_title; 
  public $scope, $mode, $bank_view_count, $time_added;
  /*
   * // variables for import bank
   * public $import_id, $importers_course_id, $importers_id;
   * public , $date_imported, $purchase_price;
   */
  // and finally...
  public $chapters, $revisions;

  public function __construct($params) 
	{
    // origin banks
    $this->owner_id = $params['owner_id'];
    $this->school_id = $params['school_id'];
    $this->course_id = $params['course_id'];
    $this->bank_id = $params['bank_id'];
    $this->bank_title = $params['bank_title'];
    $this->scope = $params['scope'];
    $this->mode = $params['mode'];
    $this->bank_type = $params['bank_type'];
    $this->time_added = $params['time_added'];
    $this->bank_view_count = $params['bank_view_count'];
    $this->chapters = array();
    /* $this->revisions = array();
     * // for import banks
     * if (strcmp($this->bank_type, "import") == 0) 
		 * {
     * $this->origin_course_id = $params['origin_course_id'];
     * $this->origin_owner_id = $params['origin_owner_id'];
     * }
     */
  }
}