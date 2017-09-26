<?php
class User_model extends MY_Model 
{
  public function get_user($user_id = '')
  {
		if (empty($user_id)) return self::$user;
		$query = $this->db->query("SELECT * FROM user WHERE username='{$user_id}'");
    $row = $query->row_array();
    if (isset($row)) return new User($row);
    return NULL;
  }
	
  public function set_session_user()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
		
    $query = $this->db->query("SELECT * FROM user WHERE email='{$email}'");
    $row = $query->row_array();
		
    if (isset($row) && password_verify($password, $row['password_hash']))
    { // get user components
      self::$user = $_SESSION['user'] = new User($row);
      $this->load->model('school_model');
			$this->school_model->set_session_schools();
			return TRUE;
    }
		return FALSE;
  }
	
  public function set_and_get_user()
  { // new sign up
    $password = $this->input->post('password');
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $current_time = date_timestamp_get(date_create());
		
    $user_params = array( 
			'username' => $this->input->post('username'), 
			'scope' => $this->input->post('scope'), 
			'password_hash' => $password_hash, 
			'email' => $this->input->post('email'), 
			'sign_up_time' => $current_time, 
			'last_login_time' => $current_time );
			
    $query_successful = $this->db->insert('user', $user_params);
    if ( ! $query_successful) return FALSE;
		
		$user_params['user_id'] = $this->db->insert_id();
		$user_params['has_notification'] = 'N';
		$user_params['account_balance'] = 0;
		$_SESSION['user'] = new User($user_params);
		
		return TRUE;
  }

	public function end_user_session()
	{
		$_SESSION = array();
    $session_running = session_id() != "" || isset($_COOKIE[session_name()]);
    if ($session_running)
    {
			session_unset(); 
			//setcookie(session_name(), '', time() - 2592000, '/');
      session_destroy();
			return TRUE;
    }
		return FALSE;
	}
}