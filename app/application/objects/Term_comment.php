<?php
class Term_comment {
  public $author_id, $term_owner_id, $course_id, $trail_id, $chapter_id;
  public $term_id, $comment, $resolved, $last_edit_time;

  public function __construct($params)
  {
    $this->author_id = $params['author_id'];
    $this->term_owner_id = $params['owner_id'];
    $this->course_id = $params['course_id'];
    $this->trail_id = $params['trail_id'];
    $this->chapter_id = $params['chapter_id'];
    $this->term_id = $params['term_id'];
    $this->comment = $params['comment'];
    $this->resolved = $params['resolved'];
    $this->last_edit_time = $params['last_edit_time'];
  }
}