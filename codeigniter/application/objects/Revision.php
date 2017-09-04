<?php
class Revision {
  public $trail_owner_id, $trail_course_id, $trail_id, $revision_id;
  public $start_time, $elapsed_time, $stop_time, $confidence_score, $mode;

  public function __construct($params = array())
  {
    $this->trail_owner_id = $params['trail_owner_id'];
    $this->trail_course_id = $params['trail_course_id'];
    $this->trail_id = $params['trail_id'];
    $this->revision_id = $params['revision_id'];
    $this->start_time = $params['start_time'];
    $this->elapsed_time = $params['elapsed_time'];
    $this->stop_time = $params['stop_time'];
    $this->confidence_score = $params['confidence_score'];
    $this->mode = $params['mode'];
  }
}