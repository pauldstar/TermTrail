<h2>Add Question</h2>
<?php
$this->load->helper('form');
echo $formsuccess;
echo validation_errors();
echo form_open('add_question');
?>
<label for="question_position">Position</label>
<input type="number" name="question_position" />
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
<label for="bank_id">Bank_ID</label>
<input type="number" name="bank_id" />
<br />
<label for="course_id">Course_ID</label>
<input type="number" name="course_id" />
<br />
<label for="school_id">School_ID</label>
<input type="number" name="school_id" />
<br />
<input type="submit" name="submit" value="Add Question" />
<?php echo form_close(); ?>