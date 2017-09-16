<?php
class Term_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    require_once APPPATH . 'objects/Chapter.php';
    require_once APPPATH . 'objects/Term.php';
    $this->load->library('session');
  }

  public function get_main_user_terms()
  {
    $user = $_SESSION['user'];
    $query = $this->db->query("SELECT * FROM term WHERE owner_id='$user->user_id'");
    if (isset($query))
    {
      foreach ($query->result_array() as $row)
      {
        $term = new Term($row);
        $course_id = $term->course_id;
        $trail_id = $term->trail_id;
        $chapter_id = $term->chapter_id;
        $trail = & $user->courses[$course_id - 1]->trails[$trail_id - 1];
        $trail->chapters[$chapter_id - 1]->terms[] = $term;
      }
      return true;
    }
    return false;
  }
  
  public function get_user_terms($user_id)
  {
    $query = $this->db->query("SELECT * FROM term WHERE owner_id='$user_id'");
    if (isset($query)) {
      $terms = array();
      foreach ($query->result_array() as $row)
        $terms[] = new Term($row);
      return $terms;
    }
    return null;
  }

  public function get_chapter_terms($user_id, $course_id, $trail_id, $chapter_id, 
      $is_main_user)
  {
    $full_chapter_id = array( 
        "owner_id" => $user_id, 
        "course_id" => $course_id, 
        "trail_id" => $trail_id, 
        "chapter_id" => $chapter_id );
    $query = $this->db->get_where('term', $full_chapter_id);
    if ($query != null) {
      $terms = array();
      foreach ($query->result_array() as $row) 
        $terms[] = new Term($row);
      return $terms;
    }
    return null;
  }

  public function set_and_get_term($user_id, $course_id, $trail_id, $chapter_id)
  {
    $trails = $this->user->courses[$course_id - 1]->trails[$trail_id - 1];
    $term_id = sizeof($trails->chapters[$chapter_id - 1]->terms) + 1;
    $current_time = date_timestamp_get(date_create());
    $term_params = array( 
        'owner_id' => $user_id, 
        'course_id' => $this->input->post('course_id'), 
        'trail_id' => $this->input->post('trail_id'), 
        'chapter_id' => $this->input->post('chapter_id'), 
        'term_id' => $term_id, 
        'author_id' => $user_id, 
        'term_position' => $this->input->post('term_position'), 
        'content' => $this->input->post('content'), 
        'answer' => $this->input->post('answer'), 
        'hint' => $this->input->post('hint'), 
        'last_edit_time' => $current_time );
    $query_successful = $this->db->insert('term', $term_params);
    if ($query_successful) {
      $term_params['session_state'] = 'pending';
      $term_params['confidence_score'] = 0;
      $term_params['is_main_user'] = true;
      return new Term($term_params);
    }
    return null;
  }
}