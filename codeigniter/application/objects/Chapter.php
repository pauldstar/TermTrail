<?php
class Chapter 
{
  public $owner_id; 
	public $school_id; 
	public $course_id; 
	public $bank_id;
  public $chapter_id; 
	public $chapter_title; 
	public $chapter_position;
  public $questions;

  public function __construct($params)
  {
    $this->owner_id = $params['owner_id'];
    $this->school_id = $params['school_id'];
    $this->course_id = $params['course_id'];
    $this->bank_id = $params['bank_id'];
    $this->chapter_id = $params['chapter_id'];
    $this->chapter_title = $params['chapter_title'];
    $this->chapter_position = $params['chapter_position'];
    $this->questions = array();
  }
}