<?php
    header("Cache-control: private");
    if(!ma_opravneni_redaktora()) {
        header("Location: error-alert.php?redirect=index.php&zprava=".rawurlencode("K přístupu na požadovanou adresu musíte mít oprávnění redaktora."));
        exit();
    }
?>