<?php
    require "kontrola_vstup.php";

    header("Cache-control: private");
    if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['username']) || ($_SESSION['username'] == "")) {
        header("Location: error-alert.php?redirect=prihlas.php&zprava=".rawurlencode("K přístupu na požadovanou adresu musíte být přihlášen."));
        exit();
    }
?>