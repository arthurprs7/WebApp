<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$perfil_verifica = '1';
include('../verifica.php');


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="header_admin.css">
    <title>CEC</title>

    <style>
        /* Garente que o corpo ocupe toda a altura da tela */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body::-webkit-scrollbar {
            display: none;
            display: flex;
            flex-direction: column;
            /* Para que header, h1 e main se organizem verticalmente */
        }

        .page-title {
            text-align: center;
            font-size: 1.8rem;
            font-weight: bold;
            background-color: #d0d0d0;
            padding: 20px 0;
            margin-bottom: 0;
        }

        main {
            flex-grow: 1;
            /* Faz com que o main ocupe todo o espaço vertical restante */
            display: flex;
            justify-content: center;
            /* Centraliza horizontalmente */
            align-items: center;
            /* Centraliza verticalmente */
            padding: 20px;
            width: 100%;
            box-sizing: border-box;
            /* padding e borda no width/height total */
        }


        a {
            text-decoration: none;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            /* Duas colunas de igual largura por padrão */
            gap: 20px;
            max-width: 700px;
            width: 100%;
            /* caixa ocupa a largura total disponível até max-width */
        }

        .dashboard-card {
            background: #e5e7eb;
            border-radius: 12px;
            padding: 20px 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 80px;
            font-weight: bold;
            font-size: 1.5rem;
            line-height: 1.3;
            /* Espaçamento entre as linhas */
            color: #000000ff;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.24);
        }

        @media (max-width:992px) {
            .dashboard-grid {
                grid-template-columns: repeat(2, 1fr);
                /* duas colunas */
                gap: 30px;
            }

            .dashboard-card {
                font-size: 1.3rem;
                padding: 15px 10px;
                min-height: 100px;
            }
        }

        @media (max-width:768px) {

            /* Para tablets e telas menores */
            h1 {
                font-size: 1.7rem;
            }

            .dashboard-grid {
                grid-template-columns: 1fr;
                /* Uma coluna em telas menores */
                max-width: 400px;
                /* Largura máxima para os cards em uma coluna */
                gap: 15px;
            }

            .dashboard-card {
                font-size: 1.2rem;
                padding: 20px 15px;
                min-height: 100px;
            }
        }

        @media (max-width:576px) {

            /* Para celulares */
            .dashboard-card {
                padding: 15px 10px;
                font-size: 1rem;
                min-height: 90px;
            }

            .dashboard-grid {
                gap: 25px;
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


                        <a href="home_admin.php">
                            <div class="nav-icon"><i class="bi bi-house-door-fill"></i></div>
                        </a> <!-- HOMEPAGE-->

                        <a href="">
                            <div class="nav-icon"><i class="bi bi-tv-fill"></i></div>
                        </a> <!-- EQUIPAMENTOS -->

                        <a href="cadastros_admin.php">
                            <div class="nav-icon"><i class="bi bi-plus-square-fill"></i></div>
                        </a> <!-- CADASTRAR -->

                        <a href="">
                            <div class="nav-icon"><i class="bi bi-bell-fill"></i></div>
                        </a> <!-- NOTIFICAÇÕES -->

                        <a href="">
                            <div class="nav-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
                        </a> <!-- ATRASOS -->

                        <a href="">
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

    <h1 class="page-title p-4">CADASTROS</h1>

    <main>
        <div class="dashboard-grid">

            <a href="cadastro_usuario_admin.php">
                <div class="dashboard-card">
                    USUÁRIO
                </div>
            </a>

            <a href="">
                <div class="dashboard-card">
                    USUÁRIOS REGISTRADOS NO SISTEMA
                </div>
            </a>

            <a href="cadastro_equip_admin.php">
                <div class="dashboard-card">
                    EQUIPAMENTO
                </div>
            </a>

            <a href="">
                <div class="dashboard-card">
                    EQUIPAMENTOS REGISTRADOS NO SISTEMA
                </div>
            </a>
        </div>
    </main>

</body>

</html>