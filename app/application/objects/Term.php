<?php
class Term {
  public $owner_id, $course_id, $trail_id, $chapter_id, $term_id;
  public $author_id, $term_position, $content, $answer, $hint;
  public $revision_state, $confidence_score, $last_edit_time;
  public $term_comments;

  public function __construct($params)
  {
    $this->owner_id = $params['owner_id'];
    $this->course_id = $params['course_id'];
    $this->trail_id = $params['trail_id'];
    $this->chapter_id = $params['chapter_id'];
    $this->term_id = $params['term_id'];
    $this->author_id = $params['author_id'];
    $this->term_position = $params['term_position'];
    $this->content = $params['content'];
    $this->answer = $params['answer'];
    $this->hint = $params['hint'];
    $this->revision_state = $params['revision_state'];
    $this->confidence_score = $params['confidence_score'];
    $this->last_edit_time = $params['last_edit_time'];
    $this->term_comments = array();
  }
}