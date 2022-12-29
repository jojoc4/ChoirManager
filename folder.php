<?php
$folder = $pdo->query("SELECT * FROM `folder` WHERE id_fld = " . $_GET['f'])->fetch(PDO::FETCH_ASSOC);
?>
<div class="container-fluid overflow-visible">
    <div class="d-sm-flex justify-content-between align-items-center mb-4">
        <h3 class="text-dark mb-0"><?php echo $folder['name']; ?></h3>
        <!--<a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#" style="background: rgb(178,21,30);"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Télécharger tout</a>-->
    </div>
    <div class="row">
        <div class="col-lg-12 mb-4">
            <?php
            echo $folder['header'];
            ?>
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                <h6 class="text-primary fw-bold m-0" style="border-color: rgb(178,21,30);border-top-color: rgb(78,;border-right-color: 115,;border-bottom-color: 223);border-left-color: 115,;color: rgb(178,21,30);"  data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample"><i style="color:#888;" class="fa fa-caret-down fa-lg"></i> Tout lire</h6>
                </div>
                <div class="card-body collapse" id="collapseExample">
                    <div class="row m-2" style="margin: 0px;">
                        <div class="col-8"><span>Soprano</span></div>
                        <div class="col-4 text-right">
                            <i style="color:#4e73df; margin-right:11px;" class="fa fa-play-circle plist fa-lg" p="0"></i>
                        </div>
                    </div>
                    <div class="row m-2" style="margin: 0px;">
                        <div class="col-8"><span>Alto</span></div>
                        <div class="col-4 text-right">
                            <i style="color:#4e73df; margin-right:11px;" class="fa fa-play-circle plist fa-lg" p="1"></i>
                        </div>
                    </div>
                    <div class="row m-2" style="margin: 0px;">
                        <div class="col-8"><span>Tenor</span></div>
                        <div class="col-4 text-right">
                            <i style="color:#4e73df; margin-right:11px;" class="fa fa-play-circle plist fa-lg" p="2"></i>
                        </div>
                    </div>
                    <div class="row m-2" style="margin: 0px;">
                        <div class="col-8"><span>Basse</span></div>
                        <div class="col-4 text-right">
                            <i style="color:#4e73df; margin-right:11px;" class="fa fa-play-circle plist fa-lg" p="3"></i>
                        </div>
                    </div>
                    <div class="row m-2" style="margin: 0px;">
                        <div class="col-8"><span>Tutti</span></div>
                        <div class="col-4 text-right">
                            <i style="color:#4e73df; margin-right:11px;" class="fa fa-play-circle plist fa-lg" p="4"></i>
                        </div>
                    </div>
                    <br>
                    <audio id="playlistplayer" preload="none">
                        Your browser does not support HTML5 audio.
                    </audio>
                    <button type="button" id="playlistplay" class="btn btn-secondary"><i class="fa fa-play-circle fa-lg"></i></button>
                    <button type="button" id="playlistprev" class="btn btn-secondary"><i class="fa fa-backward fa-lg"></i></button>
                    <button type="button" id="playlistnext" class="btn btn-secondary"><i class="fa fa-forward fa-lg"></i></button><br>
                    <span id="current-time">00:00</span> / <span id="duration">00:00</span><br>
                    <span id=playlistnow>Now playing</span>
                </div>
            </div>
            <?php
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
<script>
(function () {            
    var playlists = [ 
        [
            <?php
            $musics = $pdo->query("SELECT * FROM `folder_music` NATURAL JOIN music WHERE id_fld = " . $_GET['f'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($musics as $music) {
                $versions = $pdo->query("SELECT * FROM version WHERE soprano=1 AND id_music=" . $music['id_music'] . " ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($versions as $version) {
                    echo "{name:\"" . $music['name'] . "\", url:\"/files/" . $version['url'] . "\"},\n";
                }
            }
            ?>
        ],[
            <?php
            $musics = $pdo->query("SELECT * FROM `folder_music` NATURAL JOIN music WHERE id_fld = " . $_GET['f'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($musics as $music) {
                $versions = $pdo->query("SELECT * FROM version WHERE alto=1 AND id_music=" . $music['id_music'] . " ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($versions as $version) {
                    echo "{name:\"" . $music['name'] . "\", url:\"/files/" . $version['url'] . "\"},\n";
                }
            }
            ?>
        ],[
            <?php
            $musics = $pdo->query("SELECT * FROM `folder_music` NATURAL JOIN music WHERE id_fld = " . $_GET['f'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($musics as $music) {
                $versions = $pdo->query("SELECT * FROM version WHERE tenor=1 AND id_music=" . $music['id_music'] . " ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($versions as $version) {
                    echo "{name:\"" . $music['name'] . "\", url:\"/files/" . $version['url'] . "\"},\n";
                }
            }
            ?>
        ],[
            <?php
            $musics = $pdo->query("SELECT * FROM `folder_music` NATURAL JOIN music WHERE id_fld = " . $_GET['f'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($musics as $music) {
                $versions = $pdo->query("SELECT * FROM version WHERE basse=1 AND id_music=" . $music['id_music'] . " ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($versions as $version) {
                    echo "{name:\"" . $music['name'] . "\", url:\"/files/" . $version['url'] . "\"},\n";
                }
            }
            ?>
        ],[
            <?php
            $musics = $pdo->query("SELECT * FROM `folder_music` NATURAL JOIN music WHERE id_fld = " . $_GET['f'] . " ORDER BY name")->fetchAll(PDO::FETCH_ASSOC);
            foreach ($musics as $music) {
                $versions = $pdo->query("SELECT * FROM version WHERE tutti=1 AND id_music=" . $music['id_music'] . " ORDER BY number")->fetchAll(PDO::FETCH_ASSOC);
                foreach ($versions as $version) {
                    echo "{name:\"" . $music['name'] . "\", url:\"/files/" . $version['url'] . "\"},\n";
                }
            }
            ?>
        ]
    ];
    var trackTime = function(seconds) {
        var min = 0;
        var sec = Math.floor(seconds);
        var time = 0;
        min = Math.floor(sec / 60);
        min = min >= 10 ? min : '0' + min;
        sec = Math.floor(sec % 60);
        sec = sec >= 10 ? sec : '0' + sec;
        time = min + ':' + sec;

        return time;
  };

    var player = document.getElementById('playlistplayer');
    var prev = document.getElementById('playlistprev');
    var next = document.getElementById('playlistnext');
    var play = document.getElementById('playlistplay');
    var now = document.getElementById('playlistnow');
    var curent = document.getElementById('current-time');
    var duration = document.getElementById('duration');
    var playlistButoon = document.getElementsByClassName('plist');
    var songId = null;
    var playlist = null;
    var playing=false;

    play.disabled=true;
    prev.disabled=true;
    next.disabled=true;
    now.innerHTML = "Aucune voix sélectionnée";
    curent.innerHTML = "00:00";
    duration.innerHTML = "00:00";

    player.addEventListener("error", function(e) {
        switch (e.target.error.code) {
            case e.target.error.MEDIA_ERR_ABORTED:
            alert('You aborted the playback.');
            break;
            case e.target.error.MEDIA_ERR_NETWORK:
            alert('A network error caused the audio download to fail.');
            break;
            case e.target.error.MEDIA_ERR_DECODE:
            alert('The audio playback was aborted due to a corruption problem or because the video used features your browser did not support.');
            break;
            case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
            alert('The audio not be loaded, either because the server or network failed or because the format is not supported.');
            break;
            default:
            alert('An unknown error occurred.');
            break;
        }
        songId = null;
        playlist = null;
        play.disabled=true;
        prev.disabled=true;
        next.disabled=true;
        now.innerHTML = "Aucune voix sélectionnée";
        curent = "00:00";
        duration = "00:00";
    }, false);

    player.addEventListener("play", function(e) {
        playing=true;
        play.innerHTML = '<i class="fa fa-pause-circle fa-lg"></i>';
    }, false);

    player.addEventListener("pause", function(e) {
        playing=false;
        play.innerHTML = '<i class="fa fa-play-circle fa-lg"></i>';
    }, false);

    player.addEventListener("ended", function(e) {
        songId++;
        if (songId < playlists[playlist].length) {
            now.innerHTML = playlists[playlist][songId].name;
            player.src = playlists[playlist][songId].url;
            player.load();
            player.play();
            prev.disabled=false;
            if(songId == playlists[playlist].length-1) {
                next.disabled=true;
            }
        } else {
            songId = null;
            playlist = null;
            play.disabled=true;
            prev.disabled=true;
            next.disabled=true;
            now.innerHTML = "Aucune voix sélectionnée";
            curent = "00:00";
            duration = "00:00";
        }
    }, false);

    player.addEventListener("timeupdate", function(e) {
        curent.innerHTML = trackTime(player.currentTime);
        duration.innerHTML = trackTime(player.duration);
    }, false);

    prev.addEventListener("click", function(e) {
        if (songId > 0) {
            songId--;
            now.innerHTML = playlists[playlist][songId].name;
            player.src = playlists[playlist][songId].url;
            player.load();
            player.play();
            next.disabled=false;
            if(songId == 0) {
                prev.disabled=true;
            }
        }
    }, false);

    next.addEventListener("click", function(e) {
        if (songId < playlists[playlist].length-1) {
            songId++;
            now.innerHTML = playlists[playlist][songId].name;
            player.src = playlists[playlist][songId].url;
            player.load();
            player.play();
            prev.disabled=false;
            if(songId == playlists[playlist].length-1) {
                next.disabled=true;
            }
        }
    }, false);

    play.addEventListener("click", function(e) {
        if (playing) {
            player.pause();
        } else {
            player.play();
        }
    }, false);

    for(var i=0; i<playlistButoon.length; i++) {
        playlistButoon[i].addEventListener("click", function(e) {
            playlist = this.getAttribute("p");
            songId = 0;
            play.disabled=false;
            next.disabled=false;
            now.innerHTML = playlists[playlist][songId].name;
            player.src = playlists[playlist][songId].url;
            player.load();
            player.play();
        }, false);
    }
})();
</script>