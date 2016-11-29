<?php

class Home extends CI_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->helper('url');
    $this->load->library('session');
  }

  public function login() {
    $this->load->library('form_validation');
    $this->load->model('user_model');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    // check user details validity, before allowing access
    if ($this->form_validation->run() === FALSE) {
      $data['login_title'] = 'Login';
      $this->load->view('templates/header', $data);
      $this->load->view('home/login');
      $this->load->view('templates/footer');
    } else {
      $email = $this->input->post('email');
      $password = $this->input->post('password');
      $_SESSION['user'] = $this->user_model->get_main_user($email, $password);
      if (isset($_SESSION['user']))
        redirect('member');
      else show_error("Invalid Username/Password");
    }
  }

  public function signup() {
    $this->load->library('form_validation');
    $this->load->model('user_model');
    $this->form_validation->set_rules('username', 'Username', 'required');
    $this->form_validation->set_rules('email', 'Email', 'required');
    $this->form_validation->set_rules('scope', 'Scope', 'required');
    $this->form_validation->set_rules('password', 'Password', 'required');
    // check user details validity, before allowing access
    if ($this->form_validation->run() === FALSE) {
      $data['signup_title'] = 'Sign Up';
      $this->load->view('templates/header', $data);
      $this->load->view('home/signup');
      $this->load->view('templates/footer');
    } else {
      $_SESSION['user'] = $this->user_model->set_and_get_user();
      redirect('member');
    }
  }

  public function logout() {
    $_SESSION = array();
    $session_running = session_id() != "" || isset($_COOKIE[session_name()]);
    if ($session_running) {
      setcookie(session_name(), '', time() - 2592000, '/');
      session_destroy();
      header("Location: " . base_url('index.php/login'));
    } else
      show_error("You aren't logged in anyway mate!");
  }
}