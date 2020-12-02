<?php
    $redirect = "index.php";
    if ($_GET['redirect'] != '') {
        $redirect = rawurldecode($_GET['redirect']);
    }
    $alert = rawurldecode($_GET['zprava']);
?>

<!doctype html>
<html lang="en">
    <head>
        <script language="Javascript" type="text/javascript">
            <?php
                if ($alert != "") {
                    echo 'window.alert("'.$alert.'");';
                }
                echo 'window.location.href = "/' . $redirect . '";';
            ?>
        </script>
    </head>
</html>
