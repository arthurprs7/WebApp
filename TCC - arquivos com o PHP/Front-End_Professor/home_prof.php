<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$perfil_verifica = '2';
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
    <link rel="stylesheet" href="header_prof.css">
    <title>CEC</title>

    <style>
        body::-webkit-scrollbar {
            display: none;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 40px;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
        }

        .dashboard-card {
            height: 300px;
            background: #e5e7eb;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.24);
        }

        .card-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #374151;
            text-align: center;
            margin-bottom: 25px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        @media (max-width:768px) {
            .welcome-title {
                font-size: 1.8rem;
                margin-bottom: 30px;
            }

            .dashboard-card {
                padding: 20px;
                margin-bottom: 15px;
            }
        }

        @media (max-width:576px) {
            .welcome-title {
                font-size: 1.5rem;
                text-align: center;
            }

            .dashboard-card {
                padding: 15px;
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

                        <a href="home_prof.php">
                            <div class="nav-icon"> <i class="bi bi-house-door-fill"></i></div>
                        </a> <!--HOMEPAGE-->

                        <a href="equipamentos_prof.php">
                            <div class="nav-icon"><i class="bi bi-tv-fill"></i></div>
                        </a><!--EQUIPAMENTOS-->

                        <a href="">
                            <div class="nav-icon"><i class="bi bi-clock-history"></i></div>
                        </a> <!--HISTÓRICO-->

                        <a href="perfil_prof.php">
                            <div class="nav-icon"><i class="bi bi-person-fill"></i></div>
                        </a> <!--PERFIL-->

                    </div>
                </div>
            </div>
        </div>
    </header>

    <main class="main-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <h1 class="welcome-title">BEM-VINDO, <?= strtoupper(htmlspecialchars($nomeUsuario)); ?>!</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="dashboard-card">
                        <h2 class="card-title"><i class="bi bi-bell-fill me-2"></i>NOTIFICAÇÃO</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="dashboard-card">
                        <h2 class="card-title"><i class="bi bi-laptop-fill me-2"></i>EMPRESTADOS</h2>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="dashboard-card">
                        <h2 class="card-title"><i class="bi bi-chat-dots-fill me-2"></i>RECADOS</h2>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../script.js"></script>
</html>