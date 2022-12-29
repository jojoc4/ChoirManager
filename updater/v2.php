<?php
echo "Updating DB Structure<br>";
$pdo->exec(file_get_contents('v2.sql'));

echo "updating exsisting versions";
$orphean = array();
foreach($pdo->query("SELECT * FROM version")->fetchAll(PDO::FETCH_ASSOC) as $v){
    $found=false;
    if(str_contains($v["name"], "SOPRANO")){
        $pdo->exec("UPDATE `version` SET `soprano` = '1' WHERE `id_version` = ". $v["id_version"]);
        $found=true;
    }
    if(str_contains($v["name"], "ALTO")){
        $pdo->exec("UPDATE `version` SET `alto` = '1' WHERE `id_version` = ". $v["id_version"]);
        $found=true;
    }
    if(str_contains($v["name"], "TENOR")){
        $pdo->exec("UPDATE `version` SET `tenor` = '1' WHERE `id_version` = ". $v["id_version"]);
        $found=true;
    }
    if(str_contains($v["name"], "BASSE")){
        $pdo->exec("UPDATE `version` SET `basse` = '1' WHERE `id_version` = ". $v["id_version"]);
        $found=true;
    }
    if(str_contains($v["name"], "TUTTI")){
        $pdo->exec("UPDATE `version` SET `tutti` = '1' WHERE `id_version` = ". $v["id_version"]);
        $found=true;
    }
    if(!$found){
        $orphean[] = $v["id_version"];
    }
}
echo "<br><br>id not assigned:<pre>";
print_r($orphean);
echo "</pre>";

