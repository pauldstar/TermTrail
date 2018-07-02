<?php
class Question_model extends TL_Model
{
	public function set_session_questions()
	{
		$questions = self::get_db_questions();
		if ($questions !== NULL)
		{
			foreach ($questions as $question)
			{
				$school_id = $question->school_id;
				$course_id = $question->course_id;
				$bank_id = $question->bank_id;
				$chapter_id = $question->chapter_id;
				self::$user->schools[$school_id-1]->courses[$course_id-1]->
					banks[$bank_id-1]->chapters[$chapter_id-1]->questions[] = $question;
			}
		}
	}
	
  public function get_session_questions($full_parent_id)
  {
		$school_id =  $full_parent_id['school_id'];
		$course_id =  $full_parent_id['course_id'];
		$bank_id =  $full_parent_id['bank_id'];
		$chapter_id =  $full_parent_id['chapter_id'];
		return self::$user->schools[$school_id-1]->
			courses[$course_id-1]->banks[$bank_id-1]->chapters[$chapter_id-1]->questions;
  }
	
	public function get_single_session_question($full_parent_id)
  {
		$school_id =  $full_parent_id['school_id'];
		$course_id =  $full_parent_id['course_id'];
		$bank_id =  $full_parent_id['bank_id'];
		$chapter_id =  $full_parent_id['chapter_id'];
		$question_id = $full_parent_id['question_id'];
		return self::$user->schools[$school_id-1]->courses[$course_id-1]->
			banks[$bank_id-1]->chapters[$chapter_id-1]->questions[$question_id-1];
  }
		
  public function get_db_questions($user_id = '')
  {
		if (empty($user_id)) $user_id = self::$user->user_id;
		$query = $this->db->query("SELECT * FROM question WHERE owner_id='{$user_id}'");
    if ( ! isset($query)) return NULL;
		$questions = array();
		foreach ($query->result_array() as $row) { $questions[] = new Question($row);
		var_dump($row);  }
		return $questions;
  }
	
  public function get_chapter_questions(
		$user_id, $school_id, $course_id, $bank_id, $chapter_id, $is_main_user)
  {
    $full_chapter_id = array( 
			"owner_id" => $user_id, 
			"school_id" => $school_id, 
			"course_id" => $course_id, 
			"bank_id" => $bank_id, 
			"chapter_id" => $chapter_id );
    $query = $this->db->get_where('question', $full_chapter_id);
    if ( ! isset($query)) return NULL;
		$questions = array();
		foreach ($query->result_array() as $row) $questions[] = new Question($row);
		return $questions;
  }

  public function set_and_get_question($author_id, $school_id, $course_id, $bank_id, $chapter_id)
  {
    $question_id = 1 + sizeof(self::$user->schools[$school_id-1]->
			courses[$course_id-1]->banks[$bank_id-1]->chapters[$chapter_id-1]->questions);
    $current_time = date_timestamp_get(date_create());
    $question_params = array( 
			'owner_id' => self::$user->user_id, 
			'school_id' => $this->input->post('school_id'), 
			'course_id' => $this->input->post('course_id'), 
			'bank_id' => $this->input->post('bank_id'), 
			'chapter_id' => $this->input->post('chapter_id'), 
			'question_id' => $question_id, 
			'author_id' => $author_id, 
			'question_position' => $this->input->post('question_position'), 
			'question' => $this->input->post('question'), 
			'answer' => $this->input->post('answer'), 
			'hint' => $this->input->post('hint'), 
			'last_edit_time' => $current_time 
		);
    $query_successful = $this->db->insert('question', $question_params);
    if ( ! $query_successful) return NULL;
		$question_params['revision_state'] = 'pending';
		$question_params['confidence_score'] = 0;
		$question_params['is_main_user'] = TRUE;
		return new Question($question_params);
  }
}