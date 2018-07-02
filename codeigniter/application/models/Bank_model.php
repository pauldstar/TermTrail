<?php
class Bank_model extends TL_Model
{
	public function set_session_banks()
	{
		$banks = self::get_db_banks();
		if ($banks !== NULL)
		{
			foreach ($banks as $bank)
			{
				$school_id = $bank->school_id;
				$course_id = $bank->course_id;
				self::$user->schools[$school_id-1]->courses[$course_id-1]->banks[] = $bank;
			}
			
			$this->load->model('chapter_model');
			$this->chapter_model->set_session_chapters();
		}
	}

  public function get_session_banks($full_parent_id = '')
  {
		if (empty($full_parent_id))
		{
			$banks = array();
			foreach (self::$user->schools as $school)
				foreach ($school->courses as $course) 
					foreach ($course->banks as $bank)
						$banks[] = $bank;
			return $banks;
		}
		
		$school_id =  $full_parent_id['school_id'];
		$course_id =  $full_parent_id['course_id'];
		return self::$user->schools[$school_id-1]->courses[$course_id-1]->banks;
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