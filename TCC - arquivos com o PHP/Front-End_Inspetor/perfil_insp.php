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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

  <link rel="stylesheet" href="header_insp.css">
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
      background-color: #fdfcf7;
    }

    .tabela {
      background-color: #fdfcf7;
      border: 1px solid #ccc;
    }

    .titulo-tabela {
      background-color: #eceae0;
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
      background-color: #eceae0;
      border: none;
      padding: 10px 15px;
      font-size: 14px;
      cursor: pointer;
      border-radius: 6px;
      color: #000;
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

        <div class="botoes">

          <button class="btn">
            <i class="bi bi-exclamation-circle-fill"></i> Avisos
          </button>

          <button class="btn">
            <i class="bi bi-clock-history"></i> Histórico geral
          </button>

          <button class="btn">
            <i class="bi bi-gear-fill"></i> Configurações
          </button>

          <button class="btn">
            <i class="bi bi-box-arrow-right"></i> Sair
          </button>
        </div>

    </div>

    </aside>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>