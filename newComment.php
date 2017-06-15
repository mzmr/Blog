<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
<link rel="stylesheet" title="glowny" href="style.css" type="text/css" media="screen" />
<link rel="alternate stylesheet" title="alt" href="alt.css" type="text/css" />
<script type="text/javascript" src="menedzer_stylow.js"></script>
</head>
<body onload="listStyles();">

<?php
	include 'menu.php';
?>

	<div class="content">
		<h1>Dodawanie komentarza do wpisu</h1>
		
		<form action="koment.php" method="post">
			<ul>
				<li><label>Rodzaj komentarza <select name="comment_type">
					<option>Pozytywny</option>
					<option>Neutralny</option>
					<option>Negatywny</option>
				</select></label></li>
				<li><label>Pseudonim <input type="text" name="nick"/></label></li>
				<li><label>Komentarz <textarea name="comment"></textarea></label></li>
				<li><input type="submit" value="Dodaj komentarz"></li>
				<li><input type="reset" value="Wyczyść"/></li>
			</ul>
		</form>
	</div>
</body>
</html>
