<?php

//DB
$dsn = 'mysql:dbname=DBNAME;host=HOST';
$user = 'USER';
$password = 'PASSWORD';


// DO NOT MODIFY UNDER THIS LINE
try {
    $pdo = new PDO($dsn, $user, $password);
    $pdo->exec("SET CHARACTER SET utf8");
} catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
}

$VERSION = 2;
if(!needsUpdate($pdo, $VERSION)){
    $config = $pdo->query("SELECT * FROM config")->fetchAll(PDO::FETCH_ASSOC);

    $USER_PASSWORD=$config[0]['value'];
    $ADMIN_PASSWORD=$config[1]['value'];
    $FORCE_HTTPS=$config[2]['value'] == "false" ? false : true;
}