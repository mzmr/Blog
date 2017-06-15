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

function add_comment($dir, $post) {
	$comm_type = (isset($post['comment_type']) ? trim($post['comment_type']) : '') . "\n";
	$date_time = date('Y-m-d, G:i:s') . "\n";
	$nick = (isset($post['nick']) ? trim($post['nick']) : '') . "\n";
	$comment = isset($post['comment']) ? trim($post['comment']) : '';

	if ($comment == '')
			return 'Brak treści komentarza.';

	// sprawdzamy istnienie pliku z komentarzem
	$i = 0;
	do {
		$file_path = $dir . '/' . $i;
		$i++;
	} while (file_exists($file_path));

	// tworzymy plik z komentarzem
	$new_file = fopen($file_path, 'w');
	
	if ($new_file === false)
		return 'Nie można otworzyć pliku: "' . $file_path . '".';

	$full_text = $comm_type . $date_time . $nick . $comment;
		
	if (fwrite($new_file, $full_text) === false) {
		fclose($new_file);
		return 'Nie można zapisać do pliku: "' . $file_path . '".';
	}

	fclose($new_file);
	return true;
}

function prepare_dir($blog_name, $post_number) {
	$path = __DIR__ . '/' . $blog_name . '/' . $post_number;
	
	if (!file_exists($path))
		return false;
	
	$comm_path = $path . '.k';
	
	if (!file_exists($comm_path)) {
		if (!mkdir($comm_path))
			return false;
	}
	
	return $comm_path;
}




include 'menu.php';

$post = filter_input_array(INPUT_POST);

// odczytanie nazwy blogu i numeru wpisu z adresu
$url = urldecode($_SERVER['HTTP_REFERER']);
$data = explode('?', $url);
$args_count = count($data);

if ($args_count == 3) {
	$blog_name = explode('=', $data[1])[1];
	$post_number = explode('=', $data[2])[1];
	$com_dir = prepare_dir($blog_name, $post_number);
}

if ($args_count != 3) {
	echo 'Nieznana nazwa blogu i/lub numer wpisu.';
} else if ($com_dir === false)
	echo 'Nie można utworzyć katalogu na komentarz.';
else {
	$result = add_comment($com_dir, $post);
	
	if (is_string($result))
			echo $return;
	else
		echo 'Dodano komentarz do wpisu numer "' . $post_number . '" w blogu "' . $blog_name . '".';
}

echo '<a href="./blog.php?nazwa=' . $blog_name . '">Wróć do blogu</a>';
?>

</body>
</html>
