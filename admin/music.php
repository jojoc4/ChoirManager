<?php
function folder_name($name){
    $name=strtolower($name);
    $name[0]=strtoupper($name[0]);
    $name = str_replace(" ", "_", $name);
    return $name;
}

if(isset($_GET['a'])){
    switch($_GET['a']){
        case 'a':
            $pdo->exec("INSERT INTO `music` (`name`, `directory`) VALUES ('".addslashes($_GET['name'])."', '".folder_name($_GET['name'])."');");
            $_GET['a']= 'm';
            $_GET['id'] = $pdo->lastInsertId();
            break;
        case 'e':
            $pdo->exec("UPDATE `music` SET `name` = '".addslashes($_GET['name'])."' WHERE `id_music` = '".$_GET['id']."';");
            unset($_GET['a']);
            break;
        case 'd':
            $pdo->exec("DELETE FROM `version` WHERE ((`id_music` = '".$_GET['id']."'));");
            $pdo->exec("DELETE FROM `music` WHERE ((`id_music` = '".$_GET['id']."'));");
            unset($_GET['a']);
            break;
        case 'ed':
            $pdo->exec("UPDATE `music` SET `directory` = '".$_GET['directory']."' WHERE `id_music` = '".$_GET['id']."';");
            break;
        case 've':
            $pdo->exec("UPDATE `version` SET `name` = '".addslashes($_GET['name'])."', `number` = '".$_GET['number']."' WHERE `id_version` = '".$_GET['id_version']."';");
            break;
        case 'vd':
            $pdo->exec("DELETE FROM `version` WHERE ((`id_version` = '".$_GET['id_version']."'));");
            break;
        case 'av':
            $music = $pdo->query("SELECT * FROM music WHERE `id_music` = '".$_GET['id']."'")->fetch(PDO::FETCH_ASSOC);
            $target= "../files/". $music['directory'] . "/" . $_POST['name'] . ".mp3";
            if(!is_dir("../files/".$music['directory'])){
                mkdir("../files/".$music['directory']);
            }
            if(move_uploaded_file($_FILES["version"]["tmp_name"], $target)){
                $pdo->exec("INSERT INTO `version` (`name`, `id_music`, `url`, `number`) VALUES ('".addslashes($_POST['name'])."', '".$_GET['id']."', '".$music['directory'] . "/" . $_POST['name'] . ".mp3"."', '".$_POST['number']."');");
            }else{
                echo "Error";
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