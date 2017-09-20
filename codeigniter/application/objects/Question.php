<?php
class Question 
{
  public $owner_id, $school_id, $course_id, $bank_id, $chapter_id, $question_id;
  public $author_id, $question_position, $content, $answer, $hint;
  public $revision_state, $confidence_score, $last_edit_time;
  public $question_comments;

  public function __construct($params)
  {
    $this->owner_id = $params['owner_id'];
    $this->school_id = $params['school_id'];
    $this->course_id = $params['course_id'];
    $this->bank_id = $params['bank_id'];
    $this->chapter_id = $params['chapter_id'];
    $this->question_id = $params['question_id'];
    $this->author_id = $params['author_id'];
    $this->question_position = $params['question_position'];
    $this->content = $params['content'];
    $this->answer = $params['answer'];
    $this->hint = $params['hint'];
    $this->revision_state = $params['revision_state'];
    $this->confidence_score = $params['confidence_score'];
    $this->last_edit_time = $params['last_edit_time'];
    $this->question_comments = array();
  }
}