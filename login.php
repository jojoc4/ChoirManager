<?php
$error = false;
if (isset($_POST['password'])) {
    if ($USER_PASSWORD == $_POST['password']) {
        setcookie("login", "user", time() + 60 * 60 * 24 * 3650);
        header('Location: /');
    } else {
        $error = true;
    }
}
?>
<div class="container-fluid overflow-visible">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h4>Connexion</h4>
        </div>
        <div class="card-body">
            <?php
            if ($error) {
                ?>

                <div class="alert alert-danger" role="alert">
                    Mot de passe incorrecte
                </div>
                <?php
            }
            ?>
            <form method="post">
                <div class="form-group">
                    <label for="password">Mot de passe</label>
                    <input name="password" type="password" class="form-control" id="password" placeholder="Mot de passe">
                </div><br>
                <button type="submit" class="btn btn-primary" style="background: rgb(178,21,30);">Connexion</button>
            </form>
        </div>
        <div class="card-footer">
            En cas de problème, envoyez un mail à <a style="color: black;" href="mailto:contact@choeuracoeur-valbirse.ch">contact@choeuracoeur-valbirse.ch</a>.
        </div>
    </div>
</div>