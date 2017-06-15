<?xml version="1.0"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
<link rel="stylesheet" title="glowny" href="style.css" type="text/css" media="screen" />
<link rel="alternate stylesheet" title="alt" href="alt.css" type="text/css" />
<script type="text/javascript" src="menedzer_stylow.js"></script>
<script type="text/javascript" src="skrypty_czatu.js"></script>
</head>
<body onload="listStyles();updateChatArea();">

<?php
	include 'menu.php';
?>

	<div class="content">
		<h1>Czatuj!</h1>
		
		<ul>
			<li><label><input type="checkbox" name="checkChat" id="checkChat" onchange="updateChatArea();"/>Włącz czat!</label></li>
			<li class="chatItem"><label><textarea rows="15" cols="120" id="chatArea" disabled></textarea></label></li>
			<li class="chatItem"><label>Imię: <input type="text" name="name" id="name" /></label></li>
			<li class="chatItem"><label>Wiadomość: <input type="text" name="message" id="message" /></label></li>
			<li class="chatItem"><label><button type="button" onclick="checkAndSend()">Wyślij</button></label></li>
		</ul>
	</div>
</body>
</html>
