<h2>Add School</h2>
<?php
$this->load->helper('form');
echo $formsuccess;
echo validation_errors();
echo form_open('add_school');
?>
<label for="school_title">Title</label>
<input type="text" name="school_title" />
<br />
<label for="scope">Scope</label>
<?php
$scope = array( 'public' => 'public', 'private' => 'private' );
echo form_dropdown('scope', $scope, 'public');
?>
<br />
<label for="education_level">Education Level</label>
<?php
$education_level = array( 
	'primary' => 'primary', 
	'secondary' => 'secondary', 
	'tertiary' => 'tertiary' 
);
echo form_dropdown('education_level', $education_level, 'primary');
?>
<br />
<input type="submit" name="submit" value="Add School" />
<?php echo form_close(); ?>