<h2>Add Question</h2>
<?php
$this->load->helper('form');
echo $formsuccess;
echo validation_errors();
echo form_open('add_question_comment');
?>
<label for="question_owner_id">Owner_ID</label>
<input type="number" name="question_owner_id" />
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
<label for="chapter_id">Chapter_ID</label>
<input type="number" name="chapter_id" />
<br />
<label for="question_id">Question_ID</label>
<input type="number" name="question_id" />
<br />
<label for="comment">Comment</label>
<input type="text" name="comment" />
<br />
<input type="submit" name="submit" value="Add Comment" />
<?php echo form_close(); ?>