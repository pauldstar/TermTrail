<?php

class Home extends CI_Controller {

  public function index($action) {
    $this->load->library('form_validation');
    $this->load->model('user_model');
	// if action = login, check user details validity, before allowing access
    if (strcmp($action, 'login') == 0) {
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      if ($this->form_validation->run() === FALSE)
        Home::load_login_view();
      else {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $_SESSION['user'] = $this->user_model->get_main_user($email, $password);
		if ($_SESSION['user'] == null) show_error("Invalid Username/Password");
        Home::load_member_view();
      } // if action = signup, check validity, b4 saving in DB, and allowing access
    } elseif (strcmp($action, 'signup') == 0) {
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('email', 'Email', 'required');
      $this->form_validation->set_rules('scope', 'Scope', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      if ($this->form_validation->run() === FALSE) {
        $data['signup_title'] = 'Sign-Up';
        $this->load->view('templates/header', $data);
        $this->load->view('home/signup');
        $this->load->view('templates/footer');
      } else {
        $_SESSION['user'] = $this->user_model->set_and_get_new_user();
        Home::load_member_view();
      }
    }
  }

  private function load_login_view() {
    $data['login_title'] = 'Login';
    $this->load->view('templates/header', $data);
    $this->load->view('home/login');
    $this->load->view('templates/footer');
  }

  private function load_member_view() {
    $this->load->view('templates/header');
    $this->load->view('home/member');
    $this->load->view('templates/footer');
  }

  public function logout() {
    $this->load->helper('url');
    $_SESSION = array();
    $session_running = session_id() != "" || isset($_COOKIE[session_name()]);
    if ($session_running) setcookie(session_name(), '', time() - 2592000, '/');
    session_destroy();
    header("Location: " . base_url('index.php/login'));
  }
}