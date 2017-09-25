<?php
class Bank_model extends CI_Model
{
  private static $user;
	
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->model('user_model');
    self::$user = $this->user_model->get_user();
  }

  public function get_db_banks($user_id = '')
  {
    if (empty($user_id)) $user_id = self::$user->user_id;
		$query = $this->db->query("SELECT * FROM bank WHERE owner_id='{$user_id}'");
    if ( ! isset($query)) return NULL;
		$banks = array();
		foreach ($query->result_array() as $row) $banks[] = new Bank($row);
		return $banks;
  }

  public function get_session_banks()
  {
    $banks = array();
    foreach (self::$user->schools as $school)
      foreach ($school->courses as $course) 
				foreach ($course->banks as $bank)
					$banks[] = $bank;
    return $banks;
  }

  public function get_course_banks($course_id, $user_id = '')
  {
    $full_course_id = array('owner_id'=>$user_id, 'course_id'=>$course_id);
    $query = $this->db->get_where('bank', $full_course_id);
    if ($query != NULL) return NULL;
		$banks = array();
		foreach ($query->result() as $row) $banks[] = new Bank($row);
		return $banks;
  }

  public function set_and_get_bank($school_id, $course_id, $bank_type)
  {
    $course = self::$user->schools[$school_id-1]->courses[$course_id-1];
		$bank_id = 1 + sizeof($course->banks);
    $current_time = date_timestamp_get(date_create());
    $bank_params = array( 
			'owner_id' => self::$user->user_id, 
			'school_id' => $school_id, 
			'course_id' => $course_id, 
			'bank_id' => $bank_id, 
			'bank_title' => $this->input->post('bank_title'), 
			'scope' => $this->input->post('scope'), 
			'time_added' => $current_time, 
			'bank_type' => $bank_type );
    $query_successful = $this->db->insert('bank', $bank_params);
    if ( ! $query_successful) return NULL;
		$bank_params['mode'] = 'building';
		$bank_params['bank_view_count'] = 0;
		$bank_params['is_main_user'] = TRUE;
		return new Bank($bank_params);
  }
}