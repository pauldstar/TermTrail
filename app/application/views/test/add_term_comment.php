<h2>Add Term</h2>
<?php
$this->load->helper('form');
echo validation_errors();
echo form_open('add_term_comment');
?>
<label for="term_owner_id">Owner_ID</label>
<input type="number" name="term_owner_id" />
<br />
<label for="course_id">Course_ID</label>
<input type="number" name="course_id" />
<br />
<label for="trail_id">Trail_ID</label>
<input type="number" name="trail_id" />
<br />
<label for="chapter_id">Chapter_ID</label>
<input type="number" name="chapter_id" />
<br />
<label for="term_id">Term_ID</label>
<input type="number" name="term_id" />
<br />
<label for="comment">Comment</label>
<input type="text" name="comment" />
<br />
<input type="submit" name="submit" value="Add Comment" />
<?php echo form_close(); ?>