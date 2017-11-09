<?php
class Test extends CI_Controller 
{
  private static $user;
	private static $view_data = array();

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('form_validation');
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH.'objects/User.php';
    require_once APPPATH.'objects/School.php';
    require_once APPPATH.'objects/Course.php';
    require_once APPPATH.'objects/Bank.php';
    require_once APPPATH.'objects/Chapter.php';
    require_once APPPATH.'objects/Question.php';
    // require_once APPPATH.'objects/Question_comment.php';
    $this->load->library('session');
    if (isset($_SESSION['user'])) self::$user = $_SESSION['user'];
    else redirect('login');
		self::$view_data['formsuccess'] = '';
  }

  public function test_body()
  {
    $this->load->view('templates/header');
    $this->load->view('test/test_user');
    $this->load->view('templates/footer');
  }
  
  public function test_banks()
  {
    $this->load->model('bank_model');
    $data['banks'] = $this->bank_model->get_main_user_banks_session();
    $this->load->view('dashboard/header_db');
    $this->load->view('test/test_banks', $data);
    $this->load->view('dashboard/footer_db');
  }
	
	public function add_school()
  {
		$this->load->model('school_model');
    $this->form_validation->set_rules('school_title', 'Title', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('education_level', 'Education Level', 'required');
    if ($this->form_validation->run() === TRUE)
    {
      $school = $this->school_model->set_and_get_school('origin');
      if ($school === NULL) show_error("Couldn't save new school in database");
      else 
			{
				self::$user->schools[] = $school;
				self::$view_data['formsuccess'] = 
					"<h3>Successfully added school: ".$school->school_title."</h3><br/>";
			}
    }
		$this->load->view('templates/header');
		$this->load->view('test/add_school', self::$view_data);
    $this->load->view('templates/footer');
  }

  public function add_course()
  {
		$this->load->model('course_model');
    $this->form_validation->set_rules('course_title', 'Title', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('school_id', 'School_ID', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');
		if ($this->form_validation->run() === TRUE)
    {
      $school_id = $this->input->post('school_id');
			$course = $this->course_model->set_and_get_course($school_id, 'origin');
      if ($course === NULL) show_error("Couldn't save new course in database");
      else 
			{
				self::$user->schools[$school_id-1]->courses[] = $course;
				self::$view_data['formsuccess'] = 
					"<h3>Successfully added course: ".$course->course_title."</h3><br/>";
			}
    }
		$this->load->view('templates/header');
		$this->load->view('test/add_course', self::$view_data);
    $this->load->view('templates/footer');
  }

  public function add_bank()
  {
    $this->load->model('bank_model');
    $this->form_validation->set_rules('bank_title', 'Title', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('school_id', 'School_ID', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
		if ($this->form_validation->run() === TRUE)
    {
      $school_id = $this->input->post('school_id');
      $course_id = $this->input->post('course_id');
      $bank = $this->bank_model->set_and_get_bank($school_id, $course_id, 'origin');
      if ($bank === NULL) show_error("Couldn't save new bank in database");
      else 
			{
				self::$user->schools[$school_id-1]->courses[$course_id-1]->banks[] = $bank;
				self::$view_data['formsuccess'] = 
					"<h3>Successfully added Bank: ".$bank->bank_title."</h3><br/>";
			}
    }
		$this->load->view('templates/header');
		$this->load->view('test/add_bank', self::$view_data);
    $this->load->view('templates/footer');
  }

  public function add_chapter()
  {
    $this->load->model('chapter_model');
		$this->form_validation->set_rules('chapter_title', 'Title', 'required');
    $this->form_validation->set_rules('school_id', 'School_ID', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
    $this->form_validation->set_rules('bank_id', 'Bank_ID', 'required');
		if ($this->form_validation->run() === TRUE)
    {
      $school_id = $this->input->post('school_id');
      $course_id = $this->input->post('course_id');
      $bank_id = $this->input->post('bank_id');
			$chapter = $this->chapter_model->set_and_get_chapter($school_id, $course_id, $bank_id);
      if ($chapter === NULL) show_error("Couldn't save new chapter in database");
      else 
			{
				self::$user->schools[$school_id-1]->courses[$course_id-1]->
					banks[$bank_id-1]->chapters[] = $chapter;
				self::$view_data['formsuccess'] = 
					"<h3>Successfully added Chapter: ".$chapter->chapter_title."</h3><br/>";
			}
    }
		$this->load->view('templates/header');
		$this->load->view('test/add_chapter', self::$view_data);
    $this->load->view('templates/footer');
  }

  public function add_question()
  {
    $this->load->model('question_model');
    $this->form_validation->set_rules('question_position', 'Position', 'required');
    $this->form_validation->set_rules('content', 'Content', 'required');
    $this->form_validation->set_rules('school_id', 'School_ID', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
    $this->form_validation->set_rules('bank_id', 'Bank_ID', 'required');
    $this->form_validation->set_rules('chapter_id', 'Chapter_ID', 'required');
		if ($this->form_validation->run() === TRUE)
    {
      $school_id = $this->input->post('school_id');
      $course_id = $this->input->post('course_id');
      $bank_id = $this->input->post('bank_id');
      $chapter_id = $this->input->post('chapter_id');
			$question = $this->question_model->set_and_get_question(
				self::$user->user_id, $school_id, $course_id, $bank_id, $chapter_id);
      if ($question === NULL) show_error("Couldn't save new question in database");
      else 
			{
				self::$user->schools[$school_id-1]->courses[$course_id-1]->
					banks[$bank_id-1]->chapters[$chapter_id-1]->questions[] = $question;
				self::$view_data['formsuccess'] = 
					"<h3>Successfully added Question: ".$question->content."</h3><br/>";
			}
    }
		$this->load->view('templates/header');
		$this->load->view('test/add_question', self::$view_data);
    $this->load->view('templates/footer');
  }
	
	/*public function add_question_comment()
  {
    $this->load->model('question_comment_model');
    $this->form_validation->set_rules('question_owner_id', 'Owner_ID', 'required');
    $this->form_validation->set_rules('school_id', 'School_ID', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
    $this->form_validation->set_rules('bank_id', 'Bank_ID', 'required');
    $this->form_validation->set_rules('chapter_id', 'Chapter_ID', 'required');
    $this->form_validation->set_rules('question_id', 'Question_ID', 'required');
    $this->form_validation->set_rules('comment', 'Comment', 'required');
		if ($this->form_validation->run() === TRUE)
    {
      $school_id = $this->input->post('school_id');
      $course_id = $this->input->post('course_id');
      $bank_id = $this->input->post('bank_id');
      $chapter_id = $this->input->post('chapter_id');
      $question_id = $this->input->post('question_id');
      $question_comment = $this->question_comment_model->set_and_get_question_comment(
          self::$user->user_id, $owner_id, $course_id, $bank_id, $chapter_id, $question_id);
      if ($question_comment === NULL) show_error("Couldn't save new bank in database");
      else 
			{
				$bank =& self::$user->schools[$school_id-1]->courses[$course_id-1]->bank[$bank_id - 1];
				$bank->chapters[$chapter_id-1]->questions[] = $question;
				self::$view_data['formsuccess'] = 
					"<h3>Successfully added Comment: ".$question_comment['comment']."</h3><br/>";
			}
    }
		$this->load->view('templates/header');
		$this->load->view('test/add_question_comment',self::$view_data);
    $this->load->view('templates/footer');
  }*/
}
