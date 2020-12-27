<?php
    function barva_stavu_clanku($id_stav) {
        switch ($id_stav) {
            case 1: // Zadán
                return 'dark'; // 'info'
            case 2: // Stanovení recenzentů
                return 'secondary';
            case 3: // Recenzní řízení
                return 'primary';
            case 4: // Doplnění
                return 'warning';
            case 5: // Přijato
                return 'success';
            case 6: // Zamítnuto
                return 'danger';
            case 7: // Zveřejněno
                return 'info';
            default:
                return 'default';
        }
    }

    function table_barva_stavu_clanku($id_stav) {
        return 'table-' . barva_stavu_clanku($id_stav);
    }

    function uzivatel_podle_id($conn, $id_uzivatel) {
        $uzivatel = array("prihlas_jmeno"=>"", "jmeno"=>"", "prijmeni"=>"");
        if ($id_uzivatel != '') {
            $data = $conn->query("SELECT ucet.prihlas_jmeno, ucet.jmeno, ucet.prijmeni FROM ucet WHERE ucet.id = " . $id_uzivatel);
            if (!$data) {
                trigger_error('Invalid query: ' . $conn->error);
            } else {
                if ($data->num_rows > 0) {
                    $uzivatel = $data->fetch_assoc();
                }
            }
        }
        return $uzivatel;
    }

    function nejnovejsi_verze_clanku($conn, $id_clanek) {
        $clanek = array("id_verze"=>"", "id_clanek"=>"", "cesta"=>"", "datum"=>"");
        if ($id_clanek != '') {
            $data = $conn->query("SELECT verze.id_verze, verze.id_clanek, verze.cesta, verze.datum FROM verze WHERE verze.id_clanek = " . $id_clanek . " ORDER BY id_verze DESC");
            if (!$data) {
                trigger_error('Invalid query: ' . $conn->error);
            } else {
                if ($data->num_rows > 0) {
                    $clanek = $data->fetch_assoc();
                }
            }
        }
        return $clanek;
    }

    function clanek_podle_id($conn, $id_clanek) {
        $clanek = array("id_clanek"=>"", "id_autor"=>"", "id_stav"=>"", "nazev"=>"", "id_resitel"=>"", "id_recenzent1"=>"", "id_recenzent2"=>"", "hodnoceni_recenzent1"=>"", "hodnoceni_recenzent2"=>"", "termin_recenze"=>"", "cislo_casopisu"=>"", "nazev_stav"=>"");
        if ($id_clanek != '') {
            $data = $conn->query("SELECT clanky.*, stav.nazev AS nazev_stav FROM clanky INNER JOIN stav ON clanky.id_stav = stav.id WHERE clanky.id_clanek = " . $id_clanek);
            if (!$data) {
                trigger_error('Invalid query: ' . $conn->error);
            } else {
                if ($data->num_rows > 0) {
                    $clanek = $data->fetch_assoc();
                }
            }
        }
        return $clanek;
    }

    function je_stranka_aktivni($odpovidajici_php_stranka) {
        $soucasna_stranka = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
        return $soucasna_stranka == $odpovidajici_php_stranka;
    }

    function aktivni_zalozka($odpovidajici_php_stranka) {
        return je_stranka_aktivni($odpovidajici_php_stranka) ? ' active' : '';
    }

?>