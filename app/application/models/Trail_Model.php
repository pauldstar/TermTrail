<?php
class Trail_Model extends CI_Model {
  // variables for origin trail
  var $origin_id, $course_id, $owner_id, $trail_type, $title, $scope, $mode, $price;
  var $view_count, $export_count, $preview_time, $preview_count, $date_created;
  // variables for import trail
  var $import_id, $importers_course_id, $importers_id;
  var $import_title, $date_imported, $purchase_price;

  public function __construct($t_origin_id, $t_course_id, $t_owner_id, $t_trail_type, 
                              $t_title, $t_scope, $t_mode, $t_price, $t_view_count, 
                              $t_export_count, $t_preview_time, $t_preview_count, 
                              $t_date_created, $t_import_id, $t_importers_course_id, 
                              $t_importers_id, $t_import_title, $t_date_imported, 
                              $t_purchase_price) {
    parent::__construct();
    // origin
    $origin_id = $t_origin_id;
    $course_id = $t_course_id;
    $owner_id = $t_owner_id;
    $trail_type = $t_trail_type;
    $title = $t_title;
    $scope = $t_scope;
    $mode = $t_mode;
    $price = $t_price;
    $view_count = $t_view_count;
    $export_count = $t_export_count;
    $preview_time = $t_preview_time;
    $preview_count = $t_preview_count;
    $date_created = $t_date_created;
    // for imports
    if (strcmp($trail_type, "import") == 0) {
      $import_id = $t_import_id;
      $importers_course_id = $t_importers_course_id;
      $importers_id = $t_importers_id;
      $import_title = $t_import_title;
      $importer_id = $t_importer_id;
      $date_imported = $t_date_imported;
      $purchase_price = $t_purchase_price;
    }
  }

  public function get_user_trails($user_id) {
    $this->load->database();
    $query = $this->db->query("SELECT * FROM trail WHERE owner_id=$user_id");
    $trails = array ();
    foreach ($query->result() as $row) {
      $trail = new Trail_Model($row->title, $row->title, $row->title, $row->title, $row->title, 
          $row->title, $row->title, $row->title, $row->title, $row->title, $row->title, 
          $row->title, $row->title, $row->title, $row->title, $row->title, $row->title, 
          $row->title, $row->title);
      echo $row->title;
      echo $row->name;
      echo $row->email;
    }
  }

  public function set_trail() {
    $this->load->database();
  }

  public function get_trails() {
    $this->load->database();
  }

  public function get_news($slug = FALSE) {
    if ($slug === FALSE) {
      $query = $this->db->get('news');
      return $query->result_array();
    }
    
    $query = $this->db->get_where('news', array (
        'slug' => $slug 
    ));
    return $query->row_array();
  }

  public function set_news() {
    $this->load->database();
    $this->load->helper('url');
    
    $slug = url_title($this->input->post('title'), 'dash', TRUE);
    
    $data = array (
        'title' => $this->input->post('title'),
        'slug' => $slug,
        'text' => $this->input->post('text') 
    );
    
    return $this->db->insert('news', $data);
  }
}