<?php
class Question 
{
  public $owner_id; 
	public $school_id; 
	public $course_id; 
	public $bank_id; 
	public $chapter_id; 
	public $question_id;
  public $author_id; 
  public $question_type; 
	public $question_position; 
	public $question;
	public $answer; 
	public $hint;
  public $revision_state; 
	public $confidence_score; 
	public $last_edit_time;
  public $question_comments;
	
	public $parent_label = 'chapter';

  public function __construct($params)
  {
    $this->owner_id = $params['owner_id'];
    $this->school_id = $params['school_id'];
    $this->course_id = $params['course_id'];
    $this->bank_id = $params['bank_id'];
    $this->chapter_id = $params['chapter_id'];
    $this->question_id = $params['question_id'];
    $this->author_id = $params['author_id'];
    $this->question_type = 'origin'; // $params['question_type'];
    $this->question_position = $params['question_position'];
    $this->question = $params['question'];
    $this->answer = $params['answer'];
    $this->hint = $params['hint'];
    $this->revision_state = $params['revision_state'];
    $this->confidence_score = $params['confidence_score'];
    $this->last_edit_time = $params['last_edit_time'];
    $this->question_comments = array();
  }
	
	public function get_full_id()
	{
	  $full_id = array( 
			'school_id' => $this->school_id,
			'course_id' => $this->course_id,
			'bank_id' => $this->bank_id,
			'chapter_id' => $this->chapter_id,
			'question_id' => $this->question_id
		);
		return $full_id;
	}
	
	public function get_comment_count($user)
	{
		return 0;
	}
}