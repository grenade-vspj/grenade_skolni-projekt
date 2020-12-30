<?php
    require "conn.php";
    require "opravneni.php";
    require "functions.php";
    require "kontrola_prihlaseni.php";
    require "redaktor_private.php";

    $id_login = $_SESSION['id'];

    $cislo_casopisu = $_GET["cislo_casopisu"];
    if (!isset($cislo_casopisu)) {
        header("Location: redaktor.php?tab=cisla-content");
        exit();
    }

    $zprava = '';
    $kod_zpravy = '';
    if (isset($_GET["akce"]) && !empty($_GET["akce"])) {
        if ($_GET["akce"] == 'tisk') {
            if ($conn->query("UPDATE sablony SET tisk = true WHERE cislo_casopisu = '$cislo_casopisu'")) {
                $zprava = 'Úspěšně potvrzeno odeslání do tisku';
                $kod_zpravy = 'success';
            } else {
                $zprava = 'Chyba - něco se nepovedlo!';
                $kod_zpravy = 'danger';
            }
        } else if ($_GET["akce"] == 'upload') {
            $file = $_FILES['file'];

            $fileName = $_FILES['file']['name'];
            $fileTmpName =  $_FILES['file']['tmp_name'];
            $fileSize = $_FILES['file']['size'];
            $fileError = $_FILES['file']['error'];
            $fileType = $_FILES['file']['type'];

            $fileExt = explode('.', $fileName);
            $fileActualExt = strtolower(end($fileExt));

            $allowed = array('pdf', 'doc', 'docx');
            $created = false;

            if (in_array($fileActualExt, $allowed)) {
                if ($fileError === 0) {
                    if ($fileSize < 10485760) {
                        $fileDestination = 'sablony/LP-'. $cislo_casopisu .'_'. $fileName;

                        if (move_uploaded_file($fileTmpName, $fileDestination)) {
                            $zprava = 'Soubor byl úspěšně nahrán.';
                            $kod_zpravy = 'success';
                            $created = true;
                        } else {
                            $zprava = 'Soubor se nepodařilo nahrát.';
                            $kod_zpravy = 'danger';
                        }
                    } else {
                        $zprava = 'Soubor je příliš velký.';
                        $kod_zpravy = 'danger';
                    }
                } else {
                    $zprava = 'Nelze uploadovat.';
                    $kod_zpravy = 'danger';
                }
            } else {
                $zprava = 'Nelze nahrát soubor tohoto typu. Povolené typy jsou pdf, doc, docx.';
                $kod_zpravy = 'danger';
            }

            // Pokud se vytvořil soubor na serveru, vložit do databáze
            if ($created === true) {
                $conn->query("INSERT INTO sablony(cislo_casopisu, cesta) VALUES('$cislo_casopisu', '$fileDestination') ON DUPLICATE KEY UPDATE cesta = '$fileDestination'");
            }
            unset($_FILES['file']);
        }
        unset($_GET["akce"]);
    }

    $sablona = sablona_podle_cisla($conn, $cislo_casopisu);
?>

<!doctype html>
<html lang="en">
    <?php include "head.php" ?>
    <body>
        <?php include "top.php" ?>
        <main role="main" class="container">
            <?php include "redaktor_header.php" ?>

            <div class="card">
                <h5 class="card-header">Tisková šablona pro vydavatele</h5>
                <div class="card-body">
                    <h5 class="card-title">Číslo časopisu: <?= $cislo_casopisu ?></h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <dl class="row">
                                <dt class="col-sm-4 text-md-right">Šablona:</dt>
                                <dd class="col-sm-8">
                                    <a target="_blank" href="<?= $sablona['cesta'] ?>"><?= jmeno_souboru_z_cesty($sablona['cesta']) ?></a>
                                </dd>
                                <dt class="col-sm-4 text-md-right">Odesláno do tisku:</dt>
                                <dd class="col-sm-8"><?php echo ($sablona['tisk'] ? 'Ano' : 'Ne'); ?></dd>
                            </dl>
                            <dl>
                                <?php
                                    $clanky_url = '';
                                    $url = url_aktualniho_adresare();
                                    $vypsani = $conn->query("SELECT clanky.* FROM clanky WHERE clanky.cislo_casopisu = '$cislo_casopisu' AND clanky.id_stav = 7 ORDER BY id_clanek ASC");
                                    while ($data = $vypsani->fetch_assoc()) {
                                        $id = $data['id_clanek'];
                                        $clanek = nejnovejsi_verze_clanku($conn, $id);
                                        $clanky_url .= rawurlencode($url . $clanek['cesta']). '%0D%0A';
                                    }
                                    $to = rawurlencode('tisk@vydavatel.cz');
                                    $subject = rawurlencode('Tisk časopisu Logos Polytechnikos číslo '. $cislo_casopisu);
                                    $body = rawurlencode('Vážené vydavatelství,').'%0D%0A%0D%0A'.
                                        rawurlencode('prosím o tisk nejnovějšího čísla '. $cislo_casopisu .' časopisu Logos Polytechnikos.').'%0D%0A'.
                                        rawurlencode('Šablona pro tisk: '. $url . $sablona['cesta']).'%0D%0A%0D%0A'.
                                        rawurlencode('Jednotlivé články:').'%0D%0A'.
                                        $clanky_url.'%0D%0A%0D%0A'.
                                        rawurlencode('S pozdravem').'%0D%0A%0D%0A'.
                                        rawurlencode('Redaktor časopisu Logos Polytechnikos').'%0D%0A';
                                    $mailto = 'mailto:?'.'to='.$to.'&subject='.$subject.'&body='.$body;
                                ?>
                                <a href="<?= $mailto ?>" class="btn btn-warning <?php echo ($sablona['cesta'] ? '' : 'disabled'); ?>">Odeslat email vydavateli</a>
                                <a href="redaktor_sablona.php?cislo_casopisu=<?= $cislo_casopisu ?>&akce=tisk"
                                   class="btn btn-success <?php echo ($sablona['tisk'] || empty($sablona['cesta']) ? 'disabled' : ''); ?>"
                                   onclick="return confirm(`Opravdu chcete potvrdit, že toto číslo časopisu bylo odesláno vydavateli do tisku?`);"
                                >Potvrdit odeslání do tisku</a>
                            </dl>
                        </div>
                        <div class="col-sm-6">
                            <dl class="row">
                                <div class="container">
                                    <dt class="col-sm-12 text-md-left">
                                        <a href="#" class="btn btn-link collapsed" data-toggle="collapse" data-target="#clanky">
                                            <i class="fa fa-angle-right"></i>
                                            Zveřejněné články pro tisk:
                                        </a>
                                    </dt>
                                    <dd class="col-sm-12">
                                        <p id="clanky" class="collapse row">
                                        <?php
                                            $vypsani = $conn->query("SELECT clanky.* FROM clanky WHERE clanky.cislo_casopisu = '$cislo_casopisu' AND clanky.id_stav = 7 ORDER BY id_clanek ASC");
                                            while ($data = $vypsani->fetch_assoc()) {
                                                $id = $data['id_clanek'];
                                                $clanek = nejnovejsi_verze_clanku($conn, $id);
                                                echo '<a target="_blank" href="'. $clanek['cesta'] .'" class="col-sm-12 ml-4">'. jmeno_souboru_z_cesty($clanek['cesta']) .'</a>';
                                            }
                                        ?>
                                        </p>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                    <hr/>
                    <form action="redaktor_sablona.php?cislo_casopisu=<?= $cislo_casopisu ?>&akce=upload" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="file">Cesta k souboru tiskové šablony:</label>
                            <input type="file" class="form-control-file" id="file" name="file" accept=".doc, .docx, .pdf" required/>
                        </div>
                        <button type="submit" class="btn btn-primary">Nahrát na server</button>
                        <a href="redaktor.php?tab=cisla-content" class="btn btn-secondary">Zpět</a>
                    </form>
                </div>
            </div>
        </main>
        <br/>
        <?php include "footer.php" ?>
    </body>
</html>

<?php $conn -> close(); ?>
