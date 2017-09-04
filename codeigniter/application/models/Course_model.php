<?php
class Course_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    $this->load->library('session');
  }

  public function get_main_user_courses()
  {
    $user = $_SESSION['user'];
    $query = $this->db->query("SELECT * FROM course WHERE owner_id='$user->user_id'");
    if ($query != null) {
      $courses = array();
      foreach ($query->result_array() as $row)
        $courses[] = new Course($row);
      $user->courses = $courses;
      return true;
    }
    return false;
  }

  public function get_user_courses($user_id)
  {
    $query = $this->db->query("SELECT * FROM course WHERE owner_id='$user_id'");
    if ($query != null) {
      $courses = array();
      foreach ($query->result_array() as $row) 
        $courses[] = new Course($row);
      return $courses;
    }
    return null;
  }

  public function set_and_get_course($course_type)
  {
    $course_id = sizeof($this->user->courses) + 1;
    $current_time = date_timestamp_get(date_create());
    $course_params = array( 
        'owner_id' => $this->user->user_id, 
        'course_id' => $course_id, 
        'course_title' => $this->input->post('course_title'), 
        'scope' => $this->input->post('scope'), 
        'course_type' => $course_type, 
        'category' => $this->input->post('category'), 
        'education_level' => $this->input->post('education_level'), 
        'time_added' => $current_time );
    // insert user's new course into database
    $query_successful = $this->db->insert('course', $course_params);
    if ($query_successful) {
      $course_params['course_view_count'] = 0;
      $course_params['is_main_user'] = true;
      $course_params['price'] = 0;
      return new Course($course_params);
    }
    return null;
  }
}