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
		<h1>Zakładanie nowego bloga</h1>
		
		<form action="nowy.php" method="post">
			<ul>
				<li><label>Nazwa blogu <input type="text" name="blogName"/></label></li>
				<li><label>Nazwa użytkownika <input type="text" name="userName"/></label></li>
				<li><label>Hasło uzytkownika <input type="password" name="userPassword"/></label></li>
				<li><label>Opis blogu <textarea name="blogDescription"></textarea></label></li>
				<li><input type="submit" value="Utwórz blog"></li>
				<li><input type="reset" value="Wyczyść"/></li>
			</ul>
		</form>
	</div>
</body>
</html>
