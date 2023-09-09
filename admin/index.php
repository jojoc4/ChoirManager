<?php
require '../updater/tools.php';
require '../config.php';

if (needsUpdate($pdo, $VERSION)) {
    echo "L'application nécessite une mise à jour, veuillez contacter l'administrateur.";
    return;
}

//https redirection
if ($FORCE_HTTPS) {
    if (!(isset($_SERVER['HTTPS']) && ($_SERVER['HTTPS'] == 'on' ||
        $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) {
        $redirect = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('HTTP/1.1 301 Moved Permanently');
        header('Location: ' . $redirect);
        exit();
    }
}

if (!isset($_COOKIE['admin']) || !password_verify($ADMIN_PASSWORD, $_COOKIE['admin'])) {
    header('Location: /');
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Chœur à Cœur - privée</title>
    <meta name="theme-color" content="rgb(178,21,30)">
    <meta property="og:type" content="">
    <link rel="icon" type="image/png" sizes="512x512" href="../assets/img/index_logo.png">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="manifest" href="../manifest.json">
    <link rel="apple-touch-icon" sizes="256x256" href="..//assets/img/AppImages/ios/256.png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.12.0/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome5-overrides.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/ui/trumbowyg.min.css" integrity="sha512-Fm8kRNVGCBZn0sPmwJbVXlqfJmPC13zRsMElZenX6v721g/H7OukJd8XzDEBRQ2FSATK8xNF9UYvzsCtUpfeJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0" style="background: rgb(178,21,30);">
            <div class="container-fluid d-flex flex-column p-0">
                <div class="sidebar-brand-icon" style="margin-top:8px;"><img width="64px" src="../assets/img/index_logo.png"></div><br>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link <?php if (!isset($_GET['p'])) echo "active"; ?>" href="/admin/"><i class="fas fa-home"></i><span>Accueil</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if (isset($_GET['p']) && $_GET['p'] == 'd') echo "active"; ?>" href="?p=d"><i class="fas fa-calendar"></i><span>Dates</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if (isset($_GET['p']) && $_GET['p'] == 'f') echo "active"; ?>" href="?p=f"><i class="fas fa-folder"></i><span>Dossiers</span></a></li>
                    <li class="nav-item"><a class="nav-link <?php if (isset($_GET['p']) && $_GET['p'] == 'm') echo "active"; ?>" href="?p=m"><i class="fas fa-music"></i><span>Chants</span></a></li>
                </ul>
                <hr class="sidebar-divider my-0">
                <ul class="navbar-nav text-light" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link" href="/"><i class="fas fa-arrow-left"></i><span>Publique</span></a></li>
                </ul>
                <div class="text-center d-none d-md-inline"><button class="btn rounded-circle border-0" id="sidebarToggle" type="button"></button></div>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <nav class="navbar navbar-light navbar-expand bg-white shadow mb-4 topbar static-top">
                    <div class="container-fluid"><button class="btn d-md-none rounded-circle me-3" style="color: rgb(178,21,30);" id="sidebarToggleTop" type="button"><i class="fas fa-bars"></i></button>
                    </div>
                </nav>
                <?php
                if (!isset($_GET['p'])) {
                    include 'home.php';
                } else {
                    switch ($_GET['p']) {
                        case 'd':
                            include 'date.php';
                            break;
                        case 'f':
                            include 'folder.php';
                            break;
                        case 'm':
                            include 'music.php';
                            break;
                        default:
                            include '../error.php';
                            break;
                    }
                }
                ?>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © Chœur à Cœur 2021 | Site web créé par <a href="#" style="color: black;">Jonatan Baumgartner</a></span></div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Trumbowyg/2.27.3/trumbowyg.min.js" integrity="sha512-YJgZG+6o3xSc0k5wv774GS+W1gx0vuSI/kr0E0UylL/Qg/noNspPtYwHPN9q6n59CTR/uhgXfjDXLTRI+uIryg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="../assets/js/theme.js"></script>
    <script>
        var vw = Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);

        if (vw < 768) {
            var sidebar = document.querySelector('.sidebar');
            var collapseElementList = [].slice.call(document.querySelectorAll('.sidebar .collapse'));
            var sidebarCollapseList = collapseElementList.map(function(collapseEl) {
                return new bootstrap.Collapse(collapseEl, {
                    toggle: false
                });
            });

            document.body.classList.toggle('sidebar-toggled');
            sidebar.classList.toggle('toggled');

            if (sidebar.classList.contains('toggled')) {
                for (var bsCollapse of sidebarCollapseList) {
                    bsCollapse.hide();
                }
            }
        }
    </script>
    <script>
        $('#headerEditor').trumbowyg({

        });
    </script>
</body>

</html>