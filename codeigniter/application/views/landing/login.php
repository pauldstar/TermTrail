<h2><?php echo $login_title; ?></h2>
<?php
$this->load->helper('form');
echo validation_errors();
$hidden = array('login' => 'yes');
echo form_open('login', '', $hidden);
?>
<label for="email">Email</label>
<input type="text" name="email" class='form-control'/>
<br />
<label for="password">Password</label>
<input type='password' name='password' class='form-control'>
<br />
<input type="submit" name="submit" value="Login" />
<?php
echo form_close();
$this->load->helper('url');
echo anchor('signup', 'Sign Up', 'title="New user?"');
?>