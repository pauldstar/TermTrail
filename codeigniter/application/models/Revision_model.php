<?php
class Revision_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    require_once APPPATH . 'objects/User.php';
    require_once APPPATH . 'objects/Course.php';
    require_once APPPATH . 'objects/Trail.php';
    require_once APPPATH . 'objects/Revision.php';
    $this->load->library('session');
  }

  public function get_main_user_revisions()
  {
    $user = $_SESSION['user'];
    $query = $this->db->query(
        "SELECT * FROM revision WHERE trail_owner_id='self::$user->user_id'");
    if (isset($query))
    {
      foreach ($query->result_array() as $row)
      {
        $revision = new Revision($row);
        $course_id = $revision->trail_course_id;
        $trail_id = $revision->trail_id;
        $user->courses[$course_id - 1]->trails[$trail_id - 1]->revisions[] = $revision;
      }
    }
  }

  public function get_user_revisions($user_id)
  {
    $this->db->where('trail_owner_id', $user_id);
    $query = $this->db->get('revision');
    if (isset($query))
    {
      $revisions = array();
      foreach ($query->result_array() as $row)
        $revisions[] = new Revision($row);
      return $revisions;
    }
    return null;
  }

  public function begin_revision($user_id, $course_id, $trail_id, $mode)
  {
    $revision_id = sizeof(
        self::$user->courses[$course_id - 1]->trails[$trail_id - 1]->revisions) + 1;
    $current_time = date_timestamp_get(date_create());
    $rev_params = array( 
        'trail_owner_id' => $user_id, 
        'trail_course_id' => $course_id, 
        'trail_id' => $trail_id, 
        'revision_id' => $revision_id, 
        'start_time' => $current_time, 
        'mode' => $mode );
    $query_successful = $this->db->insert('revision', $rev_params);
    if ($query_successful)
    {
      $rev_params['elapsed_time'] = 0;
      $rev_params['stop_time'] = null;
      $rev_params['confidence_score'] = 0;
      return new Revision($rev_params);
    }
    return null;
  }

  public function pause_revision($user_id, $course_id, $trail_id)
  {
    $current_time = date_timestamp_get(date_create());
    $this->db->where('trail_owner_id', $user_id);
    $this->db->where('trail_course_id', $course_id);
    $this->db->where('trail_id', $trail_id);
    $this->db->update('revision', array( 'elapsed_time' => $current_time ));
  }

  public function change_revision_mode($user_id, $course_id, $trail_id, $mode)
  {
    $this->db->where('trail_owner_id', $user_id);
    $this->db->where('trail_course_id', $course_id);
    $this->db->where('trail_id', $trail_id);
    $this->db->update('revision', array( 'mode' => $mode ));
  }

  public function stop_revision($user_id, $course_id, $trail_id)
  {
    $current_time = date_timestamp_get(date_create());
    $this->db->where('trail_owner_id', $user_id);
    $this->db->where('trail_course_id', $course_id);
    $this->db->where('trail_id', $trail_id);
    $this->db->update('revision', array( 'stop_time' => $current_time ));
  }
  
  /*
   * public function get_finished_trail_revisions($user_id, $course_id, $trail_id)
   * {
   * $this->db->where('trail_owner_id', $user_id);
   * $this->db->where('trail_course_id', $course_id);
   * $this->db->where('trail_id', $trail_id);
   * $this->db->where('stop_time !=', null);
   * $query = $this->db->get('revision');
   * if (isset($query)) {
   * $revisions = array();
   * foreach ($query->result_array() as $row)
   * $revisions[] = new Revision($row);
   * return $revisions;
   * }
   * return null;
   * }
   */
}