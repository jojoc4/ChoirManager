<?php
$frenchMonth = ["", "Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"];
?>
<div class="container-fluid overflow-visible">
    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h4>Calendrier</h4>
                </div>
                <div class="card-body">
                    <?php
                    $dates = $pdo->query("SELECT * FROM `date` WHERE date >= CURRENT_DATE() ORDER BY date")->fetchAll(PDO::FETCH_ASSOC);
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
            </div>
        </div>
    </div>
</div>
