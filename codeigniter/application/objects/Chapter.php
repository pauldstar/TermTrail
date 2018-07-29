<?php
class Chapter 
{
  public $owner_id; 
	public $school_id; 
	public $course_id; 
	public $bank_id;
  public $chapter_id; 
  public $chapter_type; 
	public $chapter_title; 
	public $grid_position;
  public $questions;
	
	public $parent_label = 'bank';
	public $child_label = 'question';

  public function __construct($params)
  {
    $this->owner_id = $params['owner_id'];
    $this->school_id = $params['school_id'];
    $this->course_id = $params['course_id'];
    $this->bank_id = $params['bank_id'];
    $this->chapter_type = 'origin'; // $params['chapter_type'];
    $this->chapter_id = $params['chapter_id'];
    $this->chapter_title = $params['chapter_title'];
    $this->grid_position = $params['grid_position'];
    $this->questions = array();
  }
	
	public function get_full_id()
	{
	  $full_id = array( 
			'school_id' => $this->school_id,
			'course_id' => $this->course_id,
			'bank_id' => $this->bank_id,
			'chapter_id' => $this->chapter_id
		);
		return $full_id;
	}
	
	public function get_parent_title($user)
	{
		return $user->schools[$this->school_id - 1]->
			courses[$this->course_id - 1]->banks[$this->bank_id - 1]->bank_title;
	}
	
	public function get_child_count()
	{
		return sizeof($this->questions);
	}
	
	public function get_comment_count($user)
	{
		return 0;
	}
}