<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        // Verificar bloqueio: 3 tentativas e menos de 15 min
        if ($user['failed_attempts'] >= 3 && strtotime($user['last_attempt']) > strtotime('-15 minutes')) {
            showMessage('Conta bloqueada. Tente novamente em 15 minutos.');
            header("Location: index.php");
            exit;
        }

        if (password_verify($password, $user['password'])) {
            // Login bem-sucedido: resetar tentativas, incrementar acessos
            $pdo->prepare("UPDATE users SET failed_attempts = 0, access_count = access_count + 1 WHERE id = ?")->execute([$user['id']]);
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            if ($user['is_first_login']) {
                header("Location: alterar_senha.php");
            } else {
                header("Location: index.php");
            }
            exit;
        } else {
            // Incrementar tentativas falhidas
            $pdo->prepare("UPDATE users SET failed_attempts = failed_attempts + 1, last_attempt = NOW() WHERE id = ?")->execute([$user['id']]);
            showMessage('Credenciais inválidas.');
            header("Location: index.php");
        }
    } else {
        showMessage('Usuário não encontrado.');
        header("Location: index.php");
    }
}
?>