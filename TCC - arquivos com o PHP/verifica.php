<?php 

if ($_SESSION['perfil'] !== $perfil_verifica) {
    header("Location: ../index.php");
    exit;
}

?>