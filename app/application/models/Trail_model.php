<?php
class Trail_model extends CI_Model {
  public $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/Trail.php';
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/User.php';
    $this->load->library('session');
    $this->user = isset($_SESSION['user']) ? $_SESSION['user'] : null;
  }

  public function get_user_trails($user_id, $course_id, $is_main_user)
  {
    $full_course_id = array( "owner_id" => $user_id, "course_id" => $course_id );
    $query = $this->db->get_where('trail', $full_course_id);
    if ($query != null) {
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
            "is_main_user" => $is_main_user );
        $trails[] = new Trail($trail_params);
      }
      return $trails;
    }
    return null;
  }

  public function set_and_get_trail($course_id, $trail_type)
  {
    $trail_id = sizeof($this->user->courses[$course_id - 1]->trails) + 1;
    $current_time = date_timestamp_get(date_create());
    $trail_params = array( 
        "owner_id" => $this->user->user_id, 
        'course_id' => $course_id, 
        'trail_id' => $trail_id, 
        "trail_title" => $this->input->post('trail_title'), 
        "scope" => $this->input->post('scope'), 
        "time_added" => $current_time, 
        "trail_type" => $trail_type );
    // insert user's new trail into database
    $query_successful = $this->db->insert('trail', $trail_params);
    if ($query_successful) {
      $trail_params['mode'] = 'building';
      $trail_params['trail_view_count'] = 0;
      $trail_params['preview_length_time'] = 1800;
      $trail_params['price'] = 0;
      $trail_params['is_main_user'] = true;
      return new Trail($trail_params);
    }
    return null;
    // may need to check if user is offline before returning array of trails
  }
}