<?php
class Chapter {
  public $owner_id, $course_id, $trail_id;
  public $chapter_id, $chapter_title, $chapter_position;
  public $terms;

  public function __construct($trail_params)
  {
    $this->owner_id = $trail_params['owner_id'];
    $this->course_id = $trail_params['course_id'];
    $this->trail_id = $trail_params['trail_id'];
    $this->chapter_id = $trail_params['chapter_id'];
    $this->chapter_title = $trail_params['chapter_title'];
    $this->chapter_position = $trail_params['chapter_position'];
    $this->terms = array();
  }
}