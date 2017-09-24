<?php
class School_model extends CI_Model 
{
	private static $user;
	
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->model('user_model');
    self::$user = $this->user_model->get_user();
  }

  public function get_user_schools_db($user_id = '')
  {
		if (empty($user_id)) $user_id = self::$user->user_id;
    $query = $this->db->query("SELECT * FROM school WHERE owner_id='{$user_id}'");
    if ( ! isset($query)) return NULL;
		$schools = array();
		foreach ($query->result_array() as $row) $schools[] = new School($row);
		return $schools;
  }
	
  public function set_and_get_school($school_type)
  {
    $school_id = sizeof(self::$user->schools) + 1;
    $current_time = date_timestamp_get(date_create());
    $school_params = array( 
			'owner_id' => self::$user->user_id, 
			'school_id' => $school_id, 
			'school_title' => $this->input->post('school_title'), 
			'scope' => $this->input->post('scope'), 
			'school_type' => $school_type, 
			'education_level' => $this->input->post('education_level'), 
			'time_added' => $current_time );
    $query_successful = $this->db->insert('school', $school_params);
    if ( ! $query_successful) return NULL;
		$school_params['school_view_count'] = 0;
		$school_params['is_main_user'] = TRUE;
		return new School($school_params);
  }
}