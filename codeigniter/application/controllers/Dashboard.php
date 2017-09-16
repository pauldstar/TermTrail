<?php

class Dashboard extends CI_Controller {
  public $user;

  public function __construct()
  {
    parent::__construct();
    $this->load->helper('url');
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    require_once APPPATH . 'objects/Revision.php';
    require_once APPPATH . 'objects/Chapter.php';
    require_once APPPATH . 'objects/Term.php';
    require_once APPPATH . 'objects/Term_comment.php';
    $this->load->library('session');
    if (isset($_SESSION['user'])) $this->user = $_SESSION['user'];
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
    // get list of trails from user object
    $this->load->model('trail_model');
    $data['trails'] = $this->trail_model->get_main_user_trails_from_object();
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