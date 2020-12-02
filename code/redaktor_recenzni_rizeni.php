<?php
    require "conn.php";
    require "opravneni.php";
    require "functions.php";
    require "redaktor_private.php";

    $id_login = $_SESSION['id'];

    $id_clanku = $_GET["id_clanku"];
    $clanek = clanek_podle_id($conn, $id_clanku);
    if (empty($id_clanku) || empty($clanek['id_clanek'])) {
        header("Location: redaktor.php");
        exit();
    }

    $zprava = '';
    $kod_zpravy = '';
    if(!empty($_POST["akce"]) AND $_POST["akce"] == 'k-recenzi'){
        $recenzent1 = $_POST["id_recenzent_1"];
        $recenzent2 = $_POST["id_recenzent_2"];
        $termin = $_POST["termin"];

        if(!empty($recenzent1) && !empty($recenzent2) && !empty($termin)){
            if ($conn->query("UPDATE clanky SET id_stav = 3, termin_recenze = '$termin', id_recenzent1 = '$recenzent1', id_recenzent2 = '$recenzent2', hodnoceni_recenzent1 = NULL, hodnoceni_recenzent2 = NULL WHERE id_clanek = '$id_clanku'")) {
                $zprava = 'Úspěšně odesláno k recenzi';
                $kod_zpravy = 'success';
            } else {
                $zprava = 'Chyba - něco se nepovedlo!';
                $kod_zpravy = 'danger';
            }
            $clanek = clanek_podle_id($conn, $id_clanku);
            if (empty($id_clanku) || empty($clanek['id_clanek'])) {
                header("Location: redaktor.php");
                exit();
            }
            $_POST["akce"] = "";
        }
    }
?>

<!doctype html>
<html lang="en">
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>
        <main role="main" class="container">
            <?php include "redaktor_header.php" ?>

            <div class="card">
                <h5 class="card-header">Odeslat do recenzního řízení</h5>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $clanek['nazev'] ?></h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <dl class="row">
                                <dt class="col-sm-4 text-md-right">Autor:</dt>
                                <dd class="col-sm-8"><?php
                                    $autor = uzivatel_podle_id($conn, $clanek['id_autor']);
                                    echo $autor['prijmeni'] . ' ' . $autor['jmeno'];
                                ?></dd>
                                <dt class="col-sm-4 text-md-right">Stav:</dt>
                                <dd class="col-sm-8"><?php echo $clanek['nazev_stav']; ?></dd>
                                <dt class="col-sm-4 text-md-right">Termín recenze:</dt>
                                <dd class="col-sm-8"><?php echo $clanek['termin_recenze']; ?></dd>
                                <dt class="col-sm-4 text-md-right">Recenzent 1:</dt>
                                <dd class="col-sm-8"><?php
                                    $recenzent1 = uzivatel_podle_id($conn, $clanek['id_recenzent1']);
                                    echo $recenzent1['prijmeni'] . ' ' . $recenzent1['jmeno'];
                                    ?></dd>
                                <dt class="col-sm-4 text-md-right">Recenzent 2:</dt>
                                <dd class="col-sm-8"><?php
                                    $recenzent2 = uzivatel_podle_id($conn, $clanek['id_recenzent2']);
                                    echo $recenzent2['prijmeni'] . ' ' . $recenzent2['jmeno'];
                                ?></dd>
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl class="row">
                                <div class="container">
                                    <dt class="col-sm-12 text-md-center">
                                        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#hodnoceni1">
                                            <i class="fa fa-angle-right"></i>
                                            Hodnocení recenzenta 1:
                                        </a>
                                    </dt>
                                    <dd>
                                        <p id="hodnoceni1" class="collapse"><?php echo $clanek['hodnoceni_recenzent1'] ?></p>
                                    </dd>
                                </div>
                                <div class="container">
                                    <dt class="col-sm-12 text-md-center">
                                        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#hodnoceni2">
                                            <i class="fa fa-angle-right"></i>
                                            Hodnocení recenzenta 2:
                                        </a>
                                    </dt>
                                    <dd>
                                        <p id="hodnoceni2" class="collapse"><?php echo $clanek['hodnoceni_recenzent2'] ?></p>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <form action="redaktor_recenzni_rizeni.php?id_clanku=<?php echo $clanek['id_clanek'] ?>" method="post">
                        <div class="form-group">
                            <label for="termin">Termín recenze</label>
                            <input type="datetime-local" class="form-control" id="termin" name="termin" required>
                        </div>
                        <div class="form-group">
                            <label for="id_recenzent_1">Recenzent 1</label>
                            <select class="form-control" id="id_recenzent_1" name="id_recenzent_1" required>
                                <option value="" selected disabled></option>
                                <?php
                                $recenzenti = $conn->query("SELECT id, prihlas_jmeno, jmeno, prijmeni, prava FROM ucet WHERE prava = 'recenzent' ORDER BY prijmeni, jmeno, id");
                                while ($data = $recenzenti->fetch_assoc()) {
                                    echo '<option value="' . $data['id'] . '">' . $data['prijmeni'] . " " . $data['jmeno'] . " - " . $data['prihlas_jmeno'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="id_recenzent_2">Recenzent 2</label>
                            <select class="form-control" id="id_recenzent_2" name="id_recenzent_2" required>
                                <option value="" selected disabled></option>
                                <?php
                                $recenzenti = $conn->query("SELECT id, prihlas_jmeno, jmeno, prijmeni, prava FROM ucet WHERE prava = 'recenzent' ORDER BY prijmeni, jmeno, id");
                                while ($data = $recenzenti->fetch_assoc()) {
                                    echo '<option value="' . $data['id'] . '">' . $data['prijmeni'] . " " . $data['jmeno'] . " - " . $data['prihlas_jmeno'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <input type="hidden" name="akce" value="k-recenzi"/>
                        <button type="submit" class="btn btn-primary">Odeslat recenzentům</button>
                        <a href="redaktor.php" class="btn btn-secondary">Zpět</a>
                    </form>
                </div>
            </div>


        </main>
        <br/>
        <?php include "footer.php" ?>
    </body>
</html>

<?php $conn -> close(); ?>
