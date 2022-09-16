<?php
echo "Updating DB";
$pdo->exec(file_get_contents('v1.sql'));

echo "Updating file structure";
//create folders
$musics = $pdo->query("SELECT * FROM music")->fetchAll(PDO::FETCH_ASSOC);
foreach($musics as $music){
    $name = folder_name($music['name']);
    if(!is_dir("../files/".$name)){
        mkdir("../files/".$name);
        $pdo->exec("UPDATE `music` SET `directory` = '".$name."' WHERE `id_music` = '".$music['id_music']."';");
    }else{
        $v=2;
        while(is_dir("../files/".$name.$v)){
            $v++;
        }
        mkdir("../files/".$name.$v);
        $pdo->exec("UPDATE `music` SET `directory` = '".$name.$v."' WHERE `id_music` = '".$music['id_music']."';");
    }
}

//moving files
$musics = $pdo->query("SELECT * FROM music")->fetchAll(PDO::FETCH_ASSOC);
foreach($musics as $music){
    $versions = $pdo->query("SELECT * FROM version WHERE `id_music` = '".$music['id_music']."'")->fetchAll(PDO::FETCH_ASSOC);
    foreach($versions as $version){
        rename("../files/".$version['url'], "../files/".$music['directory']."/".explode("/", $version['url'])[2]);
        $pdo->exec("UPDATE `version` SET `url` = '".$music['directory']."/".addslashes(explode("/", $version['url'])[2])."' WHERE `id_version` = '".$version['id_version']."';");
    }
    $documents = $pdo->query("SELECT * FROM document WHERE `id_music` = '".$music['id_music']."'")->fetchAll(PDO::FETCH_ASSOC);
    foreach($documents as $document){
        rename("../files/".$document['url'], "../files/".$music['directory']."/".explode("/", $document['url'])[1]);
        $pdo->exec("UPDATE `document` SET `url` = '".$music['directory']."/".addslashes(explode("/", $document['url'])[1])."' WHERE `id_doc` = '".$document['id_doc']."';");
    }
}

?>