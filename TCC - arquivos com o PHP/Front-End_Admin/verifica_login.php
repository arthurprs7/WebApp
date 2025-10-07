<?php
session_start();

// Se não estiver logado, redireciona para a página de login
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php"); // ajuste o caminho conforme sua estrutura
    exit();
}

function verificaTipo($tipoNecessario) {
    if ($_SESSION['perfil'] != $tipoNecessario) {
        // se não for do tipo permitido, redireciona para login ou página de erro
        header("Location: ../login.php");
        exit();
    }
}
?>
