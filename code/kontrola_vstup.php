<?php
    header("Cache-control: private");
    if (session_status() == PHP_SESSION_NONE || !isset($_SESSION['vstup']) || ($_SESSION['vstup'] != 1) || !isset($_SESSION['expire']) || $_SESSION['expire'] < time()) {
        session_write_close();
        session_unset();
        session_destroy();
        $_SESSION = array();
        header("Location:vstup.php");
        exit();
    } else {
        $_SESSION['expire'] = time() + 30 * 60;
    }
?>