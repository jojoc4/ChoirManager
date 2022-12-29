<?php
if(isset($_GET['a'])){
    switch($_GET['a']){
        case 'a':
            $name = folder_name($_GET['name']);
            if(is_dir("../files/".$name)){
                $v=2;
                while(is_dir("../files/".$name.$v)){
                    $v++;
                }
                $name.=$v;
            }
            $pdo->exec("INSERT INTO `music` (`name`, `directory`) VALUES ('".addslashes($_GET['name'])."', '".$name."');");
            $_GET['a']= 'm';
            $_GET['id'] = $pdo->lastInsertId();
            break;
        case 'e':
            $pdo->exec("UPDATE `music` SET `name` = '".addslashes($_GET['name'])."' WHERE `id_music` = '".$_GET['id']."';");
            unset($_GET['a']);
            break;
        case 'd':
            $versions = $pdo->query("SELECT * FROM version WHERE `id_music` = '".$_GET['id']."' ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
            $music = $pdo->query("SELECT * FROM music WHERE `id_music` = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
            foreach($versions as $version){
                unlink("../files/".$version['url']);
            }
            $documents = $pdo->query("SELECT * FROM document WHERE `id_music` = '".$_GET['id']."'")->fetchAll(PDO::FETCH_ASSOC);
            foreach($documents as $document){
                unlink("../files/".$document['url']);
            }
            if(is_dir("../files/". $music['directory'])){
                rmdir("../files/". $music['directory']);
            }
            $pdo->exec("DELETE FROM `version` WHERE ((`id_music` = '".$_GET['id']."'));");
            $pdo->exec("DELETE FROM `document` WHERE ((`id_music` = '".$_GET['id']."'));");
            $pdo->exec("DELETE FROM `music` WHERE ((`id_music` = '".$_GET['id']."'));");
            unset($_GET['a']);
            break;
        case 'ed':
            $pdo->exec("UPDATE `music` SET `directory` = '".$_GET['directory']."' WHERE `id_music` = '".$_GET['id']."';");
            break;
        case 've':
            $pdo->exec("UPDATE `version` SET `name` = '".addslashes($_GET['name'])."', `number` = '".$_GET['number']."' WHERE `id_version` = '".$_GET['id_version']."';");
            if(isset($_GET["soprano"])){
                $pdo->exec("UPDATE `version` SET `soprano` = '1' WHERE `id_version` = ". $_GET['id_version']);
            }else{
                $pdo->exec("UPDATE `version` SET `soprano` = '0' WHERE `id_version` = ". $_GET['id_version']);
            }
            if(isset($_GET["alto"])){
                $pdo->exec("UPDATE `version` SET `alto` = '1' WHERE `id_version` = ". $_GET['id_version']);
            }else{
                $pdo->exec("UPDATE `version` SET `alto` = '0' WHERE `id_version` = ". $_GET['id_version']);
            }
            if(isset($_GET["tenor"])){
                $pdo->exec("UPDATE `version` SET `tenor` = '1' WHERE `id_version` = ". $_GET['id_version']);
            }else{
                $pdo->exec("UPDATE `version` SET `tenor` = '0' WHERE `id_version` = ". $_GET['id_version']);
            }
            if(isset($_GET["basse"])){
                $pdo->exec("UPDATE `version` SET `basse` = '1' WHERE `id_version` = ". $_GET['id_version']);
            }else{
                $pdo->exec("UPDATE `version` SET `basse` = '0' WHERE `id_version` = ". $_GET['id_version']);
            }
            if(isset($_GET["tutti"])){
                $pdo->exec("UPDATE `version` SET `tutti` = '1' WHERE `id_version` = ". $_GET['id_version']);
            }else{
                $pdo->exec("UPDATE `version` SET `tutti` = '0' WHERE `id_version` = ". $_GET['id_version']);
            }
            break;
        case 'vd':
            $version = $pdo->query("SELECT * FROM version WHERE `id_version` = '".$_GET['id_version']."' ")->fetch(PDO::FETCH_ASSOC);
            unlink("../files/".$version['url']);
            $pdo->exec("DELETE FROM `version` WHERE ((`id_version` = '".$_GET['id_version']."'));");
            break;
        case 'av':
            $music = $pdo->query("SELECT * FROM music WHERE `id_music` = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
            $target= "../files/". $music['directory'] . "/" . $_POST['name'] . ".mp3";
            if (file_exists($target)) {
                echo "File allready exsists";
            }else{
                if(!is_dir("../files/".$music['directory'])){
                    mkdir("../files/".$music['directory']);
                }
                if(move_uploaded_file($_FILES["version"]["tmp_name"], $target)){
                    $pdo->exec("INSERT INTO `version` (`name`, `id_music`, `url`, `number`) VALUES ('".addslashes($_POST['name'])."', '".$_GET['id']."', '".$music['directory'] . "/" . $_POST['name'] . ".mp3"."', '".$_POST['number']."');");
                    $id = $pdo->lastInsertId();
                    if(str_contains($_POST["name"], "SOPRANO")){
                        $pdo->exec("UPDATE `version` SET `soprano` = '1' WHERE `id_version` = ". $id);
                    }
                    if(str_contains($_POST["name"], "ALTO")){
                        $pdo->exec("UPDATE `version` SET `alto` = '1' WHERE `id_version` = ". $id);
                    }
                    if(str_contains($_POST["name"], "TENOR")){
                        $pdo->exec("UPDATE `version` SET `tenor` = '1' WHERE `id_version` = ". $id);
                    }
                    if(str_contains($_POST["name"], "BASSE")){
                        $pdo->exec("UPDATE `version` SET `basse` = '1' WHERE `id_version` = ". $id);
                    }
                    if(str_contains($_POST["name"], "TUTTI")){
                        $pdo->exec("UPDATE `version` SET `tutti` = '1' WHERE `id_version` = ". $id);
                    }
                }else{
                    echo "Error";
                }
            }
            break;
        case 'de':
            $pdo->exec("UPDATE `document` SET `name` = '".addslashes($_GET['name'])."' WHERE `id_doc` = '".$_GET['id_doc']."';");
            break;
        case 'dd':
            $document = $pdo->query("SELECT * FROM document WHERE `id_doc` = '".$_GET['id_doc']."' ")->fetch(PDO::FETCH_ASSOC);
            unlink("../files/".$document['url']);
            $pdo->exec("DELETE FROM `document` WHERE ((`id_doc` = '".$_GET['id_doc']."'));");
            break;
        case 'ad':
            $music = $pdo->query("SELECT * FROM music WHERE `id_music` = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
            $target= "../files/". $music['directory'] . "/" . $_POST['name'] . ".pdf";
            if (file_exists($target)) {
                echo "File allready exsists";
            }else{
                if(!is_dir("../files/".$music['directory'])){
                    mkdir("../files/".$music['directory']);
                }
                if(move_uploaded_file($_FILES["document"]["tmp_name"], $target)){
                    $pdo->exec("INSERT INTO `document` (`name`, `id_music`, `url`) VALUES ('".addslashes($_POST['name'])."', '".$_GET['id']."', '".$music['directory'] . "/" . $_POST['name'] . ".pdf"."');");
                }else{
                    echo "Error";
                }
            }
            break;
    }    
}
?>

<div class="container-fluid overflow-visible">
    <?php 
    if(isset($_GET['a'])){
        $music = $pdo->query("SELECT * FROM music WHERE `id_music` = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
        $versions = $pdo->query("SELECT * FROM version WHERE `id_music` = '".$_GET['id']."' ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
        $documents = $pdo->query("SELECT * FROM document WHERE `id_music` = '".$_GET['id']."'")->fetchAll(PDO::FETCH_ASSOC);

        if(sizeof($versions) + sizeof($documents) == 0){
        ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4>Modifier dossier</h4>
                </div>
                <div class="card-body">
                    <form method="get" class="form-inline">
                    <input type="hidden" value="m" name="p">
                    <input type="hidden" value="ed" name="a">
                    <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="directory" value="<?php echo $music['directory'] ?>" placeholder="Dossier">
                    <input type="submit" class="btn btn-primary" value="Sauvegarder">
                    </form>
                </div>
            </div>
    <?php
        }
        ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4><?php echo $music['name'] ?></h4>
            </div>
            <div class="card-body">
                <?php
                foreach ($versions as $version) {
                    ?>
                    <form method="get" class="form-inline">
                    <input type="hidden" value="m" name="p">
                    <input type="hidden" value="ve" name="a">
                    <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id">
                    <input type="hidden" value="<?php echo $version['id_version'] ?>" name="id_version">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" value="<?php echo $version['name'] ?>" placeholder="Nom">
                    <input type="number" required class="form-control" style="width: auto; display: inline;" name="number" value="<?php echo $version['number'] ?>" placeholder="Ordre">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="soprano" name="soprano" <?php echo $version['soprano'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="soprano">Soprano</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="alto" name="alto" <?php echo $version['alto'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="alto">Alto</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="tenor" name="tenor" <?php echo $version['tenor'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="tenor">Tenor</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="basse" name="basse" <?php echo $version['basse'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="basse">Basse</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="tutti" name="tutti" <?php echo $version['tutti'] == 1 ? "checked" : "" ?>>
                        <label class="form-check-label" for="tutti">Tutti</label>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Éditer">
                    <audio controls style="width: auto; display: inline; padding: .375rem .75rem;">
                        <source src="/files/<?php echo $version['url'] ?>" type="audio/mpeg">
                    </audio>
                    <a href="?p=m&a=vd&id=<?php echo $_GET['id'] ?>&id_version=<?php echo $version['id_version'] ?>" class="btn btn-warning">Supprimer</a>
                    </form>
                <?php
                }
                ?>
                <hr>
                <form method="post" enctype="multipart/form-data" class="form-inline" action="/admin/?p=m&a=av&id=<?php echo $_GET['id'] ?>">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" placeholder="Nom">
                    <input type="number" required class="form-control" style="width: auto; display: inline;" name="number" value="<?php echo sizeof($versions)+1 ?>" placeholder="Ordre">
                    <input type="file" required class="form-control" style="width: auto; display: inline;" name="version" placeholder="Fichier">
                    <input type="submit" class="btn btn-primary" value="Ajouter">
                </form>
            </div>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4>Documents</h4>
            </div>
            <div class="card-body">
            <?php
                foreach ($documents as $document) {
                    ?>
                    <form method="get" class="form-inline">
                    <input type="hidden" value="m" name="p">
                    <input type="hidden" value="de" name="a">
                    <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id">
                    <input type="hidden" value="<?php echo $document['id_doc'] ?>" name="id_doc">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" value="<?php echo $document['name'] ?>" placeholder="Nom">
                    <input type="submit" class="btn btn-primary" value="Éditer">
                    
                    <a href="?p=m&a=dd&id=<?php echo $_GET['id'] ?>&id_doc=<?php echo $document['id_doc'] ?>" class="btn btn-warning">Supprimer</a>
                    </form>
                <?php
                }
                ?>
                <hr>
                <form method="post" enctype="multipart/form-data" class="form-inline" action="/admin/?p=m&a=ad&id=<?php echo $_GET['id'] ?>">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" value="Partition" placeholder="Nom">
                    <input type="file" required class="form-control" style="width: auto; display: inline;" name="document" placeholder="Fichier">
                    <input type="submit" class="btn btn-primary" value="Ajouter">
                </form>
            </div>
        </div>
        <?php
    }else{ 
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Ajouter</h4>
        </div>
        <div class="card-body">
            <form method="get" class="form-inline">
            <input type="hidden" value="m" name="p">
            <input type="hidden" value="a" name="a">
            <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" placeholder="Nom">
            <input type="submit" class="btn btn-primary" value="Ajouter">
            </form>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Liste</h4>
        </div>
        <div class="card-body">
            <?php
            $musics = $pdo->query("SELECT * FROM music ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($musics as $music) {
                ?>
                <form method="get" class="form-inline">
                <input type="hidden" value="m" name="p">
                <input type="hidden" value="e" name="a">
                <input type="hidden" value="<?php echo $music['id_music'] ?>" name="id">
                <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" value="<?php echo $music['name'] ?>" placeholder="Nom">
                <input type="submit" class="btn btn-primary" value="Éditer">
                <a href="?p=m&a=m&id=<?php echo $music['id_music'] ?>" class="btn btn-secondary">Modifier</a>
                <a href="?p=m&a=d&id=<?php echo $music['id_music'] ?>" class="btn btn-warning">Supprimer</a>
                </form>
            <?php
            }
            ?>
        </div>
    </div>
    <?php
    }
    ?>
</div>