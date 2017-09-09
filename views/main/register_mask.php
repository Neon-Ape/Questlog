<center>
<h1>
	Questlog<span class="logo"><img src="https://png.icons8.com/quill-with-ink/color/96"></span>
</h1>
<form action=<?php echo $_SERVER["PHP_SELF"].'?controller=user&action=validateregister'; ?> method='POST'>


<?php 

$icons = [
["butterfly","Butterfly"],
["black-cat", "Black Cat"],
["bear","Bear"],
['frog','Frog'],
["turtle", "Turtle"],
['dinosaur','Dinosaur'],
["plush", "Plush"],
["ghost", "Ghost"],
["strawberry", "Strawberry"],
['carrot','Carrot'],
["fish-food", "Fish"],
["chili-pepper","Chili Pepper"],
["pizza", "Pizza"],
["natural-food", "Leaves"],
["cornet", "Cornet"],
['f1-car', 'F1 Car']
];

$shapes = ['circle','8burst','diamond','cutdiamond','pentagon', 'hexagon','square' ];
$colors = [
['yellow','orange'],
['light-blue', 'blue'],
['green', 'bright-green'],
['red','dark-red'],
['pale-pink', 'pink'],
['pale-brown','brown'],
['pale-yellow','blue-grey'],
['turquoise','dark-turquoise'],
['fiery-orange','leaf-green'],
['light-purple','purple']
];

?>
<div class='circle-container'>
    <div id="borderToSwap" class="layer0 preview token outer clip-<?php echo $shapes[0];?>" style="background: <?php echo $colors[0][1];?>;">
		<div id="colorToSwap" class="inner clip-<?php echo $shapes[0];?>" style="background: <?php echo $colors[0][0];?>;">
			<img id="iconToSwap" class="preview" src="https://png.icons8.com/<?php echo $icons[0][0];?>/color/96">
		</div>
	</div>
<?php

/*================================================
*		Shape Selection
================================================*/
$degreeStep = 180/(sizeof($shapes)-1);
for ($i=0; $i < sizeof($shapes); $i++) { 
	?>
	<label class="layer1 radio-img" style="transform: rotate(<?php echo $degreeStep*$i; ?>deg) translate(6em) rotate(<?php echo -$degreeStep*$i; ?>deg);">
	    <input type="radio" name="tform" value="<?php echo $shapes[$i];?>" <?php if($i==0) { echo 'checked="checked"';}?> />
	    <div class="shape clip-<?php echo $shapes[$i];?>" title="<?php echo $shapes[$i];?>" onclick="$('#borderToSwap').attr('class','layer0 preview token outer clip-<?php echo $shapes[$i];?>'); $('#colorToSwap').attr('class','inner clip-<?php echo $shapes[$i];?>');"></div>
	</label>

	<?php
	if($i !=0 && ($i+1)%4 == 0) {
		echo "<br>";
	}
}

/*================================================
*		Color Selection
================================================*/
$degreeStep = 180/(sizeof($colors)-1);
for ($i=0; $i < sizeof($colors); $i++) { 
	?>
	<label class="layer2 radio-img" style="transform: rotate(<?php echo $degreeStep*$i; ?>deg) translate(9.5em) rotate(<?php echo -$degreeStep*$i; ?>deg);">
	    <input type="radio" name="tcolor" value="<?php echo $colors[$i];?>" <?php if($i==0) { echo 'checked="checked"';}?> />
	    <div class="color-container" style="background-color: var(--color-<?php echo $colors[$i][0];?>" 
	    onclick="$('#colorToSwap').attr('style','background-color: var(--color-<?php echo $colors[$i][0];?>)'); 
	    		$('#borderToSwap').attr('style','background-color: var(--color-<?php echo $colors[$i][1];?>)');
	    		$('#hiddenBorder').attr('value','<?php echo $colors[$i][1];?>');">
		  <div class="triangle-topleft" style="border-top-color: var(--color-<?php echo $colors[$i][1];?>);";></div>
		</div>
	</label>

	<?php
	if($i !=0 && ($i+1)%4 == 0) {
		echo "<br>";
	}
}

/*================================================
*		Image Selection
================================================*/
$degreeStep = 180/(sizeof($icons)-1);
for ($i=0; $i < sizeof($icons); $i++) { 
	?>
	<label class="layer3 radio-img" style="transform: rotate(<?php echo $degreeStep*$i; ?>deg) translate(13em) rotate(<?php echo -$degreeStep*$i; ?>deg);">
	    <input type="radio" name="timg" value="<?php echo $icons[$i][0];?>" <?php if($i==0) { echo 'checked="checked"';}?> />
	    <img src="https://png.icons8.com/<?php echo $icons[$i][0]; ?>/color/48" title="<?php echo $icons[$i][1];?>" onclick="$('#iconToSwap').attr('src','https://png.icons8.com/<?php echo $icons[$i][0]; ?>/color/96');">
	</label>

	<?php
	if($i !=0 && ($i+1)%5 == 0) {
		echo "<br>";
	}
}
?>


</div>

<input id="hidden-border" type="hidden" name="tborder" value="var(--color-orange)">
<input type='text' name='uname' value='<?php echo $_POST['uname']; ?>' placeholder='Your Username' required><br>
<input type='email' name='umail' value='<?php echo $_POST['umail']; ?>' placeholder='Your Mailaddress' required><br>
<input type='password' name='upass' placeholder='Your Password' required><br>

<input type='submit' value='Register' name='btn_register'><br>
<span><?php echo $this->error . '<br>Already a User? <a href='.$_SERVER["PHP_SELF"].'?controller=user&action=login>'.'Login</a>'; ?></span>
</center>