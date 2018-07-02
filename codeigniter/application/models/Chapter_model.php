<?php
class Chapter_model extends TL_Model 
{
	public function set_session_chapters()
	{
		$chapters = self::get_db_chapters();
		if ($chapters !== NULL)
		{
			foreach ($chapters as $chapter)
			{
				$school_id = $chapter->school_id;
				$course_id = $chapter->course_id;
				$bank_id = $chapter->bank_id;
				self::$user->schools[$school_id-1]->
					courses[$course_id-1]->banks[$bank_id-1]->chapters[] = $chapter;
			}
			
			$this->load->model('question_model');
			$this->question_model->set_session_questions();
		}
	}
	
  public function get_session_chapters($full_parent_id)
  {
		$school_id =  $full_parent_id['school_id'];
		$course_id =  $full_parent_id['course_id'];
		$bank_id =  $full_parent_id['bank_id'];
		return self::$user->schools[$school_id-1]->courses[$course_id-1]->banks[$bank_id-1]->chapters;
  }

  public function get_db_chapters($user_id = '')
  {
		if (empty($user_id)) $user_id = self::$user->user_id;
    $query = $this->db->query("SELECT * FROM chapter WHERE owner_id='{$user_id}'");
    if ( ! isset($query)) return NULL;
		$chapters = array();
		foreach ($query->result_array() as $row) $chapters[] = new Chapter($row);
		return $chapters;
  }

  public function get_bank_chapters($user_id, $school_id, $course_id, $bank_id, $is_main_user)
  {
    $full_bank_id = array( 
			'owner_id' => $user_id, 
			'school_id' => $school_id, 
			'course_id' => $course_id, 
			'bank_id' => $bank_id );
    $query = $this->db->get_where('chapter', $full_bank_id);
    if ( ! $query != NULL) return NULL;
		$chapters = array();
		foreach ($query->result_array() as $row) $chapters[] = new Chapter($row);
		return $chapters;
  }

  public function set_and_get_chapter($school_id, $course_id, $bank_id)
  {
    $chapter_id = 1 + sizeof(
			self::$user->schools[$school_id-1]->courses[$course_id-1]->banks[$bank_id-1]->chapters);
    $chapter_params = array( 
			'owner_id' => self::$user->user_id, 
			'school_id' => $this->input->post('school_id'),
			'course_id' => $this->input->post('course_id'), 
			'bank_id' => $this->input->post('bank_id'), 
			'chapter_id' => $chapter_id, 
			'chapter_title' => $this->input->post('chapter_title'), 
			'chapter_position' => 1 );
    $query_successful = $this->db->insert('chapter', $chapter_params);
    if ($query_successful) return new Chapter($chapter_params);
    return NULL;
  }
}