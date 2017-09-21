<?php
class User_model extends CI_Model 
{
  private static $user;
	
	public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->file(APPPATH.'objects/User.php');
    $this->load->library('session');
  }

  public function setup_user_session()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $query = $this->db->query("SELECT * FROM user WHERE email='$email'");
    $row = $query->row_array();
    if (isset($row) && password_verify($password, $row['password_hash']))
    { // get user components
      self::$user = $_SESSION['user'] = new User($row);
			
      $this->load->model('school_model');
			$schools = $this->school_model->get_user_schools_db();
      if ($schools == null) return;
			self::add_component_to_session('schools', $schools);
			
      $this->load->model('course_model');
			$courses = $this->course_model->get_user_courses_db();
			if ($courses == null) return;
			self::add_component_to_session('courses', $courses);
			
			$this->load->model('bank_model');
			$banks = $this->bank_model->get_user_banks_db();
			if ($banks == null) return;
			self::add_component_to_session('banks', $banks);
			
			$this->load->model('chapter_model');
			$chapters = $this->chapter_model->get_user_chapters_db();
			if ($chapters == null) return;
			self::add_component_to_session('chapters', $chapters);
			
			$this->load->model('question_model');
			$questions = $this->question_model->get_user_questions_db();
			if ($questions == null) return;
			self::add_component_to_session('questions', $questions);
			
			/* if (!$has_questions) return;
			$this->load->model('question_comment_model');
			$this->question_comment_model->get_main_user_question_comments() */;
    }
  }

	private static function add_component_to_session($name, $array)
	{
		switch ($name)
		{
			case 'schools':
				foreach ($array as $school) self::$user->schools[] = $school;
				break;
			case 'courses':
				foreach ($array as $course)
				{
					$school_id = $course->school_id;
					self::$user->schools[$school_id-1]->courses[] = $course;
				}
				break;
			case 'banks':
				foreach ($array as $bank)
				{
					$school_id = $bank->school_id;
					$course_id = $bank->course_id;
					self::$user->schools[$school_id-1]->
						courses[$course_id-1]->banks[] = $bank;
				}
				break;
			case 'chapters':
				foreach ($array as $chapter)
				{
					$school_id = $chapter->school_id;
					$course_id = $chapter->course_id;
					$bank_id = $chapter->bank_id;
					self::$user->schools[$school_id-1]->
						courses[$course_id-1]->banks[$bank_id-1]->chapters[] = $chapter;
				}
				break;
			case 'questions':
			  foreach ($array as $question)
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
	
  public function get_user($user_id)
  {
    $query = $this->db->query("SELECT * FROM user WHERE username='$user_id'");
    $row = $query->row_array();
    if (isset($row)) return new User($row);
    return null;
  }

  public function set_and_get_user()
  { // new sign up
    $password = $this->input->post('password');
    $u_password_hash = password_hash($password, PASSWORD_BCRYPT);
    $current_time = date_timestamp_get(date_create());
    $user_params = array( 
			'username' => $this->input->post('username'), 
			'scope' => $this->input->post('scope'), 
			'password_hash' => $u_password_hash, 
			'email' => $this->input->post('email'), 
			'sign_up_time' => $current_time, 
			'last_login_time' => $current_time );
    $query_successful = $this->db->insert('user', $user_params);
    if (!$query_successful) return null;
		$user_params['user_id'] = $this->db->insert_id();
		$user_params['is_main_user'] = true;
		$user_params['has_notification'] = 'N';
		$user_params['account_balance'] = 0;
		return new User($user_params);
  }

  public function delete_user($username)
  {}
}