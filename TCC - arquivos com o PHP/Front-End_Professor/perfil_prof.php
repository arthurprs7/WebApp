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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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

    .topo-cinza {
      background-color: #e4e4e4;
      height: 200px;
      width: 100%;
    }

    #perfil {
      margin-top: -60px;
    }

    .nome {
      font-size: 18px;
      font-weight: bold;
      margin-top: 10px;
      color: #000;
    }

    .dados {
      text-align: left;
      max-width: 400px;
      margin: 30px auto 0 auto;
    }

    .dados h2 {
      font-size: 12px;
      color: #000;
      margin-bottom: 20px;
    }

    .campo {
      margin-bottom: 20px;
    }

    .campo label {
      display: block;
      font-size: 12px;
      font-weight: bold;
      margin-bottom: 2px;
      color: #000;
    }

    .valor {
      border-bottom: 1px solid #ccc;
      padding: 4px 0;
      font-size: 14px;
      color: #000;
      margin: 0;
    }

    .historico-container {
      padding: 30px 20px;
      background-color: white;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.21);

    }

    .tabela {
      background-color: #ebebebff;
      border: none;
    }

    .titulo-tabela {
      background-color: #acacac;
      text-align: center;
      font-weight: bold;
      padding: 10px 0;
      color: #000;
    }

    table {
      width: 100%;
      border-collapse: collapse;
    }

    thead th {
      font-size: 12px;
      color: #000;
      border-bottom: 1px solid #ccc;
      padding: 10px;
      text-align: left;
    }

    tbody td {
      height: 40px;
      border-bottom: 1px solid #ccc;
      padding: 10px;
      color: #000;
    }

    .botoes {
      margin-top: 30px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .btn {
      display: flex;
      align-items: center;
      gap: 10px;
      background-color: #072855;
      border: none;
      padding: 10px 15px;
      font-size: 14px;
      cursor: pointer;
      border-radius: 6px;
      color: white;
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


  <div class="container my-4">
    <div class="row g-4">
      <main class="col-12 col-lg-8">
        <div class="topo-cinza"></div>

        <section class="conteudo text-center">
          <img src="../Imagens/Ícones/foto-perfil.png" alt="" id="perfil" width="110px">
          <p class="nome">Nome</p>

          <div class="dados">
            <h2>DADOS PESSOAIS</h2>

            <div class="campo">
              <label>NOME:</label>
              <p class="valor">Nome completo</p>
            </div>

            <div class="campo">
              <label>EMAIL:</label>
              <p class="valor">email@exemplo.com</p>
            </div>
          </div>
        </section>
      </main>

      <aside class="col-12 col-lg-4">
        <div class="historico-container">
          <div class="tabela">
            <div class="titulo-tabela">HISTÓRICO</div>
            <table>
              <thead>
                <tr>
                  <th>APARELHO</th>
                  <th>DATA</th>
                  <th>HORA</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Notebook</td>
                  <td>01/08</td>
                  <td>10:00</td>
                </tr>
                <tr>
                  <td>Tablet</td>
                  <td>03/08</td>
                  <td>14:15</td>
                </tr>
                <tr>
                  <td>PC</td>
                  <td>04/08</td>
                  <td>09:00</td>
                </tr>
                <tr>
                  <td>Notebook</td>
                  <td>05/08</td>
                  <td>16:45</td>
                </tr>
              </tbody>
            </table>
          </div>

          <div class="botoes">
            <button class="btn">
              <i class="bi bi-gear-fill"></i> Configurações
            </button>
            <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
              Desconectar
            </button>

            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <div class="text-center">
                      <h4>Confirmar Saída</h4>
                    </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a href="../logout.php" class="btn btn-primary">Sair</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </aside>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>