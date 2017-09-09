  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.js" type="text/javascript"></script>
  <script src="/questlog/lib/chosen/chosen.jquery.js" type="text/javascript"></script>
  <script src="/questlog/lib/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
  <script src="/questlog/lib/chosen/docsupport/init.js" type="text/javascript" charset="utf-8"></script>
  <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript">
  	$('textarea').each(function () {
	  this.setAttribute('style', 'height:' + (this.scrollHeight) + 'px;overflow:hidden;');
	}).on('input', function () {
	  this.style.height = 'auto';
	  this.style.height = (this.scrollHeight) + 'px';
	});
  </script>

  <script type="text/javascript"> 
	var stepNum = 0;
	var addStep = function() {
		//alert("addStep clicked");
		var divStart = '<div class="step">'
			textInput = '<input type="text" name="steps[',
			numInput = '<input type="number" name="steps[',
			nameString = '][name]" placeholder="Name" ',
			xpString = '][xp]" placeholder="XP" ',
			tokenString = '][token]" placeholder="Tokens" ',
			htmlEnd = ">",
			divEnd = '</div>';

		var stepLabel = "Step " + stepNum;
		var htmlString = divStart + 
						textInput + stepNum + nameString + htmlEnd + "\n" + 
						numInput + stepNum + xpString + htmlEnd + "\n" + 
						numInput + stepNum + tokenString + htmlEnd + "\n" + 
						divEnd;
		var stepContainer = document.getElementById('steps');
		stepContainer.insertAdjacentHTML('beforeend',htmlString);
		stepNum++;
	};
	var resetSteps = function() {
		/*
		var elems = document.getElementsByClassName('step');
		console.log(elems);
		var length = elems.length;
		for(var i=length-1; i>=0; i--) {
			elems[i].parentNode.removeChild(elems[i]);
		}
		*/
		$('.step').remove();

		$('textarea').each(function () {
	  		this.setAttribute('style', 'height: 43.5px;overflow:hidden;');
		});
		//$('.search-choice').remove();	
		$('li.result-selected').toggleClass('active-result', true);
		$('li.result-selected').toggleClass('result-selected', false);
		//$('.unames-option option:selected').removeAttr('selected');
		//$('.unames-option').trigger('chosen:updated');
	}
	

</script>

</div>

<div class="footer">
<hr>
&copy;2017 Haus13, Icon pack by <a href="https://icons8.com">icons8.com</a>
</div>
</body>
</html>


