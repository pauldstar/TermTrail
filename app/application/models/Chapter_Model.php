<?php

class Chapter_Model extends CI_Model {
  public $user = null;

  public function __construct() {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/Chapter.php';
    // object classes are needed to serialise the objects stored in session
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    $this->load->library('session');
    if (isset($_SESSION['user']))
      $this->user = $_SESSION['user'];
    else redirect('login');
  }

  public function get_user_chapters($user_id, $course_id, $trail_id, $is_main_user) {
    $full_trail_id = array( 
        "owner_id" => $user_id, 
        "course_id" => $course_id, 
        "trail_id" => $trail_id );
    $this->db->order_by('chapter_position', 'ASC');
    $query = $this->db->get_where('chapter', $full_trail_id);
    if ($query != null) {
      $chapters = array();
      foreach ($query->result() as $row) {
        $chapter_params = array( 
            "owner_id" => $user_id, 
            "course_id" => $course_id, 
            "trail_id" => $row->trail_id, 
            "chapter_id" => $row->chapter_id, 
            "chapter_title" => $row->chapter_title, 
            "chapter_position" => $row->chapter_position, 
            "is_main_user" => $is_main_user );
        $chapters[] = new Chapter($chapter_params);
      }
      return $chapters;
    }
    return null;
  }

  public function set_and_get_chapters($user_id, $course_id, $trail_id) {
    // get the next chapter position
    $chapters = $this->user->course[$course_id-1]->trails[$trail_id-1]->chapters;
    $chapter_position = sizeof($chapters) + 1;
    $chapter_params = array( 
        "owner_id" => $user_id, 
        "course_id" => $course_id, 
        "trail_id" => $trail_id, 
        "chapter_title" => $this->input->post('title'), 
        "chapter_position" => $chapter_position );
    // insert user's new chapter into database
    $query_successful = $this->db->insert('chapter', $chapter_params);
    if ($query_successful) {
      $chapter_params['chapter_id'] = $this->db->insert_id();
      return new Chapter($chapter_params);
    }
    return null;
    // may need to check if user is offline before returning array of chapters
  }
}