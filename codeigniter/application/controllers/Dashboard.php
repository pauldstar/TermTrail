<?php

class Dashboard extends CI_Controller 
{
  private static $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    // object classes are needed to serialise the objects stored in session
    $this->load->file(APPPATH . 'objects/User.php';
    $this->load->file(APPPATH . 'objects/Course.php';
    $this->load->file(APPPATH . 'objects/Bank.php';
    $this->load->file(APPPATH . 'objects/Revision.php';
    $this->load->file(APPPATH . 'objects/Chapter.php';
    $this->load->file(APPPATH . 'objects/Question.php';
    $this->load->file(APPPATH . 'objects/Question_comment.php';
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
  {	// get list of banks from user object
    $this->load->model('bank_model');
    $data['banks'] = $this->bank_model->get_user_banks_session();
    $this->load->view('dashboard/header-db', $data);
    $this->load->view('dashboard/navbar-db');
    $this->load->view('dashboard/sidebar-db');
    $this->load->view('dashboard/toolbar-db');
    $this->load->view('dashboard/page-content-db');
    $this->load->view('dashboard/popup-db');
    $this->load->view('dashboard/footer-db');
  }

  public function logout()
  {
    $_SESSION = array();
    $session_running = session_id() != "" || isset($_COOKIE[session_name()]);
    if ($session_running)
    {
      setcookie(session_name(), '', time() - 2592000, '/');
      session_destroy();
      header("Location: " . base_url('index.php/login'));
    }
    else
      show_error("You aren't logged in anyway mate!");
  }
}