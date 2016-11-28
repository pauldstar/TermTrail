<h2>Add Course</h2>
<?php
$this->load->helper('form');
echo validation_errors();
$hidden = array( 'course_form' => 'yes' );
echo form_open('member', '', $hidden);
?>
<label for="title">Title</label>
<input type="text" name="title" />
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
<label for="education_level">Education Level</label>
<?php
$education_level = array( 
    'primary' => 'primary', 
    'secondary' => 'secondary', 
    'tertiary' => 'tertiary' );
echo form_dropdown('education_level', $education_level, 'primary');
?>
<br />
<input type="submit" name="submit" value="Add Course" />
<?php echo form_close(); ?>