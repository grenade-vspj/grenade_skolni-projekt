<?php
    session_start();

    if (isset($_SESSION['vstup']) && $_SESSION['vstup'] === 1 && isset($_SESSION['expire']) && $_SESSION['expire'] >= time()) {
        header("Location:index.php");
        exit();
    } else if (isset($_POST['pwd1'])) {
        if ($_POST['pwd1'] === "RSP2020VSPJ") {
            $_SESSION['vstup'] = 1;
            $_SESSION['expire'] = time() + 30 * 60;
            header("Location:index.php");
            exit();
        } else {
            $_SESSION['vstup'] = 0;
            $_SESSION['expire'] = 0;
        }
    }
?>

<!DOCTYPE html>
<html lang="cs" class="h-100">
    <head>
        <META CHARSET="UTF-8">
        <title>Vstup do školního projektu týmu Grenade</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    </head>

    <body class="h-100 bg-secondary">
        <div class="container h-100">
            <div class="row h-100">
                <div class="col-md-12 min-vh-100 d-flex flex-column justify-content-center">
                    <div class="row">
                        <div class="col-lg-6 col-md-8 mx-auto">

                            <!-- form card login -->
                            <div class="card rounded shadow shadow-sm">
                                <div class="card-header">
                                    <h4 class="mb-0">Projekt týmu <b>Grenade</b> do předmětu RSP</h4>
                                </div>
                                <div class="card-body">
                                    <form action="vstup.php" class="form" role="form" autocomplete="off" id="formLogin" novalidate="" method="POST">
                                        <div class="form-group">
                                            <label>Heslo pro vstup</label>
                                            <input type="password" class="form-control rounded-0" id="pwd1" name="pwd1" required="" autocomplete="new-password">
                                            <div class="invalid-feedback">Zadejte heslo!</div>
                                        </div>
                                        <button type="submit" class="btn btn-info float-right" id="btnLogin">Vstoupit</button>
                                    </form>
                                </div>
                                <div class="card-footer">
                                    <div class="text-muted text-center">Created by @teamGrenade</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
