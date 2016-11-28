<?php

class Trail {
  // variables for origin trail
  public $trail_id, $course_id, $owner_id, $trail_type, $trail_title, $scope, $mode;
  public $price, $trail_view_count, $preview_length_time, $time_added;
  /* // variables for import trail
  public $import_id, $importers_course_id, $importers_id;
  public , $date_imported, $purchase_price; */
  // and finally...
  public $chapters;

  public function __construct($trail_params) {
    // origin trails
    $this->owner_id = $trail_params['owner_id'];
    $this->course_id = $trail_params['course_id'];
    $this->trail_id =  $trail_params['trail_id'];
    $this->trail_title = $trail_params['trail_title'];
    $this->scope = $trail_params['scope'];
    $this->mode = $trail_params['mode'];
    $this->trail_type = $trail_params['trail_type'];
    $this->time_added = $trail_params['time_added'];
    $this->trail_view_count = $trail_params['trail_view_count'];
    $this->preview_length_time = $trail_params['preview_length_time'];
    $this->price = $trail_params['price'];
    $this_is_main_user = $trail_params['is_main_user'];
    if ($this_is_main_user) {
      // load chapters
      $this->chapters = array();
    }
    /* // for import trails
     if (strcmp($this->trail_type, "import") == 0) {
     $this->origin_course_id = $trail_params['origin_course_id'];
     $this->origin_owner_id = $trail_params['origin_owner_id'];
     $this->cost = $trail_params['purchase_price'];
     } */
  }
}