<?php
session_start(); 
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Processamento do formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $pdo->prepare("UPDATE users SET password = ?, is_first_login = FALSE WHERE id = ?")->execute([$new_password, $_SESSION['user_id']]);
    showMessage("Senha alterada com sucesso!", "success");
    header("Location: index.php");
    exit;
}

// Função auxiliar para mostrar alertas bootstrap
function showAlert($message, $type = 'danger') {
    echo "<div class='alert alert-$type alert-dismissible fade show' role='alert'>
            $message
            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
          </div>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Alterar Senha - AGP Events</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h1 class="h3 mb-0">Primeiro Acesso: Troque sua Senha</h1>
                    </div>
                    <div class="card-body">
                        <form action="alterar_senha.php" method="POST">
                            <div class="mb-3">
                                <label for="new_password" class="form-label">Nova Senha</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <button type="submit" class="btn btn-warning w-100">Alterar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
