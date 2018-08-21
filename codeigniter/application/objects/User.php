<?php
class User 
{
  public $user_id; 
	public $account_balance; 
	public $email; 
	public $username; 
	public $scope;
  public $sign_up_time; 
	public $last_login_time; 
	public $has_notification;
  public $schools;

  public function __construct($params)
  {
    $this->user_id = $params['user_id'];
    $this->username = $params['username'];
    $this->account_balance = $params['account_balance'];
    $this->sign_up_time = $params['sign_up_time'];
    $this->last_login_time = $params['last_login_time'];
    $this->has_notification = $params['has_notification'];
    $this->schools = array();
  }
}