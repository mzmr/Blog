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

function createNewBlog($blogName) {
	mkdir($blogName);
	
	$infoFile = fopen($blogName . '/info', 'w');
	
	if ($infoFile === false)
		return false;
	
	if (!flock($infoFile, LOCK_EX))
		return false;
	
	$userName = $_POST['userName'];
	$passHash = md5($_POST['userPassword']);
	$blogDescription = $_POST['blogDescription'];
	
	fwrite($infoFile, "$userName\n");
	fwrite($infoFile, "$passHash\n");
	fwrite($infoFile, "$blogDescription\n");
	
	flock($infoFile, LOCK_UN);
	fclose($infoFile);
	return true;
}

include 'menu.php';

$blogName = $_POST['blogName'];

if(is_dir($blogName))
	echo 'Blog o nazwie "' . $blogName . '" już istnieje.';
else {
	$result = createNewBlog($blogName);
	
	if($result === true)
		echo 'Blog "' . $blogName . '" został utworzony.';
	else
		echo 'Nie można utworzyć bloga.';
}

?>

</body>
</html>
