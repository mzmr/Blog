<?php
$filename = "messages.txt";
$file = fopen($filename, "a");
$count = count(file($filename));
$text = $_GET["name"] . ": " . $_GET["message"] . "\n";
fwrite($file, $text);
fclose($file);

while ($count > 4) {
	$file = file($filename);
	unset($file[0]);
	file_put_contents($filename, $file);
	$count--;
}
?>
