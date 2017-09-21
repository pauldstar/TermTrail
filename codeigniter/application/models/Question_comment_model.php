<?php
class Question_comment_model extends CI_Model 
{
	private static $user;
	
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH.'objects/User.php';
    require_once APPPATH.'objects/School.php';
    require_once APPPATH.'objects/Course.php';
    require_once APPPATH.'objects/Bank.php';
    require_once APPPATH.'objects/Chapter.php';
    require_once APPPATH.'objects/Question.php';
    require_once APPPATH.'objects/Question_comment.php';
    $this->load->library('session');
    self::$user = $_SESSION['user'];
  }

  public function get_main_user_question_comments()
  {
    $query = $this->db->query(
			"SELECT * FROM question_comment WHERE question_owner_id='self::$user->user_id'");
    if (isset($query))
    {
      foreach ($query->result_array() as $row)
      {
        $question_comment = new Question_comment($row);
				$school_id = $bank->school_id;
        $course_id = $question_comment->course_id;
        $bank_id = $question_comment->bank_id;
        $chapter_id = $question_comment->chapter_id;
        $question_id = $question_comment->question_id;
        $bank =& self::$user->schools[$school_id-1]->courses[$course_id - 1]->banks[$bank_id - 1];
        $question =& $bank->chapters[$chapter_id - 1]->questions[$question_id - 1]
				$question->question_comments[] = $question_comment;
      }
    }
  }
  
  public function get_user_question_comments($user_id)
  {
    $query = $this->db->query("SELECT * FROM question_comment WHERE question_owner_id='$user_id'");
    if (isset($query)) return null;
		$question_comments = array();
		foreach ($query->result_array() as $row) $question_comments[] = new Question_comment($row);
		return $question_comments;
  }
  
  public function get_question_comments(
		$author_id, $question_owner_id, $school_id, $course_id, $bank_id, $chapter_id, $question_id)
  {
    $full_question_id = array( 
			"question_owner_id" => $question_owner_id, 
			"school_id, " => $school_id,
			"course_id" => $course_id, 
			"bank_id" => $bank_id, 
			"chapter_id" => $chapter_id, 
			"question_id" => $question_id );
    $query = $this->db->get_where('question_comment', $full_question_id);
    if (!isset($query)) return null;
		$question_comments = array();
		foreach ($query->result() as $row) 
		{
			$question_comment_params = array( 
				'author_id' => $row->author_id, 
				'question_owner_id' => $question_owner_id, 
				'course_id' => $course_id, 
				'bank_id' => $bank_id, 
				'chapter_id' => $chapter_id, 
				'question_id' => $row->question_id, 
				'comment' => $row->comment, 
				'resolved' => $row->resolved, 
				'last_edit_time' => $row->last_edit_time );
			$question_comments[] = new Question_comment($question_comment_params);
		}
		return $question_comments;
  }

  public function set_and_get_question_comment($author_id, $question_owner_id, $school_id, $course_id, 
																							 $bank_id, $chapter_id, $question_id)
  {
    $current_time = date_timestamp_get(date_create());
    $question_comment_params = array( 
			'author_id' => $user_id, 
			'question_owner_id' => $question_owner_id, 
			'school_id,' => $school_id, 
			'course_id' => $course_id, 
			'bank_id' => $bank_id, 
			'chapter_id' => $chapter_id, 
			'question_id' => $question_id, 
			'comment' => $this->input->post('comment'), 
			'last_edit_time' => $current_time );
    $query_successful = $this->db->insert('question_comment', $question_comment_params);
    if (!$query_successful) return null;
		$question_comment_params['resolved'] = 'N';
		return new Question_comment($question_comment_params);
  }
}