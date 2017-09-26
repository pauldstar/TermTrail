<?php
class Course_model extends MY_Model 
{
	public function set_session_courses()
	{
		$courses = self::get_db_courses();
		if ($courses === NULL) return;
		
		foreach ($courses as $course)
		{
			$school_id = $course->school_id;
			self::$user->schools[$school_id-1]->courses[] = $course;
		}
		
		$this->load->model('bank_model');
		$this->bank_model->set_session_banks();
	}
	
  public function get_db_courses($user_id = '')
  {
    if (empty($user_id)) $user_id = self::$user->user_id;
		$query = $this->db->query("SELECT * FROM course WHERE owner_id='{$user_id}'");
    if ( ! isset($query)) return NULL;
		$courses = array();
		foreach ($query->result_array() as $row) $courses[] = new Course($row);
		return $courses;
  }
	
	public function get_session_courses()
	{
		$courses = array();
    foreach (self::$user->schools as $school)
      foreach ($school->courses as $course) 
				$courses[] = $course;
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
    if ( ! $query_successful) return NULL;
		$course_params['course_view_count'] = 0;
		$course_params['is_main_user'] = TRUE;
		return new Course($course_params);
  }
}