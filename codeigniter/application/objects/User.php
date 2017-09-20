<?php
class User 
{
  public $user_id, $account_balance, $email, $username, $scope;
  public $sign_up_time, $last_login_time, $has_notification;
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
    /*
     * if ($is_main_user) {
     * $this->scope = $params['scope'];
     * $this->email = $params['email'];
     * // courses each contain trails, trails contain chapters, then terms, then term_comments
     * // loading the courses loads the rest of the user's work; for good offline behaviour
     * $this->courses = $this_class->course_model->get_user_courses($this->user_id, true);
     */
  }
}