<?php
$folder = $pdo->query("SELECT * FROM `folder` WHERE id_fld = " . $_GET['f'])->fetch(PDO::FETCH_ASSOC);
?>
<div class="container-fluid overflow-visible">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0"><?php echo $folder['name']; ?></h3><!--<a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#" style="background: rgb(178,21,30);"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Télécharger tout</a>-->
    </div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <?php
            echo $folder['header'];

            $musics = $pdo->query("SELECT * FROM `folder_music` NATURAL JOIN music WHERE id_fld = " . $_GET['f'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($musics as $music) {
                ?>
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="text-primary fw-bold m-0" style="border-color: rgb(178,21,30);border-top-color: rgb(78,;border-right-color: 115,;border-bottom-color: 223);border-left-color: 115,;color: rgb(178,21,30);"><?php echo $music['name'] ?></h6>
                    </div>
                    <div class="card-body">
                        <?php
                        $documents = $pdo->query("SELECT * FROM document WHERE id_music=" . $music['id_music'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
                        if ($documents != null) {
                            ?>
                            <h6>Documents</h6>
                            <?php
                            foreach ($documents as $document) {
                                ?>
                                <div class="row m-2" style="margin: 0px;">
                                    <div class="col-8"><span><?php echo $document['name'] ?></span></div>
                                    <div class="col-4 text-right">
                                        <a style="margin-right:8px;" target="_blank" href="/files/<?php echo $document['url'] ?>"><i class="fa fa-external-link fa-lg"></i></a> 
                                        <a style="margin-right:8px;" download href="/files/<?php echo $document['url'] ?>"><i class="fa fa-download fa-lg"></i></a> 
                                        <a class="print" onClick="printPDF('/files/<?php echo $document['url'] ?>');"><i class="fa fa-print fa-lg"></i></a>
                                    </div>
                                </div>
                            <?php
                            }
                        }
                        ?>

                        <?php
                        $versions = $pdo->query("SELECT * FROM version WHERE id_music=" . $music['id_music'] . " ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
                        if ($versions != null) {
                            ?>
                            <h6 style="margin-top: 8px;">Versions</h6>
                            <?php
                            foreach ($versions as $version) {
                                ?>
                                <div class="row m-2" style="margin: 0px;">
                                    <div class="col-8"><span><?php echo $version['name'] ?></span></div>
                                    <div class="col-4 text-right">
                                        <i style="color:#4e73df; margin-right:11px;" class="fa fa-play-circle song fa-lg" m="/files/<?php echo $version['url'] ?>"></i>
                                        <a download href="/files/<?php echo $version['url'] ?>"><i class="fa fa-download fa-lg"></i></a>
                                    </div>
                                </div>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
<?php } ?>    
        </div>
    </div>
</div>