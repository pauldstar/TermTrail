<?php
class Bank 
{
  // for origin bank
  public $bank_id; 
	public $school_id; 
	public $course_id; 
	public $owner_id; 
	public $bank_type; 
	public $bank_title; 
  public $scope; 
	public $mode; 
	public $bank_view_count; 
	public $time_added;
  
  // for import bank
  public $origin_bank_id; 
	public $origin_course_id; 
	public $origin_school_id; 
	public $origin_owner_id;
  public $date_imported; 
  
  public $chapters;
	public $revisions;
	
	public $parent_label = 'course';
	public $child_label = 'chapter';

  public function __construct($params) 
	{ // for origin bank
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
  }
		
	public function get_full_id()
	{
	  $full_id = array( 
			'school_id' => $this->school_id,
			'course_id' => $this->course_id, 
			'bank_id' => $this->bank_id 
		);
		
		return $full_id;
	}
	
	public function get_parent_title($user)
	{
		return $user->schools[$this->school_id - 1]->courses[$this->course_id - 1]->course_title;
	}
	
	public function get_child_count()
	{
		return sizeof($this->chapters);
	}
	
	public function get_comment_count($user)
	{
		return 0;
	}
}