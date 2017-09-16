<h2>Add Term</h2>
<?php
$this->load->helper('form');
echo validation_errors();
echo form_open('add_term');
?>
<label for="term_position">Position</label>
<input type="number" name="term_position" />
<br />
<label for="content">Content</label>
<input type="text" name="content" />
<br />
<label for="answer">Answer</label>
<input type="text" name="answer" />
<br />
<label for="hint">Hint</label>
<input type="text" name="hint" />
<br />
<label for="chapter_id">Chapter_ID</label>
<input type="number" name="chapter_id" />
<br />
<label for="trail_id">Trail_ID</label>
<input type="number" name="trail_id" />
<br />
<label for="course_id">Course_ID</label>
<input type="number" name="course_id" />
<br />
<input type="submit" name="submit" value="Add Term" />
<?php echo form_close(); ?>