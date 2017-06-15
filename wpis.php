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

function addPost($blog_dir, $post, $files) {
	$date = str_replace('-', '', $post['date']);
	$time = str_replace(':', '', $post['time']);
	$tresc = isset($post['content']) ? trim($post['content']) : '';

	if ($tresc == '')
		return 'Brak treści wpisu';

	// sprawdzamy istnienie pliku z wpisem
	$i = 0;
	do {
		$file_path = $blog_dir . '/' . $date . $time . date('s') . str_pad($i, 2, '0', STR_PAD_LEFT);
		$i++;
		
		// zabezpieczenie nieskonczonej petli
		if ($i > 99)
			return 'Zadziałało zabezpieczenie nieskończonej pętli.';
	} while (file_exists($file_path));

	// tworzymy plik z wpisem
	$new_file = fopen($file_path, 'w');
	
	if (!flock($new_file, LOCK_EX))
		return 'Nie można zablokować pliku do zapisu.';
	
	if ($new_file === false)
		return 'Nie można otworzyć pliku: "' . $file_path . '"';

	if (fwrite($new_file, $tresc) === false)
		return 'Nie można zapisać do pliku: "' . $file_path . '"';
	
	flock($new_file, LOCK_UN);
	fclose($new_file);
		
	// zapisujemy przesłane pliki
	for ($i = 1, $n = 1; $i <= 3; $i++) {
		$file = 'attach' . $i;
		
		if ($files[$file]['error'] != UPLOAD_ERR_OK)
			continue;
		
		$tmp_name = $files[$file]['tmp_name'];
		$name = $file_path . $n . '.bfile';
		move_uploaded_file($tmp_name, $name);
		$n++;
	}

	return true;
}

function get_blog_dir($user_name, $pass_hash) {
	$blog_dir = false;
	
	if (($dh = opendir(__DIR__)) === false)
		return false;
	
	while (($dir = readdir($dh)) !== false){
		// jesli nie jest katalogiem
		if (is_dir($dir) === false)
			continue;
		
		// jesli plik info w katalogu $dir nie istnieje
		if (file_exists($dir . '/info') === false)
			continue;
		
		// jesli nie uda sie otworzyc pliku
		if (($info_file = fopen($dir . '/info', 'r')) === false)
			continue;
		
		// jesli nie ma nazwy uzytkownika do odczytu
		if(feof($info_file) === true)
			continue;
		
		// odczytanie nazwy uzytkownika
		$read_name = fgets($info_file);
		$file_user_name = substr($read_name, 0, strlen($read_name) - 1);
		
		// jesli nie ma hasha hasla do odczytu
		if(feof($info_file) === true)
			continue;
		
		// odczytanie hasha hasla
		$read_pass = fgets($info_file);
		$file_pass_hash = substr($read_pass, 0, strlen($read_pass) - 1);
		
		// jesli dane logowania sie nie zgadzaja
		if ($user_name != $file_user_name || $pass_hash != $file_pass_hash)
			continue;
		
		$blog_dir = $dir;
		break;
	}
	
	closedir($dh);
	return $blog_dir;
}

include 'menu.php';

$pass = $_POST['password'];
$post = filter_input_array(INPUT_POST);
$pass_hash = md5($pass);
$user_name = $post['userName'];

if (strlen(user_name) == 0 || strlen($pass) == 0) 
	echo 'Nie podano loginu lub hasła.';
else if (($blog_dir = get_blog_dir($user_name, $pass_hash)) === false)
	echo 'Nie istnieje blog, którego właścicielem jest "' . $user_name . '" lub hasło jest niepoprawne.';
else if (isset($post['date'])) {
	$result = addPost($blog_dir, $post, $_FILES);
	
	if (is_string($result)) {
		echo $return;
	} else
		echo 'Dodano wpis do blogu "' . $blog_dir . '".';
}

?>

</body>
</html>
