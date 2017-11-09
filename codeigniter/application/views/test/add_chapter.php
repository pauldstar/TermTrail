<h2>Add Chapter</h2>
<?php
$this->load->helper('form');
echo $formsuccess;
echo validation_errors();
echo form_open('add_chapter');
?>
<label for="chapter_title">Title</label>
<input type="text" name="chapter_title" />
<br />
<label for="school_id">School_ID</label>
<input type="number" name="school_id" />
<br />
<label for="course_id">Course_ID</label>
<input type="number" name="course_id" />
<br />
<label for="bank_id">Bank_ID</label>
<input type="number" name="bank_id" />
<br />
<input type="submit" name="submit" value="Add Chapter" />
<?php echo form_close(); ?>