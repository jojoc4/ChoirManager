<?php
if (isset($_GET['a'])) {
    switch ($_GET['a']) {
        case 'e':
            $q = "UPDATE `homepage` SET `content` = '" . addslashes($_POST['content']) . "',  `header_title` = '" . addslashes($_POST['title']) . "'";
            $q .= "WHERE `id_hp` = '" . $_GET['id'] . "';";
            $pdo->exec($q);
            break;
        case 'd':
            $pdo->exec("DELETE FROM `homepage` WHERE ((`id_hp` = '" . $_GET['id'] . "'));");
            unset($_GET['id']);
            break;
        case 'a':
            $pdo->exec("INSERT INTO `homepage` (`content`, `header_title`) VALUES ('" . addslashes($_POST['content']) . "', '" . addslashes($_POST['title']) . "');");
            $_GET['id'] = $pdo->lastInsertId();
            break;
    }
}
?>
<div class="container-fluid overflow-visible">
    <?php
    $cards = $pdo->query("SELECT * FROM `homepage`")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cards as $card) {
    ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4><?php echo $card['header_title']; ?></h4>
            </div>
            <div class="card-body">
                <?php echo $card['content']; ?>
            </div>
            <div class="card-footer">
                <a href="?p=hp&id=<?php echo $card['id_hp']; ?>"><button class="btn btn-primary">Modifier</button></a>
                <a href="?p=hp&a=d&id=<?php echo $card['id_hp']; ?>"><button class="btn btn-danger">Supprimer</button></a>
            </div>
        </div>
    <?php } ?>
    <a href="?p=hp"><button class="btn btn-primary">Ajouter</button></a><br><br>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Edition</h4>
        </div>
        <div class="card-body">
            <form method="post" class="form-inline" action="/admin/?p=hp&<?php echo isset($_GET['id']) ? "a=e&id=" . $_GET['id'] : "a=a"; ?>">
                <input type="text" value="<?php echo isset($_GET['id']) ? $card['header_title'] : ""; ?>" name="title" placeholder="title"><br><br>
                <textarea id="headerEditor" name="content"><?php echo isset($_GET['id']) ? $card['content'] : ""; ?></textarea><br>
                <input type="submit" class="btn btn-primary" value="Sauvegarder">
            </form>
        </div>
    </div>
</div>