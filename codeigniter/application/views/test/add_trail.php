<h2>Add Trail</h2>
<?php
$this->load->helper('form');
echo validation_errors();
echo form_open('add_trail');
?>
<label for="trail_title">Title</label>
<input type="text" name="trail_title" />
<br />
<label for="course_id">Course_ID</label>
<input type="number" name="course_id" />
<br />
<label for="scope">Scope</label>
<?php
$scope = array( 'public' => 'public', 'private' => 'private' );
echo form_dropdown('scope', $scope, 'public');
?>
<br />
<input type="submit" name="submit" value="Add Trail" />
<?php echo form_close(); ?>