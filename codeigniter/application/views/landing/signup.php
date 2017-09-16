<h2><?php echo $signup_title; ?></h2>
<?php
$this->load->helper('form');
echo validation_errors();
$hidden = array('signup' => 'yes');
echo form_open('home/signup', '', $hidden);
?>
<label for="username">Username</label>
<input type="text" name="username" />
<br />
<label for="email">Email</label>
<input type="text" name="email" />
<br />
<label for="scope">Scope</label>
<?php
$scope = array('public' => 'public', 'private' => 'private');
echo form_dropdown('scope', $scope, 'private');
?>
<br />
<label for="password">Password</label>
<input type='password' name='password' class='form-control'>
<br />
<input type="submit" name="submit" value="Sign Up" />
<?php
echo form_close();
$this->load->helper('url');
echo anchor('login', 'Login', 'title="Login instead?"');
?>