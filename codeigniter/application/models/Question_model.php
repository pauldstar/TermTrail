<?php
class Question_model extends CI_Model
{
	private static $user;
		
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/School.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Bank.php';
    require_once APPPATH . 'objects/Chapter.php';
    require_once APPPATH . 'objects/Question.php';
    $this->load->library('session');
		self::$user = $_SESSION['user'];
  }

  public function get_user_questions_db($user_id = '')
  {
		if (empty($user_id)) $user_id = self::$user->user_id;
		$query = $this->db->query("SELECT * FROM question WHERE owner_id='$user_id'");
    if (!isset($query)) return null;
		$questions = array();
		foreach ($query->result_array() as $row) $questions[] = new Question($row);
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
    if ($query == null) return null;
		$questions = array();
		foreach ($query->result_array() as $row) $questions[] = new Question($row);
		return $questions;
  }

  public function set_and_get_question($author_id, $school_id, $course_id, $bank_id, $chapter_id)
  {
    $question_id = 1 + sizeof(self::$user->schools[$school_id-1]->courses[$course_id-1]->
															banks[$bank_id-1]->chapters[$chapter_id-1]->questions);
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
			'content' => $this->input->post('content'), 
			'answer' => $this->input->post('answer'), 
			'hint' => $this->input->post('hint'), 
			'last_edit_time' => $current_time );
    $query_successful = $this->db->insert('question', $question_params);
    if (!$query_successful) return null;
		$question_params['revision_state'] = 'pending';
		$question_params['confidence_score'] = 0;
		$question_params['is_main_user'] = true;
		return new Question($question_params);
  }
}