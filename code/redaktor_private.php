<?php
    header("Cache-control: private");
    if($_SESSION['prava'] !== "redaktor") {
        header("Location: error-alert.php?redirect=index.php&zprava=".rawurlencode("K pristupu na pozadovanou adresu musite mit opravneni redaktora."));
        exit();
    }
?>