<?php

    function ma_opravneni_redaktora() {
        $opravneni = array("redaktor", "sef_redaktor", "admin");
        return in_array($_SESSION['prava'], $opravneni);
    }

?>