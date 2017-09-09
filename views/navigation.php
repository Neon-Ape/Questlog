<body> <?php  ?>
	<table class="navigation"><tr> 
		<td  width=1%>

			<?php 
				$tokenColor = $_SESSION['token_color'];
				$borderColor = $_SESSION['token_border'];
				$tokenImg = $_SESSION['token_img'];
				$tokenForm = $_SESSION['token_form'];;

				echo '<div class="token nav clip-'.$tokenForm.'" style="background: '.$borderColor.'">';
				echo '<div class="inner clip-'.$tokenForm.'" style="background: '.$tokenColor.'">';
				echo '<img src="https://png.icons8.com/'.$tokenImg.'/color/48" title="User Token"></div></div>';
			?>
			
		</td>
		<td width=50%>
			<h3><?php echo $_SESSION['user_name']."'s";?> Questlog</h3>	
		</td>
		<td width=5% align=center><a data="Questlog" href = <?php echo '"'.$_SERVER["PHP_SELF"].'?controller=questlog&action=draw"'; ?>><img class="nav" width="60" height="60" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADIAAAAyCAYAAAAeP4ixAAAEdElEQVRoQ2NkGCaAcZj4g4Foj+ya5WrALSAymYODS46Lh+cftQPgP8N/pn9//0owMjEyMaA568Wje8xMTMx/2NhZPzMwMv778/v3cyYGpirbmPVbYO4gyiPHVkaU8AsKlanpG4uysLJR2w94zbt88igDJy8LA68AP1zd3z9/GJ4/fPz607vPDU6Jm6eBJAh65ODSwGgZRZVOJQ09abr6gIGB4f2blwxP7t9gEJMWx2r13as333x698XUM3PHA4IeObk25oKZo7s+vT0Bsu/2lXMMHNwsDGzs2FPB969fGR7euLvMIX5zNF6P7JzjFqBtaLlUWlGFayA8cuvyGQZ+YR68Vl8/e/muY/wmFbweObg0cIKuqXW+oAj2qKW154jxyMNbdw+aB61wwOuR42siF2gbWcTzCgjR2s1YzaeqR9T1jOMHKkaunT/55+f3T0/wheLnj5+f2kevtyEYIwPpkRsXzzzQdJyoSExyoMgjZw7uZmBgJFjw4XSHup4RA75kSzeP3L1+iZjAwqlGSk6JgZMbd6lEN49Q5AsiNA8bj5w/euCRke9ceSL8jL+JAip+ByKzg5omNy6cvsnwj6HEKmIlvGGIz0MUZXZiQooUNX9+/wJ54Mm7Ny/X2kevLyBF76DyCMjhT+/f+Xb/1rUbXz58DgY1Bon1DEUeef/6JbH2wNWxsLLiLXJBCsExc/70k88fP2yxCl+RSYwlFHlk99qlxNiBokZQRIzBxN6VKH3DptQa9Qh6fA9U8Qtzx7CIEVBdcu30iYc20WsUiMlQFGV2YiwgR82r548Zrp4+8eH3nx+J7im7NhBjxqD0CKwIPn/swHOzwMVSNPfIaDMeGsR0a8afWB3RLSGrmCOvpsVBTPRSWw3VSi2Qw0AjKSJiUlFaxhai1HYoIfOo6pFDS0L6hcXEorVMLIeuR6BJK1teTYuTUOjRQp5qMTJianZaNeNh9cjFE0fumPjPVyUmtimqEGnVjP/84R3D9fOnL358+zLBLW33BZp7hBgLyFED9siF0xc+vnmZOKQ9QvekRU5ok6JntNQa8h2rfQt9b7CysGLO5jAycDEzM7MxgiZaqQz+/PnNoG1ixYBvyoLkpHVgkf8DDSMdooYmqeWfr58+MwiKyI16BD1AwRXi/oV+dzSNdZWpFdrEmENMjJw+uIu0HuKBhb5LlXQ0onBNAxPjMFLVgDzCwSHEIKWAO/yObF9/1zZ6nQoxZoNjZPt0DwVeId7TKtpqIsRoooaaf3//MDx7+ILB2MYFq3EPb1378eDmtWKH+I3glQ2EALyttW+hbxafIH+DlLy0KBMzCyF9VJH/8Podw79/zAyahuYo5j28df3H47s31tlGr4sm1iKURuPhFYE+f//8b2dhZZXg4uL4SqwhWNSx/P/PIMTIxMTGyMjwH585n999Yvrz989/NnaO7zy8/F++//j69e/v38tsItfUkWI/ztYvaDUQIyOzACmGoav9z/hfhfE/E/6lC0iaXFO3TyDXPvKnZMm1kUb6AJAvOVEuEoOxAAAAAElFTkSuQmCC"></a></td>
		<td width=5% align=center><a data="Add new Quest" href = <?php echo '"'.$_SERVER["PHP_SELF"].'?controller=questlog&action=input"'; ?>><img class="nav" src="https://png.icons8.com/quill-with-ink/color/96" ></a></td>
		<td width=5% align=center><a data="Logout" href = <?php echo '"'.$_SERVER["PHP_SELF"].'?controller=user&action=login"'; ?>><img class="nav" src="https://png.icons8.com/door-opened/color/96" ></a></td>
		
	</tr></table>
	
	
	