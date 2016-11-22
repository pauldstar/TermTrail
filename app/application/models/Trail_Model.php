<?php

class Trail_Model extends CI_Model {

  public function __construct() {
    parent::__construct();
    $this->load->database();
    require_once APPPATH.'objects/Trail.php';
  }

  public function get_user_trails($user_id, $course_id, $is_main_user) {
    $full_course_id = array("owner_id" => $user_id, "course_id" => $course_id);
    $query = $this->db->get_where('trail', $full_course_id);
    $trails = array();
    foreach ($query->result() as $row) {
      $trail_params = array(
          "owner_id" => $user_id, 
          "course_id" => $course_id, 
          "trail_id" => $row->trail_id, 
          "trail_title" => $row->trail_title, 
          "scope" => $row->scope, 
          "time_added" => $row->time_added, 
          "trail_view_count" => $row->trail_view_count, 
          "trail_type" => $row->trail_type, 
          "mode" => $row->mode, 
          "preview_length_time" => $row->preview_length_time, 
          "price" => $row->price, 
          "is_main_user" => $is_main_user);
      $trails[] = new Trail($trail_params);
    }
  }

  public function set_and_get_trail() {}
}