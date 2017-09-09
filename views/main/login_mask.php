<center>
<h1>
	Questlog<span class="logo"><img src="https://png.icons8.com/quill-with-ink/color/96"></span>
</h1>
<form action=<?php echo $_SERVER["PHP_SELF"].'?controller=user&action=validatelogin'; ?> method='POST'>
<p><?php echo $this->title; ?> </p>
<input type='text' name='uname' placeholder='Your Username' required<?php echo htmlspecialchars($this->nameadd); ?> ><br>
<input type='password' name='upass' placeholder="Your Password" required><br>
<input type='submit' value='Login' name='btn_login'><br>
</form>
<span style=color:red><?php echo $this->error . '<br><br>';?></span>
<?php echo 'Not a user yet? <a href='.$_SERVER["PHP_SELF"].'?controller=user&action=register>'.'Registration</a>'; ?>
</center>