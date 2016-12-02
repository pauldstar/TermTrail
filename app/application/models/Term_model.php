<?php
class Term_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/Term.php';
  }

  public function get_user_terms($user_id, $course_id, $trail_id, 
      $chapter_id, $is_main_user)
  {
    $full_term_id = array( 
        "owner_id" => $user_id, 
        "course_id" => $course_id, 
        "trail_id" => $trail_id, 
        "chapter_id" => $chapter_id );
    $this->db->order_by('term_position', 'ASC');
    $query = $this->db->get_where('term', $full_term_id);
    if ($query != null) {
      $terms = array();
      foreach ($query->result() as $row) {
        $term_params = array( 
            'owner_id' => $user_id, 
            'course_id' => $course_id, 
            'trail_id' => $trail_id, 
            'chapter_id' => $chapter_id, 
            'term_id' => $row->term_id, 
            'author_id' => $row->author_id, 
            'term_position' => $row->term_position, 
            'answer' => $row->answer, 
            'hint' => $row->hint, 
            'session_state' => $row->session_state, 
            'confidence_score' => $row->confidence_score, 
            'last_edit_time' => $row->last_edit_time, 
            "is_main_user" => $is_main_user );
        $terms[] = new Term($term_params);
      }
      return $terms;
    }
    return null;
  }

  public function set_and_get_term($user_id, $course_id, $trail_id, 
      $chapter_id)
  {
    $current_time = date_timestamp_get(date_create());
    $term_params = array( 
        'owner_id' => $user_id, 
        'course_id' => $course_id, 
        'trail_id' => $trail_id, 
        'chapter_id' => $chapter_id, 
        'author_id' => $user_id, 
        'term_position' => $this->input->post('term_position'), 
        'answer' => $this->input->post('answer'), 
        'hint' => $this->input->post('hint'), 
        'confidence_score' => $this->input->post('confidence_score'), 
        'last_edit_time' => $current_time );
    $query_successful = $this->db->insert('term', $term_params);
    if ($query_successful) {
      $term_params['term_id'] = $this->db->insert_id();
      return new Term($term_params);
    }
    return null;
    // may need to check if user is offline before returning array of chapters
  }
}