<?php
    header("Cache-control: private");
    $opravneni = array("redaktor", "sef_redaktor", "admin");
    if(!in_array($_SESSION['prava'], $opravneni)) {
        header("Location: error-alert.php?redirect=index.php&zprava=".rawurlencode("K pristupu na pozadovanou adresu musite mit opravneni redaktora."));
        exit();
    }
?>