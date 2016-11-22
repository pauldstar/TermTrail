<?php

class User {
  public $user_id, $account_balance, $email, $username, $scope;
  public $sign_up_time, $last_login_time, $has_notification;
  public $courses;

  public function __construct($user_params) {
    // this is an ancillary class, there4 used get_instance() to access course_model
    $this_class = & get_instance();
    $this_class->load->model('course_model');
    // load up the user params
    $this->user_id = $user_params['user_id'];
    $this->username = $user_params['username'];
    $this->account_balance = $user_params['account_balance'];
    $this->sign_up_time = $user_params['sign_up_time'];
    $this->last_login_time = $user_params['last_login_time'];
    $this->has_notification = $user_params['has_notification'];
    $this_is_main_user = $user_params['is_main_user'];
    if ($this_is_main_user) {
      $this->scope = $user_params['scope'];
      $this->email = $user_params['email'];
      // courses each contain trails, trails contain chapters, then terms, then term_comments
      // loading the courses loads the rest of the user's work; for good offline behaviour
      $this->courses = $this_class->course_model->get_user_courses($this->user_id, true);
    }
  }
}