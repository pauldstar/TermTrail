<?php
class User {
  public $user_id, $account_balance, $email, $username, $scope;
  public $sign_up_time, $last_login_time, $has_notification;

  public function __construct($user_params) {
    $this->username = $user_params['username'];
    $this->account_balance = $user_params['account_balance'];
    $this->sign_up_time = $user_params['sign_up_time'];
    $this->last_login_time = $user_params['last_login_time'];
    $this->has_notification = $user_params['has_notification'];
    $this->this_is_main_user = $user_params['this_is_main_user'];
    if ($this->this_is_main_user) {
      $this->scope = $user_params['scope'];
      $this->email = $user_params['email'];
    }
  }
}