<?php
class Test extends CI_Controller {
  public $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('form_validation');
    // object classes are needed to serialise the objects stored in session
    $this->load->file(APPPATH . 'objects/User.php'); 
    $this->load->file(APPPATH . 'objects/Course.php');
    $this->load->file(APPPATH . 'objects/Trail.php');
    $this->load->file(APPPATH . 'objects/Chapter.php');
    $this->load->file(APPPATH . 'objects/Term.php');
    $this->load->file(APPPATH . 'objects/Term_Comment.php');
    //require_once APPPATH . 'objects/Term_comment.php';
    $this->load->library('session');
    if (isset($_SESSION['user'])) $this->user = $_SESSION['user'];
    else redirect('login');
  }

  public function add_course()
  {
    $this->load->model('course_model');
    $this->form_validation->set_rules('course_title', 'Title', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('category', 'Category', 'required');
    $this->form_validation->set_rules('education_level', 'Education_level', 'required');
    // check if course form was filled
    if ($this->form_validation->run() === false) {
      $this->load->view('templates/header');
      $this->load->view('test/add_course');
      $this->load->view('templates/footer');
    }
    else {
      $course = $this->course_model->set_and_get_course('origin');
      if ($course === null) show_error("Couldn't save new course in database");
      else $this->user->courses[] = $course;
      redirect('member');
    }
  }

  public function add_trail()
  {
    $this->load->model('trail_model');
    $this->form_validation->set_rules('trail_title', 'Title', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
    // check if course form was filled
    if ($this->form_validation->run() === false) {
      $this->load->view('templates/header');
      $this->load->view('test/add_trail');
      $this->load->view('templates/footer');
    }
    else {
      $course_id = $this->input->post('course_id');
      $trail = $this->trail_model->set_and_get_trail($course_id, 'origin');
      if ($trail == null) show_error("Couldn't save new trail in database");
      else $this->user->courses[$course_id - 1]->trails[] = $trail;
      redirect('member');
    }
  }

  public function add_chapter()
  {
    $this->load->model('chapter_model');
    $this->form_validation->set_rules('chapter_title', 'Title', 'required');
    $this->form_validation->set_rules('trail_id', 'Trail_ID', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
    // check if course form was filled
    if ($this->form_validation->run() === false) {
      $this->load->view('templates/header');
      $this->load->view('test/add_chapter');
      $this->load->view('templates/footer');
    }
    else {
      $course_id = $this->input->post('course_id');
      $trail_id = $this->input->post('trail_id');
      $chapter = $this->chapter_model->set_and_get_chapter($this->user->user_id, $course_id, 
          $trail_id);
      if ($chapter == null) show_error("Couldn't save new chapter in database");
      else $this->user->courses[$course_id - 1]->trails[$trail_id - 1]->chapters[] = $chapter;
      redirect('member');
    }
  }

  public function add_term()
  {
    $this->load->model('term_model');
    $this->form_validation->set_rules('term_position', 'Position', 'required');
    $this->form_validation->set_rules('content', 'Content', 'required');
    $this->form_validation->set_rules('chapter_id', 'Chapter_ID', 'required');
    $this->form_validation->set_rules('trail_id', 'Trail_ID', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
    // check if course form was filled
    if ($this->form_validation->run() === false) {
      $this->load->view('templates/header');
      $this->load->view('test/add_term');
      $this->load->view('templates/footer');
    }
    else {
      $course_id = $this->input->post('course_id');
      $trail_id = $this->input->post('trail_id');
      $chapter_id = $this->input->post('chapter_id');
      $term = $this->term_model->set_and_get_term($this->user->user_id, $course_id, 
          $trail_id, $chapter_id);
      if ($term == null) show_error("Couldn't save new term in database");
      else {
        $trail = & $this->user->courses[$course_id - 1]->trails[$trail_id - 1];
        $trail->chapters[$chapter_id - 1]->terms[] = $term;
      }
      redirect('member');
    }
  }

  public function add_term_comment()
  {
    $this->load->model('term_comment_model');
    $this->form_validation->set_rules('term_owner_id', 'Owner_ID', 'required');
    $this->form_validation->set_rules('course_id', 'Course_ID', 'required');
    $this->form_validation->set_rules('trail_id', 'Trail_ID', 'required');
    $this->form_validation->set_rules('chapter_id', 'Chapter_ID', 'required');
    $this->form_validation->set_rules('term_id', 'Term_ID', 'required');
    $this->form_validation->set_rules('comment', 'Comment', 'required');
    // check if course form was filled
    if ($this->form_validation->run() === false) {
      $this->load->view('templates/header');
      $this->load->view('test/add_term_comment');
      $this->load->view('templates/footer');
    }
    else {
      $owner_id = $this->input->post('term_owner_id');
      $course_id = $this->input->post('course_id');
      $trail_id = $this->input->post('trail_id');
      $chapter_id = $this->input->post('chapter_id');
      $term_id = $this->input->post('term_id');
      $term_comment = $this->term_comment_model->set_and_get_term_comment(
          $this->user->user_id, $owner_id, $course_id, $trail_id, $chapter_id, $term_id);
      if ($term_comment == null) show_error("Couldn't save new term in database");
      else {
        if ($owner_id == $this->user->user_id) {
          $trail = & $this->user->courses[$course_id - 1]->trails[$trail_id - 1];
          $trail->chapters[$chapter_id - 1]->terms[$term_id - 1]->term_comments[] = $term_comment;
        }
      }
      redirect('member');
    }
  }
}