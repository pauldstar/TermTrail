<?php

class Member extends CI_Controller {
  public $user = null;

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH.'objects/User.php';
    require_once APPPATH.'objects/Course.php';
    require_once APPPATH.'objects/Trail.php';
    $this->load->library('session');
    if (isset($_SESSION['user'])) $this->user = $_SESSION['user'];
  }

  public function member() {
    if ($this->user == null)
      redirect('login');
    else {
      $this->load->library('form_validation');
      $this->load->model('course_model');
      $this->form_validation->set_rules('title', 'Title', 'required');
      $this->form_validation->set_rules('scope', 'Scope', 'required');
      $this->form_validation->set_rules('category', 'category', 'required');
      $this->form_validation->set_rules('education_level', 'education_level', 'required');
      // check if course form was filled
      if ($this->form_validation->run() === FALSE) {
        $this->load->view('templates/header');
        $this->load->view('home/member');
        $this->load->view('templates/footer');
      } else {
        $course = $this->course_model->set_and_get_course($this->user->user_id);
        if ($course == null)
          show_error("Couldn't save new course in database");
        else $this->user->courses[] = $course;
        redirect('member');
      }
    }
  }
}