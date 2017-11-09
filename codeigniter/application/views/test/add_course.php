<h2>Add Course</h2>
<?php
$this->load->helper('form');
echo $formsuccess;
echo validation_errors();
echo form_open('add_course');
?>
<label for="course_title">Title</label>
<input type="text" name="course_title" />
<br />
<label for="school_id">School_ID</label>
<input type="number" name="school_id" />
<br />
<label for="scope">Scope</label>
<?php
$scope = array( 'public' => 'public', 'private' => 'private' );
echo form_dropdown('scope', $scope, 'public');
?>
<br />
<label for="category">Category</label>
<input type="text" name="category" />
<br />
<input type="submit" name="submit" value="Add Course" />
<?php echo form_close(); ?>