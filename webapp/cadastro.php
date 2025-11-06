<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        if ($stmt->execute([$username, $email, $password])) {
            showMessage("Usuário cadastrado com sucesso!", "success");
            header("Location: index.php");
            exit;
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) { // Código de erro para duplicação
            showMessage("Este usuário ou email já está cadastrado.", "warning");
        } else {
            showMessage("Erro no cadastro. Por favor, tente novamente.");
        }
        header("Location: cadastro.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Cadastro - AGP Events</title>
    <!-- Bootstrap 5 CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">AGP Events</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-arrow-left-circle me-1"></i>Voltar para Eventos
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container my-5">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
                        <?php 
                            echo $_SESSION['message']['text'];
                            unset($_SESSION['message']);
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Criar Conta</h2>
                            <p class="text-muted">Junte-se à AGP Events e não perca nenhum evento!</p>
                        </div>
                        <form action="cadastro.php" method="POST" class="needs-validation" novalidate>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Seu usuário" required>
                                <label for="username"><i class="bi bi-person"></i> Usuário</label>
                                <div class="invalid-feedback">Por favor, escolha um nome de usuário.</div>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control" id="email" name="email" placeholder="nome@exemplo.com" required>
                                <label for="email"><i class="bi bi-envelope"></i> Email</label>
                                <div class="invalid-feedback">Por favor, insira um email válido.</div>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Sua senha" required>
                                <label for="password"><i class="bi bi-lock"></i> Senha</label>
                                <div class="invalid-feedback">Por favor, escolha uma senha.</div>
                            </div>
                            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                                <i class="bi bi-person-plus me-1"></i>Criar Conta
                            </button>
                            <p class="text-center text-muted mb-0">
                                Já tem uma conta? 
                                <a href="index.php" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#loginModal">Entre aqui</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Login -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="loginModalLabel">Entrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="login.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="loginUsername" name="username" required>
                            <label for="loginUsername"><i class="bi bi-person"></i> Usuário</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="password" class="form-control" id="loginPassword" name="password" required>
                            <label for="loginPassword"><i class="bi bi-lock"></i> Senha</label>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2">Entrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Validação de formulário do Bootstrap
    (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
    </script>
</body>
</html>