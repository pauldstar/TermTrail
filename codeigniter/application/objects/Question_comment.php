<?php
class Question_comment 
{
  public $author_id, $school_id, $question_owner_id, $course_id, $trail_id, $chapter_id;
  public $question_id, $comment, $resolved, $last_edit_time;

  public function __construct($params)
  {
    $this->author_id = $params['author_id'];
    $this->school_id = $params['school_id'];
    $this->question_owner_id = $params['question_owner_id'];
    $this->course_id = $params['course_id'];
    $this->trail_id = $params['trail_id'];
    $this->chapter_id = $params['chapter_id'];
    $this->question_id = $params['question_id'];
    $this->comment = $params['comment'];
    $this->resolved = $params['resolved'];
    $this->last_edit_time = $params['last_edit_time'];
  }
}