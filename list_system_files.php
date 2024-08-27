<?php
$directory = 'system';
$files = scandir($directory);
echo '<pre>';
print_r($files);
echo '</pre>';
?>
