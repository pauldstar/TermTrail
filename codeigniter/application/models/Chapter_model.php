<?php
class Chapter_model extends CI_Model 
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
    $this->load->library('session');
    self::$user = $_SESSION['user'];
  }

  public function get_user_chapters_db($user_id = '')
  {
		if (empty($user_id)) $user_id = self::$user->user_id;
    $query = $this->db->query("SELECT * FROM chapter WHERE owner_id='$user_id'");
    if (!isset($query)) return null;
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
    if (!$query != null) return null;
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
    return null;
  }
}