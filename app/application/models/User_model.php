<?php
class User_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->file(APPPATH . 'objects/User.php');
    $this->load->library('session');
  }

  public function get_main_user()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $query = $this->db->query("SELECT * FROM user WHERE email='$email'");
    $row = $query->row_array();
    // if the query returns data and the password is valid, return the user
    if (isset($row) && password_verify($password, $row['password_hash']))
    {
      $_SESSION['user'] = new User($row);
      $user = $_SESSION['user'];
      // get user components
      $this->load->model('course_model');
      $has_courses = $this->course_model->get_main_user_courses();
      if ($has_courses)
      {
        $this->load->model('trail_model');
        $has_trails = $this->trail_model->get_main_user_trails();
        if ($has_trails)
        {
          $this->load->model('chapter_model');
          $has_chapters = $this->chapter_model->get_main_user_chapters();
          if ($has_chapters)
          {
            $this->load->model('term_model');
            $has_terms = $this->term_model->get_main_user_terms();
            if ($has_terms)
            {
              $this->load->model('term_comment_model');
              $this->term_comment_model->get_main_user_term_comments();
              $this->load->model('revision_model');
              $this->revision_model->get_main_user_revisions();
            }
          }
        }
      }
    }
  }

  public function get_other_user($username)
  {
    $query = $this->db->query("SELECT * FROM user WHERE username='$username'");
    $row = $query->row_array();
    if (isset($row)) return new User($row);
    return null;
  }

  public function set_and_get_user()
  {
    $password = $this->input->post('password');
    $u_password_hash = password_hash($password, PASSWORD_BCRYPT);
    $current_time = date_timestamp_get(date_create());
    // insert new user into database
    $user_params = array( 
        'username' => $this->input->post('username'), 
        'scope' => $this->input->post('scope'), 
        'password_hash' => $u_password_hash, 
        'email' => $this->input->post('email'), 
        'sign_up_time' => $current_time, 
        'last_login_time' => $current_time );
    $query_successful = $this->db->insert('user', $user_params);
    // return the new user if successfully inserted into DB
    if ($query_successful)
    {
      $user_params['user_id'] = $this->db->insert_id();
      $user_params['is_main_user'] = true;
      $user_params['has_notification'] = 'N';
      $user_params['account_balance'] = 0;
      return new User($user_params);
    }
    return null;
  }

  public function delete_user($username)
  {}
}