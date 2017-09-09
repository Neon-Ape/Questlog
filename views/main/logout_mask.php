<center>

<h2>
	Farewell <?php echo $this->user->name; ?>
</h2>
<form action=<?php echo $_SERVER["PHP_SELF"].'?controller=user&action=login'; ?> method='POST'>
<input type='submit' value='Return to Login' name='btn_login'><br>
</form>
</center>