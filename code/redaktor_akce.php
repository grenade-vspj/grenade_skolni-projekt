<?php
    require "conn.php";
    require "opravneni.php";
    require "functions.php";
    require "kontrola_prihlaseni.php";
    require "redaktor_private.php";

    $id_login = $_SESSION['id'];

    $_SESSION['zprava'] = 'Chyba - něco se nepovedlo!';
    $_SESSION['kod_zpravy'] = 'danger';

    if (isset($_GET["cislo_casopisu"])) {
        $cislo_casopisu = $_GET["cislo_casopisu"];
        if ($_GET["akce"] == 'zverejnit') {
            if ($conn->query("UPDATE clanky SET id_stav = 7 WHERE id_stav = 5 AND cislo_casopisu = '$cislo_casopisu'")) {
                $_SESSION['zprava'] = 'Zveřejněny články v čísle časopisu ' . $cislo_casopisu . '.';
                $_SESSION['kod_zpravy'] = 'success';
            }
            $_GET["akce"] = "";
            header("Location: redaktor.php?tab=cisla-content");
            exit();
        }
    } else {

        $id_clanku = $_GET["id_clanku"];
        $clanek = clanek_podle_id($conn, $id_clanku);
        if (empty($id_clanku) || empty($clanek['id_clanek'])) {
            header("Location: redaktor.php");
            exit();
        }

        if ($_GET["akce"] == 'zamitnout') {
            if ($conn->query("UPDATE clanky SET id_stav = 6 WHERE id_clanek = '$id_clanku'")) {
                $_SESSION['zprava'] = 'Článek zamítnut.';
                $_SESSION['kod_zpravy'] = 'success';
            }
            $_GET["akce"] = "";
        } else if ($_GET["akce"] == 'prijmout') {
            if ($conn->query("UPDATE clanky SET id_stav = 5 WHERE id_clanek = '$id_clanku'")) {
                $_SESSION['zprava'] = 'Článek schválen k přijetí.';
                $_SESSION['kod_zpravy'] = 'success';
            }
            $_GET["akce"] = "";
        } else if ($_GET["akce"] == 'doplnit') {
            if ($conn->query("UPDATE clanky SET id_stav = 4 WHERE id_clanek = '$id_clanku'")) {
                $_SESSION['zprava'] = 'Článek vrácen autorovi k doplnění.';
                $_SESSION['kod_zpravy'] = 'success';
            }
            $_GET["akce"] = "";
        } else if ($_GET["akce"] == 'zmenit' && isset($_GET["nove_cislo_casopisu"])) {
            $cislo_casopisu = $_GET["nove_cislo_casopisu"];
            if ($conn->query("UPDATE clanky SET cislo_casopisu = '$cislo_casopisu' WHERE id_clanek = '$id_clanku'")) {
                $_SESSION['zprava'] = 'Článek byl přesunut do jiného čísla časopisu.';
                $_SESSION['kod_zpravy'] = 'success';
            }
            $_GET["akce"] = "";
        }
//        else if ($_GET["akce"] == 'zverejnit') {
//            if ($conn->query("UPDATE clanky SET id_stav = 7 WHERE id_clanek = '$id_clanku'")) {
//                $_SESSION['zprava'] = 'Článek zveřejněn v čísle časopisu ' . '' . '.';
//                $_SESSION['kod_zpravy'] = 'success';
//            }
//            $_GET["akce"] = "";
//        }
    }

    header("Location: redaktor.php");
    exit();
?>

<?php $conn -> close(); ?>
