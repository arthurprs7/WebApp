<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$perfil_verifica = '3';
include('../verifica.php');

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
        :root {
            --primary-blue: #1e3a8a;
            --secondary-blue: #3b82f6;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
        }

        .main-content {
            padding: 2rem 0;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .page-title {
            text-align: center;
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }


        .requests-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }


        .table thead th {
            background: var(--medium-gray);
            text-align: center;
        }


        .table tbody td {
            text-align: center;
            vertical-align: middle;
            border: 1px solid var(--medium-gray);
        }


        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>

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

    <main class="main-content container-fluid">
        <h1 class="page-title">ATRASOS</h1>

        <div class="requests-table table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Professor</th>
                        <th>Aparelho</th>
                        <th>Data e Hora</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>Ferrini</td>
                        <td>DataShow</td>
                        <td>15/08/2025 - 13:00</td>
                        <td>Devolvido</td>
                    </tr>

                    <tr>
                        <td>Enso</td>
                        <td>Notebook 24</td>
                        <td>15/08/2025 - 09:00</td>
                        <td>Não devolvido</td>
                    </tr>

                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                    </tr>

                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                    </tr>

                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                    </tr>

                    <tr>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                        <td>...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>