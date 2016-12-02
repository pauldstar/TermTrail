<?php
class Test extends CI_Controller {
  public $user = null;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('form_validation');
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    $this->load->library('session');
    if (isset($_SESSION['user'])) $this->user = $_SESSION['user'];
    else redirect('login');
  }

  public function add_course()
  {
    $this->load->model('course_model');
    $this->form_validation->set_rules('trail_title', 'Title', 
        'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('category', 'Category', 
        'required');
    $this->form_validation->set_rules('education_level', 
        'Education_level', 'required');
    // check if course form was filled
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('templates/header');
      $this->load->view('test/add_course');
      $this->load->view('templates/footer');
    }
    else {
      $course = $this->course_model->set_and_get_course(
          $this->user->user_id);
      if ($course == null) show_error(
          "Couldn't save new course in database");
      else $this->user->courses[] = $course;
      redirect('member');
    }
  }

  public function add_trail()
  {
    $this->load->model('trail_model');
    $this->form_validation->set_rules('trail_title', 'Title', 
        'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 
        'required');
    // check if course form was filled
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('templates/header');
      $this->load->view('test/add_trail');
      $this->load->view('templates/footer');
    }
    else {
      $trail = $this->trail_model->set_and_get_trail(
          $this->user->user_id, 'origin');
      if ($trail == null) show_error(
          "Couldn't save new trail in database");
      else $this->user->courses[$course_id - 1]->trails[] = $trail;
      redirect('member');
    }
  }

  public function add_chapter()
  {
    $this->load->model('chapter_model');
    $this->form_validation->set_rules('chapter_title', 'Title', 
        'required');
    $this->form_validation->set_rules('trail_id', 'Trail_ID', 
        'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 
        'required');
    // check if course form was filled
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('templates/header');
      $this->load->view('test/add_chapter');
      $this->load->view('templates/footer');
    }
    else {
      $chapter = $this->chapter_model->set_and_get_chapter(
          $this->user->user_id);
      if ($chapter == null) show_error(
          "Couldn't save new chapter in database");
      else $this->user->courses[$course_id - 1]->trails[$trail_id - 1]->chapters[] = $chapter;
      redirect('member');
    }
  }

  public function add_term()
  {
    $this->load->model('term_model');
    $this->form_validation->set_rules('term_position', 'Position', 
        'required');
    $this->form_validation->set_rules('content', 'Content', 
        'required');
    $this->form_validation->set_rules('chapter_id', 'Chapter_ID', 
        'required');
    $this->form_validation->set_rules('trail_id', 'Trail_ID', 
        'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 
        'required');
    // check if course form was filled
    if ($this->form_validation->run() === FALSE) {
      $this->load->view('templates/header');
      $this->load->view('test/add_term');
      $this->load->view('templates/footer');
    }
    else {
      $term = $this->chapter_model->set_and_get_term(
          $this->user->user_id);
      if ($term == null) show_error(
          "Couldn't save new term in database");
      else $this->user->courses[$course_id - 1]->trails[$trail_id - 1]->chapters[$chapter_id - 1]->terms[] = $term;
redirect('member');
}
}

public function add_term_comment()
{}
}