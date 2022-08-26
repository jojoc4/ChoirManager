<?php
if(isset($_GET['a'])){
    switch($_GET['a']){
        case 'a':
            $q = "INSERT INTO `folder` (`name`, `icon`, `header`, `active`) VALUES ('".addslashes($_GET['name'])."', '".addslashes($_GET['icon'])."', '', '";
            $q.= isset($_GET['active']) ? "1" : "0";
            $q.="');";
            $pdo->exec($q);
            unset($_GET['a']);
            break;
        case 'e':
            $q = "UPDATE `folder` SET `name` = '".addslashes($_GET['name'])."',  `icon` = '".addslashes($_GET['icon'])."', `active` = '";
            $q.= isset($_GET['active']) ? "1" : "0";
            $q .= "' WHERE `id_fld` = '".$_GET['id']."';";
            $pdo->exec($q);
            unset($_GET['a']);
            break;
        case 'd':
            $pdo->exec("DELETE FROM `folder` WHERE ((`id_fld` = '".$_GET['id']."'));");
            unset($_GET['a']);
            break;
        case 'rm':
            $pdo->exec("DELETE FROM `folder_music` WHERE ((`id_folder_music` = '".$_GET['rid']."'));");
            break;
        case 'am':
            $pdo->exec("INSERT INTO `folder_music` (`id_music`, `id_fld`) VALUES ('".$_GET['music']."', '".$_GET['id']."');");
            break;
    }    
}
?>

<div class="container-fluid overflow-visible">
<?php
if(isset($_GET['a'])){
    $folder = $pdo->query("SELECT * FROM `folder` WHERE id_fld = " . $_GET['id'])->fetch(PDO::FETCH_ASSOC);
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Entête</h4>
        </div>
        <div class="card-body">
            <pre><?php echo $folder['header']; ?></pre>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Contenu</h4>
        </div>
        <div class="card-body">
            <table>
            <?php
                $musics = $pdo->query("SELECT * FROM `folder_music` NATURAL JOIN music WHERE id_fld = " . $_GET['id'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($musics as $music) {
                    echo '<tr><td>'.$music['name'].'</td><td><a href="?p=f&a=rm&id='.$_GET['id'].'&rid='.$music['id_folder_music'].'"><button class="btn btn-warning">Supprimer</button></a></td></tr>';
                }
            ?>
            </table>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Ajouter</h4>
        </div>
        <div class="card-body">
        <form method="get" class="form-inline">
            <input type="hidden" value="f" name="p">
            <input type="hidden" value="am" name="a">
            <input type="hidden" value="<?php echo $_GET['id'] ?>" name="id">
            <select name="music">
            <?php
                foreach ($pdo->query("SELECT * FROM `music` ORDER BY name")->fetchAll(PDO::FETCH_ASSOC) as $music) {
                    echo '<option value="'.$music['id_music'].'">'.$music['name'].'</option>';
                }
            ?>
            </select>
            <input type="submit" class="btn btn-primary" value="Ajouter">
            </form>
        </div>
    </div>
    <?php    
}else{
    ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Dossiers</h4>
        </div>
        <div class="card-body">
                <?php
                foreach ($pdo->query("SELECT * FROM folder ORDER BY name")->fetchAll(PDO::FETCH_ASSOC) as $f) {
                    ?>
                    <form method="get" class="form-inline">
                    <input type="hidden" value="f" name="p">
                    <input type="hidden" value="e" name="a">
                    <input type="hidden" value="<?php echo $f['id_fld'] ?>" name="id">
                    <input class="form-check-input" type="checkbox" name="active" <?php echo $f['active'] ? "checked" : "";?> >
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" value="<?php echo $f['name'] ?>" placeholder="Nom">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="icon" value="<?php echo $f['icon'] ?>" placeholder="Icone">
                    <input type="submit" class="btn btn-primary" value="Éditer">
                    <a href="?p=f&a=m&id=<?php echo $f['id_fld'] ?>" class="btn btn-secondary">Modifier</a>
                    <a href="?p=f&a=d&id=<?php echo $f['id_fld'] ?>" class="btn btn-warning">Supprimer</a>
                    </form>
                <?php
                }
                ?>
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Ajouter</h4>
        </div>
        <div class="card-body">
        <form method="get" class="form-inline">
                    <input type="hidden" value="f" name="p">
                    <input type="hidden" value="a" name="a">
                    <input class="form-check-input" type="checkbox" name="active">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="name" placeholder="Nom">
                    <input type="text" required class="form-control" style="width: auto; display: inline;" name="icon" value="music" placeholder="Icone">
                    <input type="submit" class="btn btn-primary" value="Ajouter">
                    </form>
        </div>
    </div>
    <?php
}
?>
</div>