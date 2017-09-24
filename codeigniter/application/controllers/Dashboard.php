<?php
class Dashboard extends CI_Controller 
{
  private static $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->model('user_model');
    self::$user = $this->user_model->get_user();
		if (empty(self::$user)) redirect('login');
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
    $session_ended = $this->user_model->end_user_session();
		if ($session_ended) redirect('login');
		else show_error("You aren't logged in anyway mate!");
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
		
		if ($school_id === '')
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
		
		if ($course_id === '')
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