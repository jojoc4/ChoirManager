<?php
echo "Updating DB Structure<br>";
$pdo->exec(file_get_contents('v3.sql'));

echo "You will need to update all the folders and homapage headers after the update.<br>";
