<?php

class Trail_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    $this->load->library('session');
  }

  public function get_main_user_trails()
  {
    $user = $_SESSION['user'];
    $query = $this->db->query("SELECT * FROM trail WHERE owner_id='$user->user_id'");
    if (isset($query))
    {
      foreach ($query->result_array() as $row)
      {
        $trail = new Trail($row);
        $course_id = $trail->course_id;
        $user->courses[$course_id - 1]->trails[] = $trail;
      }
      return true;
    }
    return false;
  }

  public function get_main_user_trails_from_object()
  {
    $user = $_SESSION['user'];
    $trails_to_return = array();
    foreach ($user->courses as $course)
    {
      foreach ($course->trails as $trail)
      {
        $trails_to_return[] = $trail;
      }
    }
    if (empty($trails_to_return)) return false;
    return $trails_to_return;
  }

  public function get_course_trails($user_id, $course_id, $is_main_user)
  {
    $full_course_id = array( "owner_id" => $user_id, "course_id" => $course_id 
    );
    $query = $this->db->get_where('trail', $full_course_id);
    if ($query != null)
    {
      $trails = array();
      foreach ($query->result() as $row)
        $trails[] = new Trail($row);
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
        "trail_type" => $trail_type 
    );
    // insert user's new trail into database
    $query_successful = $this->db->insert('trail', $trail_params);
    if ($query_successful)
    {
      $trail_params['mode'] = 'building';
      $trail_params['trail_view_count'] = 0;
      $trail_params['preview_length_time'] = 1800;
      $trail_params['price'] = 0;
      $trail_params['is_main_user'] = true;
      return new Trail($trail_params);
    }
    return null;
  }
}