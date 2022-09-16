<?php
require "tools.php";
require "../config.php";

if(!needsUpdate($pdo, $VERSION)){
    echo 'No update needed';
    return;
}else{
    $target = $VERSION;
    $act = tableExists($pdo, "config") ? $pdo->query("SELECT * FROM config WHERE name='VERSION'")->fetch(PDO::FETCH_ASSOC)['value'] : 0;
    while($act<$target){
        $act++;
        echo "<h1>Updating to V$act</h1>";
        require 'v'.$act.'.php';
    }
    echo "Update finished";
}
