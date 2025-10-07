<?php
session_start();

include "conect.php"; // caminho deve estar certo

// Arrays para seleção no formulário
$tipos = [
    '1' => 'Televisão',
    '2' => 'Notebook',
    '3' => 'Chromebook',
    '4' => 'Tablet',
    '5' => 'Projetor',
    '6' => 'Fone'
];

$marcas = [
    '1' => 'Samsung',
    '2' => 'Google',
    '3' => 'Positivo',
    '4' => 'Lenovo',
    '5' => 'Lg',
    '6' => 'Outro'
];

// ===== CADASTRO =====
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'Cadastrar') {
    $tipo        = trim($_POST['tipo'] ?? '');
    $numeracao   = trim($_POST['numeracao'] ?? '');
    $marca       = trim($_POST['marca'] ?? '');
    $descricao   = trim($_POST['descricao'] ?? '');

    if (empty($tipo) || empty($numeracao) || empty($marca) || empty($descricao)) {
        echo "<script>alert('Preencha todos os campos!'); window.history.back();</script>";
        exit;
    }

    // Inserção no banco
    $sql = "INSERT INTO equipamento (tipo, numeracao, id_marca, descricao)
            VALUES ('$tipo', '$numeracao', '$marca', '$descricao')";

    if ($con->query($sql) === TRUE) {
        echo "<script>alert('Equipamento cadastrado com sucesso!'); window.location.href='cadastro_equip_admin.php';</script>";
        exit;
    } else {
        echo "<script>alert('Erro ao cadastrar equipamento: " . $con->error . "'); window.history.back();</script>";
        exit;
    }
}

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit;
}

$perfil_verifica = '1';
include('../verifica.php');
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link rel="stylesheet" href="header_admin.css">
  <title>CEC - Cadastro Equipamento</title>

  <style>
    body::-webkit-scrollbar {
      display: none;
      margin: 0;
      background: #f8f9fa;
      font-family: 'Poppins', sans-serif;

    }

    .page-title {
      text-align: center;
      font-size: 1.8rem;
      font-weight: bold;
      margin-bottom: 2rem;
      background-color: #d0d0d0;
    }

    .form-container {
      max-width: 600px;
      margin: auto;
    }

    .form-card {
      padding: 2rem;
      border-radius: 12px;
      background-color: #ffffff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background-color: #1e3a8a;
      box-shadow: 1px 1px 5px rgba(0, 0, 0, 0.51);
      border: none;
      width: 200px;
    }

    .btn-primary:hover {
      background-color: #0e78a9;
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
            </a>
            <a href="">
              <div class="nav-icon"><i class="bi bi-tv-fill"></i></div>
            </a>
            <a href="cadastros_admin.php">
              <div class="nav-icon"><i class="bi bi-plus-square-fill"></i></div>
            </a>
            <a href="">
              <div class="nav-icon"><i class="bi bi-bell-fill"></i></div>
            </a>
            <a href="">
              <div class="nav-icon"><i class="bi bi-exclamation-triangle-fill"></i></div>
            </a>
            <a href="">
              <div class="nav-icon"><i class="bi bi-person-fill"></i></div>
            </a>
            <a href="">
              <div class="nav-icon"><i class="bi bi-gear-fill"></i></div>
            </a>
          </div>
        </div>
      </div>
    </div>
  </header>

  <h1 class="page-title p-4">CADASTRO DE EQUIPAMENTO</h1>

  <div class="form-container">
    <div class="form-card">
      <form action="cadastro_equip_admin.php" method="post">
        <input type="hidden" name="action" value="Cadastrar">

        <div class="mb-3">
          <label for="tipo" class="form-label">Tipo de aparelho</label>
          <select class="form-select" id="tipo" name="tipo" required>
            <option disabled selected value="">Selecione uma opção</option>
            <?php foreach ($tipos as $codigo => $nome): ?>
              <option value="<?= $codigo ?>"><?= $nome ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-3">
          <label for="numeracao" class="form-label">Numeração</label>
          <input type="text" class="form-control" id="numeracao" name="numeracao" placeholder="Número do aparelho" required />
        </div>

        <div class="mb-3">
          <label for="marca" class="form-label">Marca</label>
          <select class="form-select" id="marca" name="marca" required>
            <option disabled selected value="">Selecione uma opção</option>
            <?php foreach ($marcas as $codigo => $nome): ?>
              <option value="<?= $codigo ?>"><?= $nome ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="mb-4">
          <label for="descricao" class="form-label">Descrição</label>
          <input type="text" class="form-control" id="descricao" name="descricao" placeholder="Descrição" required />
        </div>

        <div class="d-grid justify-content-center">
          <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
      </form>
    </div>
  </div>

</body>

</html>