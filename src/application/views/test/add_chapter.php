<h2>Add Chapter</h2>
<?php
$this->load->helper('form');
echo validation_errors();
echo form_open('add_chapter');
?>
<label for="chapter_title">Title</label>
<input type="text" name="chapter_title" />
<br />
<label for="trail_id">Trail_ID</label>
<input type="number" name="trail_id" />
<br />
<label for="course_id">Course_ID</label>
<input type="number" name="course_id" />
<br />
<input type="submit" name="submit" value="Add Chapter" />
<?php echo form_close(); ?>