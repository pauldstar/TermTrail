<?php
class Term_comment_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/Term_comment.php';
  }

  public function get_term_comments($user_id, $course_id, $trail_id, $chapter_id, $term_id)
  {
    $full_term_id = array( 
        "owner_id" => $user_id, 
        "course_id" => $course_id, 
        "trail_id" => $trail_id, 
        "chapter_id" => $chapter_id, 
        "term_id" => $term_id );
    $query = $this->db->get_where('term_comment', $full_term_id);
    if ($query != null) {
      $term_comments = array();
      foreach ($query->result() as $row) {
        $term_comment_params = array( 
            'author_id' => $row->author_id, 
            'term_owner_id' => $user_id, 
            'course_id' => $course_id, 
            'trail_id' => $trail_id, 
            'chapter_id' => $chapter_id, 
            'term_id' => $row->term_id, 
            'comment' => $row->comment, 
            'resolved' => $row->resolved, 
            'last_edit_time' => $row->last_edit_time );
        $term_comments[] = new Term_comment($term_comment_params);
      }
      return $term_comments;
    }
    return null;
  }

  public function set_and_get_term_comment($user_id, $term_owner_id, $course_id, $trail_id, 
      $chapter_id, $term_id)
  {
    $current_time = date_timestamp_get(date_create());
    $term_comment_params = array( 
        'author_id' => $user_id, 
        'term_owner_id' => $term_owner_id, 
        'course_id' => $course_id, 
        'trail_id' => $trail_id, 
        'chapter_id' => $chapter_id, 
        'term_id' => $term_id, 
        'comment' => $this->input->post('comment'), 
        'last_edit_time' => $current_time );
    $query_successful = $this->db->insert('term_comment', $term_comment_params);
    if ($query_successful) {
      $term_comment_params['resolved'] = 'N';
      return new Term_comment($term_comment_params);
    }
    return null;
  }
}