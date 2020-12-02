<?php
    header("Cache-control: private");
    if(!ma_opravneni_redaktora()) {
        header("Location: error-alert.php?redirect=index.php&zprava=".rawurlencode("K pristupu na pozadovanou adresu musite mit opravneni redaktora."));
        exit();
    }
?>