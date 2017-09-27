<?php
class Course 
{
	public $owner_id; 
	public $school_id; 
	public $course_id; 
	public $course_title; 
	public $scope;
  public $course_view_count; 
	public $course_type; 
	public $category; 
	public $time_added;
  public $banks;
	
	public $parent_label = 'school';
	public $child_label = 'bank';

  public function __construct($params)
  {
    $this->owner_id = $params['owner_id'];
    $this->school_id = $params['school_id'];
    $this->course_id = $params['course_id'];
    $this->course_title = $params['course_title'];
    $this->scope = $params['scope'];
    $this->time_added = $params['time_added'];
    $this->course_view_count = $params['course_view_count'];
    $this->course_type = $params['course_type'];
    $this->category = $params['category'];
    $this->banks = array();
  }
	
	public function get_full_id()
	{
	  $full_id = array( 
			'school_id' => $this->school_id,
			'course_id' => $this->course_id 
		);
		
		return $full_id;
	}
	
	public function get_parent_title($user)
	{
		return $user->schools[$this->school_id - 1]->school_title;
	}	
	
	public function get_child_count()
	{
		return sizeof($this->banks);
	}
	
	public function get_comment_count($user)
	{
		return 0;
	}
}