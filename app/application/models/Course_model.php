<?php
class Course_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/Course.php';
  }

  public function get_user_courses($user_id, $is_main_user)
  {
    $query = $this->db->query("SELECT * FROM course WHERE owner_id='$user_id'");
    if ($query != null) {
      $courses = array();
      foreach ($query->result() as $row) {
        $course_params = array( 
            "owner_id" => $user_id, 
            "course_id" => $row->course_id, 
            "course_title" => $row->course_title, 
            "scope" => $row->scope, 
            "time_added" => $row->time_added, 
            "course_view_count" => $row->course_view_count, 
            "course_type" => $row->course_type, 
            "category" => $row->category, 
            "education_level" => $row->education_level, 
            "price" => $row->price, 
            "is_main_user" => $is_main_user );
        $courses[] = new Course($course_params);
      }
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