<?php
class Chapter_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    require_once APPPATH . 'objects/Chapter.php';
    $this->load->library('session');
  }

  public function get_main_user_chapters()
  {
    $user = $_SESSION['user'];
    $query = $this->db->query("SELECT * FROM chapter WHERE owner_id='$user->user_id'");
    if (isset($query))
    {
      foreach ($query->result_array() as $row)
      {
        $chapter = new Chapter($row);
        $course_id = $chapter->course_id;
        $trail_id = $chapter->trail_id;
        $user->courses[$course_id - 1]->trails[$trail_id - 1]->chapters[] = $chapter;
      }
      return true;
    }
    return false;
  }

  public function get_user_chapters($user_id)
  {
    $query = $this->db->query("SELECT * FROM chapter WHERE owner_id='$user_id'");
    if (isset($query))
    {
      $chapters = array();
      foreach ($query->result_array() as $row)
        $chapters[] = new Chapter($row);
      return $chapters;
    }
    return null;
  }

  public function get_trail_chapters($user_id, $course_id, $trail_id, $is_main_user)
  {
    $full_trail_id = array( 
        "owner_id" => $user_id, 
        "course_id" => $course_id, 
        "trail_id" => $trail_id );
    $query = $this->db->get_where('chapter', $full_trail_id);
    if ($query != null)
    {
      $chapters = array();
      foreach ($query->result_array() as $row)
        $chapters[] = new Chapter($row);
      return $chapters;
    }
    return null;
  }

  public function set_and_get_chapter($user_id, $course_id, $trail_id)
  {
    $chapter_id = sizeof(
        $this->user->courses[$course_id - 1]->trails[$trail_id - 1]->chapters) + 1;
    $chapter_params = array( 
        "owner_id" => $user_id, 
        'course_id' => $this->input->post('course_id'), 
        'trail_id' => $this->input->post('trail_id'), 
        'chapter_id' => $chapter_id, 
        "chapter_title" => $this->input->post('chapter_title'), 
        "chapter_position" => 1 );
    // insert user's new chapter into database
    $query_successful = $this->db->insert('chapter', $chapter_params);
    if ($query_successful) return new Chapter($chapter_params);
    return null;
  }
}