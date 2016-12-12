<?php
class User_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->file(APPPATH . 'objects/User.php');
  }

  public function get_main_user()
  {
    $email = $this->input->post('email');
    $password = $this->input->post('password');
    $query = $this->db->query("SELECT * FROM user WHERE email='$email'");
    $row = $query->row_array();
    // if the query returns data and the password is valid, return the user
    if (isset($row) && password_verify($password, $row['password_hash'])) {
      $user = new User($row);
      // get user components
      $has_courses = User_model::get_user_courses($user);
      if ($has_courses) {
        $has_trails = User_model::get_user_trails($user);
        if ($has_trails) {
          $has_chapters = User_model::get_user_chapters($user);
          if ($has_chapters) {
            $has_terms = User_model::get_user_terms($user);
            if ($has_terms) {
              User_model::get_user_term_comments($user);
              User_model::get_user_revisions($user);
            }
          }
        }
      }
      return $user;
    }
    return null;
  }

  public function get_other_user($username)
  {
    $query = $this->db->query("SELECT * FROM user WHERE username='$username'");
    $row = $query->row_array();
    return new User($row);
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

  private function get_user_courses(&$user)
  {
    $this->load->model('course_model');
    $user->courses = $this->course_model->get_user_courses($user->user_id);
    if (isset($user->courses)) return true;
    return false;
  }

  private function get_user_trails(&$user)
  {
    $courses = & $user->courses;
    $this->load->model('trail_model');
    $trails = $this->trail_model->get_user_trails($user->user_id);
    if (isset($trails)) {
      foreach ($trails as $trail) {
        $course_id = $trail->course_id;
        $courses[$course_id - 1]->trails[] = $trail;
      }
      return true;
    }
    return false;
  }

  private function get_user_chapters(&$user)
  {
    $courses = & $user->courses;
    $this->load->model('chapter_model');
    $chapters = $this->chapter_model->get_user_chapters($user->user_id);
    if (isset($chapters)) {
      foreach ($chapters as $chapter) {
        $course_id = $chapter->course_id;
        $trail_id = $chapter->trail_id;
        $courses[$course_id - 1]->trails[$trail_id - 1]->chapters[] = $chapter;
      }
      return true;
    }
    return false;
  }

  private function get_user_terms(&$user)
  {
    $courses = & $user->courses;
    $this->load->model('term_model');
    $terms = $this->term_model->get_user_terms($user->user_id);
    if (isset($terms)) {
      foreach ($terms as $term) {
        $course_id = $term->course_id;
        $trail_id = $term->trail_id;
        $chapter_id = $term->chapter_id;
        $courses[$course_id - 1]->trails[$trail_id - 1]->chapters[$chapter_id - 1]->terms[] = $term;
      }
      return true;
    }
    return false;
  }

  private function get_user_term_comments(&$user)
  {
    $courses = & $user->courses;
    $this->load->model('term_comment_model');
    $term_comments = $this->term_comment_model->get_user_term_comments($user->user_id);
    if (isset($term_comments)) {
      foreach ($term_comments as $term_comment) {
        $course_id = $term_comment->course_id;
        $trail_id = $term_comment->trail_id;
        $chapter_id = $term_comment->chapter_id;
        $term_id = $term_comment->term_id;
        $chapter = & $courses[$course_id - 1]->trails[$trail_id - 1]->chapters[$chapter_id - 1];
        $chapter->terms[$term_id - 1]->term_comments[] = $term_comment;
      }
    }
  }
  
  private function get_user_revisions(&$user)
  {
    $courses = & $user->courses;
    $this->load->model('revision_model');
    $revisions = $this->revision_model->get_user_revisions($user->user_id);
    if (isset($revisions)) {
      foreach ($revisions as $revision) {
        $course_id = $revision->trail_course_id;
        $trail_id = $revision->trail_id;
        $courses[$course_id - 1]->trails[$trail_id - 1]->revisions[] = $revision;
      }
    }
  }

  public function delete_user($username)
  {}
}