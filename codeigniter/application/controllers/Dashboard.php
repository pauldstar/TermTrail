<?php

class Dashboard extends CI_Controller 
{
  private static $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH.'objects/User.php';
    require_once APPPATH.'objects/School.php';
    require_once APPPATH.'objects/Course.php';
    require_once APPPATH.'objects/Bank.php';
    require_once APPPATH.'objects/Revision.php';
    require_once APPPATH.'objects/Chapter.php';
    require_once APPPATH.'objects/Question.php';
    require_once APPPATH.'objects/Question_comment.php';
    require_once APPPATH.'objects/Gridbox.php';
    $this->load->library('session');
    if (isset($_SESSION['user'])) self::$user = $_SESSION['user'];
    else redirect('login');
  }

  public function landing()
  {
    $this->load->view('landing/header_ld');
    $this->load->view('landing/index_ld');
    $this->load->view('landing/footer_ld');
  }

  public function dashboard()
  {
		$this->load->helper('url');
		$this->load->helper('html');
    $this->load->view('dashboard/header');
    $this->load->view('dashboard/navbar');
    $this->load->view('dashboard/sidebar');
    $this->load->view('dashboard/toolbar');
    $this->load->view('dashboard/page-content');
    $this->load->view('dashboard/popup');
    $this->load->view('dashboard/scripts');
    $this->load->view('dashboard/footer');
  }
	
  public function logout()
  {
    $_SESSION = array();
    $session_running = session_id() != "" || isset($_COOKIE[session_name()]);
    if ($session_running)
    {
      setcookie(session_name(), '', time() - 2592000, '/');
      session_destroy();
      redirect('login');
    }
    else show_error("You aren't logged in anyway mate!");
  }
	
	public function ajax_get_grid($section, $parent_id = '')
	{
		$this->load->model($grid_title.'_model', 'item_model');
		
		$items;
		$section_type;
		$grid = array();
		$gridbox_params = array();
		
		if ($parent_id == '')
		{
			$section_type = 'general';
			$items = self::get_user_items_session($section);
		}
		else
		{
			$section_type = 'specific';
			$items = self::get_user_items_session($section, $parent_id);
		}
		
		foreach ($items as $index => $item)
		{
			$gridbox_params['section'] = $section;
			$gridbox_params['section_type'] = $section_type;
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['title'] = self::get_item_title($section, $item);
			$gridbox_params['parent_label'] = 'Course';
			$gridbox_params['parent_name'] = 
				self::$user->schools[$bank->school_id - 1]->courses[$bank->course_id - 1]->course_title;
			$gridbox_params['child_label'] = 'Chapters';
			$gridbox_params['child_count'] = sizeof($bank->chapters);
			$gridbox_params['source_type'] = $bank->bank_type;
			$gridbox_params['comment_count'] = 0;
			
			$data['gridbox'] = new Gridbox($section, $section_type, $item, $index+1);
			$grid[] = $this->load->view('dashboard/gridbox', $data, TRUE);
		}
		
		echo json_encode($grid);
	}
	
	private function get_user_items_session($item_title)
	{
		
	}
	
	private function get_item_title($item_title)
	{
		
	}
	
	public function ajax_get_school_grid()
	{
		$this->load->model('school_model');
		
		$school_grid = array();
		$gridbox_params = array();
		$section_type = 'specific';
		$schools = self::$user->schools;
		
		foreach ($schools as $index => $school)
		{
			$gridbox_params['section'] = 'schools';
			$gridbox_params['section_type'] = $section_type;
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['title'] = $school->school_title;
			$gridbox_params['child_label'] = 'Courses';
			$gridbox_params['child_count'] = sizeof($school->courses);
			$gridbox_params['source_type'] = $school->school_type;
			$gridbox_params['comment_count'] = 0;
			
			$data['gridbox'] = new Gridbox($gridbox_params);
			$school_grid[] = $this->load->view('dashboard/gridbox', $data, TRUE);
		}
		
		echo json_encode($school_grid);
	}
	
	public function ajax_get_course_grid($school_id = '')
	{
		$this->load->model('course_model');
		
		$courses;
		$section_type;
		$course_grid = array();
		$gridbox_params = array();
		
		if ($school_id == '')
		{
			$section_type = 'general';
			$courses = $this->course_model->get_user_courses_session();
		}
		else
		{
			$section_type = 'specific';
			$courses = $this->course_model->get_user_courses_session($school_id);
		}
		
		foreach ($courses as $index => $course)
		{
			$gridbox_params['section'] = 'courses';
			$gridbox_params['section_type'] = $section_type;
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['title'] = $course->course_title;
			$gridbox_params['parent_label'] = 'Course';
			$gridbox_params['parent_name'] = 
				self::$user->schools[$course->school_id - 1]->school_title;
			$gridbox_params['child_label'] = 'Banks';
			$gridbox_params['child_count'] = sizeof($course->banks);
			$gridbox_params['source_type'] = $course->course_type;
			$gridbox_params['comment_count'] = 0;
			
			$data['gridbox'] = new Gridbox($gridbox_params);
			$course_grid[] = $this->load->view('dashboard/gridbox', $data, TRUE);
		}
		
		echo json_encode($course_grid);
	}

	public function ajax_get_bank_grid($course_id = '')
	{
		$this->load->model('bank_model');
		
		$banks;
		$section_type;
		$bank_grid = array();
		$gridbox_params = array();
		
		if ($course_id == '')
		{
			$section_type = 'general';
			$banks = $this->bank_model->get_user_banks_session();
		}
		else
		{
			$section_type = 'specific';
			$banks = $this->bank_model->get_user_banks_session($course_id);
		}
		
		foreach ($banks as $index => $bank)
		{
			$gridbox_params['section'] = 'banks';
			$gridbox_params['section_type'] = $section_type;
			$gridbox_params['gridbox_number'] = $index + 1;
			$gridbox_params['title'] = $bank->bank_title;
			$gridbox_params['parent_label'] = 'Course';
			$gridbox_params['parent_name'] = 
				self::$user->schools[$bank->school_id - 1]->courses[$bank->course_id - 1]->course_title;
			$gridbox_params['child_label'] = 'Chapters';
			$gridbox_params['child_count'] = sizeof($bank->chapters);
			$gridbox_params['source_type'] = $bank->bank_type;
			$gridbox_params['comment_count'] = 0;
			
			$data['gridbox'] = new Gridbox($gridbox_params);
			$bank_grid[] = $this->load->view('dashboard/gridbox', $data, TRUE);
		}
		
		echo json_encode($bank_grid);
	}
}