<script type="text/javascript">

var w3 = {};
w3.toggleShow = function (sel) {
  var i, x = w3.getElements(sel), l = x.length;
  for (i = 0; i < l; i++) {    
    if (x[i].style.display == "none") {
      w3.styleElement(x[i], "display", "block");
    } else {
      w3.styleElement(x[i], "display", "none");
    }
  }
};
w3.getElements = function (id) {
  if (typeof id == "object") {
    return [id];
  } else {
    return document.querySelectorAll(id);
  }
};
w3.styleElement = function (element, prop, val) {
  element.style.setProperty(prop, val);
};

w3.hideElements = function (sel) {
	var i, x = w3.getElements(sel), l = x.length;
	for (i = 0; i < l; i++) {    
	  w3.styleElement(x[i], "display", "none");
	}

};
</script>

<div id="box">
<div id="scrollbox">
<div id="offset"></div>

<?php
debug($this->quests['open'],"quests['open']");
foreach ($this->quests as $type =>$quest) {
	echo "<hr>\n";
	for ($i=0; $i < sizeOf($quest) ; $i++) { 
		?>
		<form action=<?php echo $_SERVER["PHP_SELF"].'?controller=questlog&action=button'; ?> method='POST'>
		<table class="quest" onclick="w3.toggleShow(<?php echo '\'.qid_' . $quest[$i]->id . '\''?>)">	

		<tr>
			<td rowspan="2"><div id="questicon"><img src="/questlog/images/<?php echo $type; ?>.png" class="<?php echo $type; ?>"></div></td>
			<td><div id="questname"><?php echo $quest[$i]->name; ?></div></td>
			<td><div id="questxp"><?php echo $quest[$i]->xp; ?></div></td>
			<td><div id="questtoken"><?php echo $quest[$i]->token; ?></div></td>
			<td><div id="questbutton">
				
				<?php
		    	switch ($type) {
		    		case 'open':
		    			?>
		    			<button type="submit" name="btn_accept" value="Accept"><img src="/questlog/images/accept.png" alt="Accept"></button>
		    			<input type='hidden' value='<?php echo $quest[$i]->id ?>' name='qid'>	
		    			<?php
		    			break;
		    		case 'active':
		    			?>
		    			<button type="submit" name="btn_accept" value="I´m done"><img src="/questlog/images/accept.png" alt="I´m done"></button>
		    			<input type='hidden' value='<?php echo $quest[$i]->id ?>' name='qid'>
		    			<?php
		    			break;
		    		case 'finished':
		    			?>
	    				<button type="submit" name="btn_accept" value="Retry"><img src="/questlog/images/refresh.png" alt="Retry"></button>
	    				<input type='hidden' value='<?php echo $quest[$i]->id ?>' name='qid'>
		    			<?php
		    			break;
		    	}
		    	?>
		    	
			</div></td>
		</tr>
	    <tr class="lower">
	    	<td>
				<div id="questdue"><?php echo $quest[$i]->due; ?></div>
			</td>
			<td  colspan="2">
				<div id="questcreator"><?php echo $quest[$i]->creator; ?></div>
			</td>
			<td><div id="questbutton">
				<?php
				switch ($type) {
		    		case 'open':
		    			?>
		    			<button type="submit" name="btn_accept" value="Decline"><img src="/questlog/images/trash.png" alt="Decline"></button>
		    			<?php
		    			break;
		    		case 'active':
		    			?>
		    			<button type="submit" name="btn_accept" value="I give up"><img src="/questlog/images/decline.png" alt="I give up"></button>
		    			<?php
		    			break;
		    		case 'finished':
		    			break;
		    	}
		    	?>
				
			</div></td>
	    </tr>
	    	
	   
	    
		</table></form>
	<?php
	}	
}?>
<div id="offset"></div>
</div>
<div id="gradtop"></div>
<div id="gradbottom"></div>

</div>


<div id="box">
<div id="scrollbox">
<div id="offset"></div>
<?php 
foreach ($this->quests as $type =>$quest) {
	for ($i=0; $i < sizeOf($quest) ; $i++) { 
?>
<div class="stepcontainer qid_<?php echo $quest[$i]->id ?>" style="display: none;">
	<div class="step_questname"><?php echo $quest[$i]->name; ?></div>
	<div class="questtext"><?php echo $quest[$i]->text; ?></div>
	
	<?php 
	$queststeps = $quest[$i]->steps;
	for ($j=0; $j < sizeOf($queststeps); $j++) { 

	?>
	<form id='setStepStatus' action=<?php echo $_SERVER["PHP_SELF"].'?controller=questlog&action=button'; ?> method='POST'>
	<div class="queststep">
		<button type="submit" name="btn_accept" value="setStepStatus">
			<?php 
			switch ($queststeps[$j]->status) {
				case '0':
					echo '<img src="/questlog/images/decline.png" alt="finish" >';
					break;
				
				case '1':
					echo '<img src="/questlog/images/accept.png" alt="undo" >';
					break;
			}
			?>
			
		</button>
		<div class="step text"><?php echo $queststeps[$j]->name; ?></div>
		<div class="step finishedby"><?php echo $queststeps[$j]->finishedBy; ?></div>
		
	</div>
	<input type="hidden" name="qid" value="<?php echo $quest[$i]->id; ?>">
	<input type="hidden" name="qsid" value="<?php echo $queststeps[$j]->id; ?>">
	<input type="hidden" name="qsstat" value="<?php echo $queststeps[$j]->status; ?>">
	</form>
	<?php
	}
	?>

	<hr>
</div>
<?php
}}
?>

<div id="offset"></div>
</div>
<div id="gradtop"></div>
<div id="gradbottom"></div>
</div>



<script type="text/javascript">w3.hideElements('.stepcontainer');</script>