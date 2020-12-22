<?php

    function je_uzivatel_prihlasen() {
        if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['username'])) {
            return false;
        } else {
            return !($_SESSION['username'] == "");
        }
    }

    function ma_opravneni_redaktora() {
        $opravneni = array("redaktor", "sef_redaktor", "admin");
        return je_uzivatel_prihlasen() && in_array($_SESSION['prava'], $opravneni);
    }

    function ma_opravneni_admina() {
        $opravneni = array("admin");
        return je_uzivatel_prihlasen() && in_array($_SESSION['prava'], $opravneni);
    }

    function ma_opravneni_recenzenta() {
        $opravneni = array("recenzent", "admin");
        return je_uzivatel_prihlasen() && in_array($_SESSION['prava'], $opravneni);
    }

    function ma_opravneni_autora() {
        $opravneni = array("autor", "admin");
        return je_uzivatel_prihlasen() && in_array($_SESSION['prava'], $opravneni);
    }

?>