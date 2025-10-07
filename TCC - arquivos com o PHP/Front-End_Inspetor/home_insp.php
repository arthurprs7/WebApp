<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}


$perfil_verifica = '3';
include('../verifica.php');


// Para exibir o nome
$nomeUsuario = $_SESSION['nome_usuario'];
?>


<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="header_insp.css">
    <title>CEC</title>
    
    <style>
        body::-webkit-scrollbar {
            display: none;
            margin: 0;
            background: #f8f9fa;
        }

        main {
            padding: 2rem;
        }

        h1 {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 2rem;
            color: #1f2937;
            text-align: center;
        }

        .table-section {
            background: #e5e7eb;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 2rem;
        }

        .table-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 1rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
        }

        td,
        th {
            text-align: center;
            padding: .6rem;
            border: 1px solid #e5e7eb;
        }

        .empty-state {
            text-align: center;
            color: #9ca3af;
            font-style: italic;
            padding: 1rem;
        }

        @media (max-width:768px) {
            h1 {
                font-size: 1.6rem;
                margin-bottom: 1.5rem;
            }
        }

        @media (max-width:576px) {
            h1 {
                font-size: 1.4rem;
            }

            td,
            th {
                padding: .4rem;
                font-size: .8rem;
            }
        }
    </style>
</head>

<body>
    <?php 
    include '../alert/alert.php'
    ?>
    <header class="header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-6 col-md-3">
                    <div class="logo-container">
                        <img src="../Imagens/logo-png.png" alt="logo">
                    </div>
                </div>
                <div class="col-6 col-md-9">
                    <div class="nav-icons justify-content-end">
                        <a href="home_insp.php">
                            <div class="nav-icon"><i class="bi bi-house-door-fill"></i></div> 
                        </a> <!-- HOMEPAGE-->

                        <a href="solicitacao_insp.php">
                            <div class="nav-icon"><i class="bi bi-bell-fill"></i></div>
                        </a> <!-- NOTIFICAÇÕES ou SOLICITAÇÕES TEM QUE VER ISSO AQUI -->

                        <a href="">
                            <div class="nav-icon"><i class="bi bi-tv-fill"></i></div>
                        </a> <!-- EQUIPAMENTOS -->

                        <a href="atrasos_insp.php">
                            <div class="nav-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        </a> <!-- ATRASOS -->

                        <a href="perfil_insp.php">
                            <div class="nav-icon"><i class="bi bi-person-fill"></i></div>
                        </a> <!-- PERFIL-->

                        <a href="">
                            <div class="nav-icon"><i class="bi bi-gear-fill"></i></div> 
                        </a> <!-- CONFIGURAÇÕES-->

                    </div>
                </div>
            </div>
        </div>
    </header>

    <main>
        <h1 class="welcome-title">BEM-VINDO, <?= strtoupper(htmlspecialchars($nomeUsuario)); ?></h1>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="table-section">
                    <div class="table-title">HISTÓRICO RECENTE</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Professor</th>
                                <th>Aparelho</th>
                                <th>Data</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="empty-state">...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-lg-6 col-md-12">
                <div class="table-section">
                    <div class="table-title">ATRASOS</div>
                    <table>
                        <thead>
                            <tr>
                                <th>Professor</th>
                                <th>Aparelho</th>
                                <th>Data</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="4" class="empty-state">...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../script.js"></script>
</html>