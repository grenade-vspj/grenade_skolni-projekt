<?php
    require_once "opravneni.php";

    header("Cache-control: private");
    if(!ma_opravneni_recenzenta()) {
        header("Location: error-alert.php?redirect=index.php&zprava=".rawurlencode("K přístupu na požadovanou adresu musíte mít oprávnění recenzenta."));
        exit();
    }
?>