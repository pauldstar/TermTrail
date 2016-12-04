<?php
class User_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/User.php';
  }

  public function get_main_user()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $query = $this->db->query("SELECT * FROM user WHERE email='$email'");
    $row = $query->row();
    // if the query returns data and the password is valid, return the user
    if (isset($row) && password_verify($password, $row->password_hash)) {
      $user_params = array( 
          "user_id" => $row->user_id, 
          "username" => $row->username, 
          "email" => $row->email, 
          "scope" => $row->scope, 
          "account_balance" => $row->account_balance, 
          "sign_up_time" => $row->sign_up_time, 
          "last_login_time" => $row->last_login_time, 
          "has_notification" => $row->has_notification, 
          "is_main_user" => TRUE );
      return new User($user_params);
    }
    return null;
  }

  public function get_other_user($username)
  {
    $query = $this->db->query("SELECT * FROM user WHERE username='$username'");
    $row = $query->result();
    $user_params = array( 
        "user_id" => $row->user_id, 
        "username" => $row->username, 
        "account_balance" => $row->account_balance, 
        "sign_up_time" => $row->sign_up_time, 
        "last_login_time" => $row->last_login_time, 
        "has_notification" => $row->has_notification, 
        "is_main_user" => FALSE );
    return new User($user_params);
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
    if ($query_successful) {
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