<?php
include "conect.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == "Cadastrar") {
  $nome  = trim($_POST['nome']);
  $email = trim($_POST['email']);
  $senha = trim($_POST['senha']);
  $tipo  = trim($_POST['tipo']);

  if (empty($nome) || empty($email) || empty($senha) || empty($tipo)) {
    echo "<script>alert('Preencha todos os campos!');</script>";
    exit;
  }

  $sql = "INSERT INTO usuario (nome, email, senha, tipo)
            VALUES ('$nome', '$email', SHA1('$senha'), '$tipo')";

  if ($con->query($sql)){
    session_start();
    $_SESSION['msg_alert'] = ['success', 'Cadastrado com sucesso!'];
    header("Location: cadastro_usuario_admin.php"); // ou home_admin.php, se quiser
    exit;
}

}
?>

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
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />

  <link rel="stylesheet" href="header_admin.css">
  <title>CEC - Cadastro Usuário</title>

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
      background-color: #fff;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background-color: #1e3a8a;
      border: none;
      width: 200px;
    }

    .btn-primary:hover {
      background-color: #0e78a9;
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

  <h1 class="page-title p-4">CADASTRO DE USUÁRIO</h1>

  <div class="form-container">
    <div class="form-card">
      <form action="cadastro_usuario_admin.php" method="post">
        <div class="mb-3">
          <label for="nome" class="form-label">Nome</label>
          <input type="text" class="form-control" id="nome" name="nome" placeholder="Nome do usuário" required />
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Email" required />
        </div>

        <div class="mb-3">
          <label for="senha" class="form-label">Senha</label>
          <input type="password" class="form-control" id="senha" name="senha" placeholder="Senha" required />
        </div>

        <div class="mb-4">
          <label for="tipo" class="form-label">Tipo de usuário</label>
          <select class="form-select" id="tipo" name="tipo" required>
            <option disabled selected value="">Selecione uma opção</option>
            <option value="1">Administrador</option>
            <option value="2">Professor</option>
            <option value="3">Inspetor</option>
          </select>
        </div>

        <div class="d-grid justify-content-center">
          <button type="submit" name="action" value="Cadastrar" class="btn btn-primary">Cadastrar</button>
        </div>
      </form>
    </div>
  </div>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="../script.js"></script>
</html>