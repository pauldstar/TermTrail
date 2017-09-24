<?php
class School 
{
  public $owner_id;
	public $school_id; 
	public $school_title; 
	public $scope; 
	public $time_added;
  public $school_view_count; 
	public $school_type; 
	public $education_level;
  public $courses;

  public function __construct($params)
  {
    $this->owner_id = $params['owner_id'];
    $this->school_id = $params['school_id'];
    $this->school_title = $params['school_title'];
    $this->scope = $params['scope'];
    $this->time_added = $params['time_added'];
    $this->school_view_count = $params['school_view_count'];
    $this->school_type = $params['school_type'];
    $this->education_level = $params['education_level'];
    $this->courses = array();
  }
}