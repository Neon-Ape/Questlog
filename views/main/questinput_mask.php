<center>
<h3>Create a new Quest</h3>
<form id='newQuest' action=<?php echo $_SERVER["PHP_SELF"].'?controller=questlog&action=add'; ?> method='POST'>

<input type='text' name='qname' maxlength="20" placeholder="Questname" autofocus required /><br>
<textarea name="qtext" form="newQuest" placeholder="What needs to be done?"></textarea><br>
<div id="points">
	<input type="number" name='qxp'  placeholder="XP" required />
	<input type="number" name='qtoken'  placeholder="Tokens" required />
</div>

<div id="dateTime">
	<input type="date" min="<?php echo $this->get_date();?>" name="qdue_date" placeholder="dd.mm.yyyy" required />
	<input type="time" name="qdue_time" placeholder="mm.hh" required />
</div>
<select name="unames[]"  multiple class="chosen-select" id="target" data-placeholder="Select Adventurers"/>
	<?php 
	foreach ($this->users as $id => $name) { 
		echo '<option class="unames-option" value="'.$id.'">'.$name.'</option>';
	}
	?>
</select><br>
<div id="steps"></div>

Add Subquest <img class="addStep" src="/questlog/images/newquest.png" width="50px" onclick="addStep()"><br>

<input type='submit' value='Create Quest' name='btn_login'><input id="reset" type='reset' value='Reset' onclick='resetSteps()'>

<span style=color:red><?php echo $this->error; ?></span>

</form>
</center>