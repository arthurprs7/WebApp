<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$perfil_verifica = '2';
include('../verifica.php');

include "../Front-End_Admin/conect.php";

// Consulta com JOIN para obter o nome da marca
$sql = "
    SELECT e.*, m.nome AS marca_nome
    FROM equipamento e
    JOIN marca m ON e.id_marca = m.id_marca
";
$resultado = mysqli_query($con, $sql);

$equipamento = [];

while ($linha = mysqli_fetch_array($resultado)) {
    $equipamento[] = $linha;
}
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
            color: #1e3a8a;
        }

        body::-webkit-scrollbar {
            display: none;
        }

        a {
            text-decoration: none;
            color: black;
        }

        /* css da parte das TVs e equipamentos*/
        .equipment-item {
            padding: 10px 15px;
            transition: background-color 0.2s ;
            font-weight: bold;
        }

        .equipment-item:hover {
            background-color: #e5e7eb;
        }

        .equipment-item.active {
            background-color: #e5e7eb; /* Cor de fundo para o item selecionado */
            font-weight: bold;
        }
        
        .equipment-item .equipment-icon i {
            color: #000000ff;
        }



        .product-card {
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            text-align: center;
            padding: 10px;
            background-color: white;
            transition: box-shadow 0.3s;
        }

        .product-card:hover {
            box-shadow: 0px 0px 15px  #0000007f;
        }
        
        .product-card-img {
            max-width: 100%;
            height: auto;
            background-color: #ffffffff;
            height: 150px; 
            margin-bottom: 10px;
            border-radius: 0.25rem;
        }
        
        img {
            width: 200px;
        }

        .btn-lend { /*Botão EMPRESTAR*/
            background-color: #0e78a9;
            color: white;
            font-weight: 600;
            border: none;
        }

        .btn-lend:hover {
            background-color: #fd4463;
            color: white;
        }


        @media (max-width: 768px) {
            .page-title {
                font-size: 1.5rem;
            }

            /* o menu e a listagem das TVs ficam em colunas de 12 */
            .col-lg-3, .col-lg-9 {
                width: 100%;
            }
            
            /* Adiciona margem entre as colunas "equipamentos" e as TVs */
            .row.g-4 > .col-12:not(:last-child) {
                margin-bottom: 1rem;
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

            <div class="col-12 col-lg-3">
                <div class="bg-white rounded shadow-sm">
                    
                    <h5 class="text-center fw-bold pt-3 pb-2 mb-0 border-bottom">EQUIPAMENTOS</h5>

                    <a href="televisao_prof.php">
                        <div class="equipment-item active d-flex justify-content-between align-items-center border-bottom">
                        <span>TELEVISÃO</span>
                        <div class="equipment-icon"><i class="bi bi-tv-fill"></i></div>
                    </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom">
                            <span>NOTEBOOK</span>
                            <div class="equipment-icon"><i class="bi bi-laptop"></i></div>
                        </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom">
                            <span>CHROMEBOOK</span>
                            <div class="equipment-icon"><i class="bi bi-laptop"></i></div>
                        </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom">
                            <span>TABLET</span>
                            <div class="equipment-icon"><i class="bi bi-tablet"></i></div>
                        </div>                  
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center border-bottom">
                            <span>PROJETOR</span>
                            <div class="equipment-icon"><i class="bi bi-projector"></i></div>
                        </div>
                    </a>

                    <a href="">
                        <div class="equipment-item d-flex justify-content-between align-items-center">
                            <span>FONES</span>
                            <div class="equipment-icon"><i class="bi bi-headphones"></i></div>
                        </div>
                    </a>

                </div>
            </div>

            <!-- Parte das TVs-->
            <div class="col-12 col-lg-9">
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 g-3">
<?php foreach ($equipamento as $equipamentos): ?>
    <div class="col">
        <?php 
        $img = "../Imagens/tv_lg.png";
        $marca = $equipamentos['marca_nome']; // ✅ Corrigido
        $num = $equipamentos['numeracao'];
        include "../card-equipamento.php";
        ?>
    </div>
<?php endforeach; ?>

                          

                    
                </div>
            </div>

        </div>

    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>