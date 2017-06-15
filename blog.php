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

//error_reporting(E_ALL);

function showBlogList() {
	if (($dh = opendir(__DIR__)) === false)
		return 'Nie można otworzyć katalogu "' . __DIR__ . '".';
	
	echo '<div class="content">';
	echo '<h1>Lista blogów</h1>';
	echo '';
	
	while (($dir = readdir($dh)) !== false){
		// jesli nie jest katalogiem
		if (is_dir($dir) === false)
			continue;
		
		// jesli plik info w katalogu $dir nie istnieje
		if (file_exists($dir . '/info') === false)
			continue;
		
		echo '<a class="blog_list_item" href="./blog.php?nazwa=' . $dir . '">' . $dir . '</a>';
	}
	
	echo '</div>';
	
	closedir($dh);
	return true;
}

function showBlog($blog_name) {
	$blog_path = __DIR__ . '/' . $blog_name;
	
	if (!file_exists($blog_path))
		return false;
	
	if (($dh = opendir($blog_path)) === false)
		return false;
	
	$i = 0;
	
	// znajdujemy wpisy
	while (($file = readdir($dh)) !== false){
		if (preg_match('/^[0-9]{16}$/', $file))
			$posts[$i++] = $blog_path . '/' . $file;
	}
	
	echo '<div class="content">';
	echo '<h1>' . $blog_name . '</h1>';
	
	if (isset($posts)) {
		// sortujemy malejąco
		arsort($posts);
		
		foreach ($posts as $post) {
			// znajdujemy pliki załączone do wpisu
			for ($j = 1; $j <= 3; $j++) {
				$attach_path = $post . $j . '.bfile';
				
				if (file_exists($attach_path))
					$files[$j] = $attach_path;
			}
			
			// znajdujemy komentarze do wpisu
			$comments = glob($post . '.k/*');
			
			$nr = basename($post);
		
			echo '<div class="post">';
			echo '<h3>' . substr($nr, 0, 4) . '-' . substr($nr, 4, 2) . '-' . substr($nr, 6, 2) . ', ' . substr($nr, 8, 2) . ':' . substr($nr, 10, 2) . ':' . substr($nr, 12, 2) . '</h3>';
			echo '<p class="post_txt">';
			
			// jesli nie uda sie otworzyc pliku
			if (($post_file = fopen($post, 'r')) === false)
				echo 'Nie można odczytać tresci wpisu.';
			else {
				// wypisanie treści wpisu
				while (!feof($post_file))
					echo fgets($post_file);
			}
			
			echo '</p>';
			
			// wyświetlenie linków do plików
			if (isset($files) && count($files) > 0) {
				echo '<p>Zalaczone pliki: ';
				
				for ($k = 1; $k <= count($files); $k++)
					echo '<a href="./' . $blog_name . '/' . basename($files[$k]) . '">Plik ' . $k . '</a> ';
				
				echo '</p>';
			}
			
			echo '<p>Komentarze: (<a href="./newComment.php?nazwa=' . $blog_name . '?numer=' . $nr . '">Dodaj komentarz...</a>)</p>';
				
			if (count($comments) == 0)
				echo '<div class="post_comment"><p class="no_comment">Brak komentarzy.</p></div>';
				
			// wyświetlenie komentarzy
			foreach ($comments as $comm) {
				$file = fopen($comm, 'r');
		
				if ($file == null) {
					fclose($file);
					continue;
				}
				
				$i = 0;
				
				// odczytanie danych komentarza
				while (!feof($file))
					$comm_data[$i++] = trim(fgets($file));
				
				if (count($comm_data) < 4) {
					fclose($file);
					continue;
				}
				
				$comm_type = $comm_data[0];
				$date_time = $comm_data[1];
				$nick = $comm_data[2];
				$comm_txt = $comm_data[3];
				
				fclose($file);
				
				// wyświetlenie komentarza
				echo '<div class="post_comment">' .
						 '<p class="' . $comm_type . '">#' . (basename($comm) + 1) . ' ' . $nick . ' [' . $date_time . ']</p>' .
						 '<p class="comment_txt">' . $comm_txt . '</p>' .
						 '</div>';
			}
			
			echo '</div>';
		}
	}
	
	echo '</div>';
}



include 'menu.php';

$get = filter_input_array(INPUT_GET);
$blog_name = isset($get['nazwa']) ? trim($get['nazwa']) : '';

if ($blog_name == '') {
	$result = showBlogList();
	
	if (is_string($result))
		echo 'Błąd: ' . $result;
} else {
	$result = showBlog($blog_name);
	
	if ($result === false)
		echo 'Blog "' . $blog_name .'" nie istnieje.';
	else if (is_string($result))
		echo 'Błąd: ' . $result;
}

?>

</body>
</html>
