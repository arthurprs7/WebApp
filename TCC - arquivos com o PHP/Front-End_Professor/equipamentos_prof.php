<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$perfil_verifica = '2';
include('../verifica.php');

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
        .equipment-icon i {
            font-size: 2rem;
            color: #000000ff;
        }

        a {
            text-decoration: none;
            color: black;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        .equipment-item {
            font-weight: bold;
        }
        
        .equipment-item:hover {
            background-color: #e5e7eb;
        }

        .btn-light i {
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
                gap: 5px;
            }
        }
    </style>
</head>

<body class="bg-light">

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


    <main class="container py-4">

        <div class="input-group mb-4">
            <span class="input-group-text bg-secondary-subtle"><i class="bi bi-search"></i></span>
            <input type="text" class="form-control" placeholder="Pesquisar equipamentos">
        </div>

        <div class="row g-4">

            <div class="col-lg-6 col-md-12">
                <div class="bg-body rounded shadow-sm p-3">
                    
                    <h5 class="text-center fw-bold mb-3">EQUIPAMENTOS</h5>

                    <a href="televisao_prof.php">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom py-2">
                        <span>TELEVISÃO</span>
                        <div class="equipment-icon"><i class="bi bi-tv-fill"></i></div>
                    </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>NOTEBOOK</span>
                            <div class="equipment-icon"><i class="bi bi-laptop"></i></div>
                        </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>CHROMEBOOK</span>
                            <div class="equipment-icon"><i class="bi bi-laptop"></i></div>
                        </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>TABLET</span>
                            <div class="equipment-icon"><i class="bi bi-tablet"></i></div>
                        </div>                        
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom py-2">
                            <span>PROJETOR</span>
                            <div class="equipment-icon"><i class="bi bi-projector"></i></div>
                        </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center py-2">
                            <span>FONES</span>
                            <div class="equipment-icon"><i class="bi bi-headphones"></i></div>
                        </div>
                    </a>


                </div>
            </div>

            <div class="col-lg-6 col-md-12">
                <div class="bg-body rounded shadow-sm p-3">
                    <h5 class="text-center fw-bold mb-3">STATUS DE EMPRÉSTIMO</h5>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle">
                            <thead class="table-secondary">
                                <tr>
                                    <th>Aparelho</th>
                                    <th>Status</th>
                                    <th>Data</th>
                                    <th>Hora</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td>Tablet</td>
                                    <td><span class="badge bg-warning text-dark">Em uso</span></td>
                                    <td>26/09/2025</td>
                                    <td>14:00</td>
                                </tr>
                                <tr>
                                    <td>Notebooks</td>
                                    <td><span class="badge bg-warning text-dark">Em uso</span></td>
                                    <td>26/09/2025</td>
                                    <td>13:30</td>
                                </tr> 

                                <tr>
                                    <td>Chromebook</td>
                                    <td><span class="badge bg-success">Devolvido</span></td>
                                    <td>17/07/2025</td>
                                    <td>13:20</td>
                                </tr>

                                <tr>
                                    <td>Televisão</td>
                                    <td><span class="badge bg-success">Devolvido</span></td>
                                    <td>25/07/2025</td>
                                    <td>11:00</td>
                                </tr>
                                <tr>
                                    <td>Projetor</td>
                                    <td><span class="badge bg-success">Devolvido</span></td>
                                    <td>05/08/2025</td>
                                    <td>15:00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>