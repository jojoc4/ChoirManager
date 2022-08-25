<?php
$frenchMonth = ["", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];

if(isset($_GET['a'])){
    switch($_GET['a']){
        case 'c':
            $pdo->exec("DELETE FROM `date` WHERE date <= CURRENT_DATE()");
            break;
        case 'a':
            $pdo->exec("INSERT INTO `date` (`date`, `comment`) VALUES ('".$_GET['date']."', '".addslashes($_GET['comment'])."');");
            break;
        case 'd':
            $pdo->exec("DELETE FROM `date` WHERE id_date=".$_GET['id']);
            break;
        case 'e':
            $pdo->exec("UPDATE `date` SET `date` = '".$_GET['date']."', `comment` = '".addslashes($_GET['comment'])."' WHERE id_date=".$_GET['id']);
            break;
    }
}
?>
<div class="container-fluid overflow-visible">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4>Passées</h4>
                </div>
                <div class="card-body">
                    <?php
                    $dates = $pdo->query("SELECT * FROM `date` WHERE date <= CURRENT_DATE() ORDER BY date")->fetchAll(PDO::FETCH_ASSOC);
                    $curMonth = 0;
                    foreach ($dates as $date) {
                        $d = new DateTime($date['date']);
                        if ($curMonth != $d->format('n')) {
                            if ($curMonth != 0)
                                echo "</table><br>";
                            echo "<h6 style=\"color: red;\"><b>" . $frenchMonth[$d->format('n')] . "</b></h6>";
                            echo "<table>";
                            $curMonth = $d->format('n');
                        }
                        echo "<tr><td>" . $d->format("d.m.Y")."</td>";
                        if($date['comment']!=""){
                            echo "<td> - </td><td>" . $date['comment'] . "</td>";
                        }
                        echo "</tr>";
                    }
                    echo "</table>";
                    ?>
                </div>
                <div class="card-footer">
                    <a href="?p=d&a=c"><button class="btn btn-warning">Nettoyer</button></a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4>Futures</h4>
                </div>
                <div class="card-body">
                    <?php
                    $dates = $pdo->query("SELECT * FROM `date` WHERE date >= CURRENT_DATE() ORDER BY date")->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($dates as $date) {
                        ?>
                        <form method="get" class="form-inline">
                            <input type="hidden" value="d" name="p">
                            <input type="hidden" value="e" name="a">
                            <input type="hidden" value="<?php echo $date['id_date'] ?>" name="id">
                            <input type="date" class="form-control" style="width: auto; display: inline;" name="date" value="<?php echo $date['date'] ?>" >
                            <input type="text" class="form-control" style="width: auto; display: inline;" name="comment" value="<?php echo $date['comment'] ?>" >
                            <input type="submit" class="btn btn-primary" value="Modifier">
                            <a href="?p=d&a=d&id=<?php echo $date['id_date'] ?>" class="btn btn-warning">Supprimer</a>
                        </form>
                            
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4>Ajouter</h4>
                </div>
                <div class="card-body">
                   <form method="get">
                    <input type="hidden" value="d" name="p">
                    <input type="hidden" value="a" name="a">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input class="form-control" id="date" type="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="comment">Commentaire</label>
                        <input class="form-control" id="comment" type="text" name="comment">
                    </div><br>
                    <input class="btn btn-danger" type="submit" Value="Ajouter">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
