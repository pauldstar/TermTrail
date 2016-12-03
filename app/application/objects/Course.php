<?php
class Course {
  public $owner_id, $course_id, $course_title, $scope, $time_added;
  public $course_view_count, $course_type, $category, $education_level, $price;
  public $trails;

  public function __construct($course_params)
  {
    $this_class = & get_instance();
    $this_class->load->model('trail_model');
    $this->owner_id = $course_params['owner_id'];
    $this->course_id = $course_params['course_id'];
    $this->course_title = $course_params['course_title'];
    $this->scope = $course_params['scope'];
    $this->time_added = $course_params['time_added'];
    $this->course_view_count = $course_params['course_view_count'];
    $this->course_type = $course_params['course_type'];
    $this->category = $course_params['category'];
    $this->education_level = $course_params['education_level'];
    $this->price = $course_params['price'];
    $this_is_main_user = $course_params['is_main_user'];
    if ($this_is_main_user) {
      $this->trails = $this_class->trail_model->get_user_trails($this->owner_id, 
          $this->course_id, true);
    }
  }
}