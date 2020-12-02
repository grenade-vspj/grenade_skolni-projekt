<?php
    require "conn.php";
    require "opravneni.php";
    require "functions.php";
    require "redaktor_private.php";

    $id_login = $_SESSION['id'];

    $_SESSION['zprava'] = 'Chyba - něco se nepovedlo!';
    $_SESSION['kod_zpravy'] = 'danger';

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
    }

    header("Location: redaktor.php");
    exit();
?>