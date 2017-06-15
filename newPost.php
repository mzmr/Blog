<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
<link rel="stylesheet" title="glowny" href="style.css" type="text/css" media="screen" />
<link rel="alternate stylesheet" title="alt" href="alt.css" type="text/css" />
<script type="text/javascript" src="walidacja.js"></script>
<script type="text/javascript" src="menedzer_stylow.js"></script>
</head>
<body onload="setDateAndTime();listStyles();">

<?php
	include 'menu.php';
?>

	<div class="content">
		<h1>Dodawanie nowego wpisu do bloga</h1>
		
		<form onsubmit="return checkForm();" action="wpis.php" method="post" enctype="multipart/form-data">
			<ul>
				<li><label>Nazwa użytkownika<input type="text" name="userName"/></label></li>
				<li><label>Hasło uzytkownika<input type="password" name="password"/></label></li>
				<li><label>Data<input onkeypress="return validateKey(event, this);" type="text" name="date" value=""/></label></li>
				<li><label>Godzina<input onkeypress="return validateKey(event, this);" type="text" name="time" value=""/></label></li>
				<li><label>Treść wpisu<textarea name="content"></textarea></label></li>
				<li><label>Załączniki:</label></li>
				<li><label id="files"><input onchange="addFileButton();" type="file" name="attach1"/></label></li>
				<li><input type="submit" value="Dodaj wpis"></li>
				<li><input type="reset" value="Wyczyść"/></li>
			</ul>
		</form>
	</div>
</body>
</html>
