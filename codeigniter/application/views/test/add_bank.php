<h2>Add Bank</h2>
<?php
$this->load->helper('form');
echo $formsuccess;
echo validation_errors();
echo form_open('add_bank');
?>
<label for="bank_title">Title</label>
<input type="text" name="bank_title" />
<br />
<label for="school_id">School_ID</label>
<input type="number" name="school_id" />
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
<input type="submit" name="submit" value="Add Bank" />
<?php echo form_close(); ?>