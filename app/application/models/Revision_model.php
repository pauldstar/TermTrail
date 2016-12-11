<?php
class Revision_model extends CI_Model {

  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->load->file(APPPATH . 'objects/Revision.php');
  }

  public function get_ongoing_user_revisions($user_id)
  {
    $this->db->where('trail_owner_id', $user_id);
    $this->db->where('stop_time', 0);
    $query = $this->db->get('revision');
    if (isset($query)) {
      $revisions = array();
      foreach ($query->result_array() as $row)
        $revisions[] = new Revision($row);
      return $revisions;
    }
    return null;
  }

  public function get_finished_trail_revisions($user_id, $course_id, $trail_id)
  {
    $this->db->where('trail_owner_id', $user_id);
    $this->db->where('trail_course_id', $course_id);
    $this->db->where('trail_id', $trail_id);
    $this->db->where('stop_time !=', 0);
    $query = $this->db->get('revision');
    if (isset($query)) {
      $revisions = array();
      foreach ($query->result_array() as $row)
        $revisions[] = new Revision($row);
      return $revisions;
    }
    return null;
  }

  public function begin_revision()
  {}
}