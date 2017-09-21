<?php
class Course_model extends CI_Model 
{
  private static $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH.'objects/User.php';
    require_once APPPATH.'objects/School.php';
    require_once APPPATH.'objects/Course.php';
    $this->load->library('session');
		self::$user = $_SESSION['user'];
  }

  public function get_user_courses_db($user_id = '')
  {
    if (empty($user_id)) $user_id = self::$user->user_id;
		$query = $this->db->query("SELECT * FROM course WHERE owner_id='$user_id'");
    if ($query == null) return null;
		$courses = array();
		foreach ($query->result_array() as $row) $courses[] = new Course($row);
		return $courses;
  }

  public function set_and_get_course($school_id, $course_type)
  {
    $course_id = 1 + sizeof(self::$user->schools[$school_id-1]->courses);
    $current_time = date_timestamp_get(date_create());
    $course_params = array( 
			'owner_id' => self::$user->user_id,
			'school_id' => $school_id,
			'course_id' => $course_id, 
			'course_title' => $this->input->post('course_title'), 
			'scope' => $this->input->post('scope'), 
			'course_type' => $course_type, 
			'category' => $this->input->post('category'), 
			'time_added' => $current_time );
    $query_successful = $this->db->insert('course', $course_params);
    if (!$query_successful) return null;
		$course_params['course_view_count'] = 0;
		$course_params['is_main_user'] = true;
		return new Course($course_params);
  }
}