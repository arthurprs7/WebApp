<?php
session_start();
include "Front-End_Admin/conect.php";

// Pega o tipo passado na URL
$tipoUsuario = $_GET['tipo'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = trim($_POST['senha'] ?? '');

    if (empty($email) || empty($senha)) {
        echo "<script>
                alert('Preencha todos os campos!');
                window.location.href='login.php?tipo=" . urlencode($tipoUsuario) . "';
              </script>";
        exit;
    }

    // Consulta no banco (usando SHA1 como no seu cadastro)
    $sql = "SELECT * FROM usuario WHERE email='$email' AND senha=SHA1('$senha')";
    $result = $con->query($sql);

    if ($result && $result->num_rows === 1) {
        $usuario = $result->fetch_assoc();

        // Cria as sessões corretas
        $_SESSION['id_usuario']   = $usuario['id_usuario'];
        $_SESSION['nome_usuario'] = $usuario['nome'];
        $_SESSION['perfil']       = $usuario['tipo'];

        // Redireciona baseado no tipo
        switch ($usuario['tipo']) {
            case '1':
                $_SESSION['msg_alert'] = ['success', 'Login realizado com sucesso!'];
                header("Location: Front-End_Admin/home_admin.php");
                break;
            case '2':
                $_SESSION['msg_alert'] = ['success', 'Login realizado com sucesso!'];
                header("Location: Front-End_Professor/home_prof.php");
                break;
            case '3':
                $_SESSION['msg_alert'] = ['success', 'Login realizado com sucesso!'];
                header("Location: Front-End_Inspetor/home_insp.php");
                break;
            default:
                header("Location: index.php");
        }
        exit;
    } else {
        $_SESSION['msg_alert'] = ['danger', 'Email ou Senha Incorreto!'];
        header("Location: login.php?tipo=" . urlencode($tipoUsuario));
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>CEC - Login</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Federo&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap');

        * {
            margin: 0;
            padding: 0;
        }

        html,
        body {
            height: 100%;
        }

        body {
            background-image: linear-gradient(to right, #fd4463 10%, #0b76a8, #12bdeb);
            font-family: Poppins, Arial, Helvetica, sans-serif;
        }

        main {
            background-color: #e5e5e5;
            border-radius: 20px;
            padding: 10px;
        }

        h3 {
            text-align: center;
        }

        .form-control {
            border-radius: 6px;
            margin-bottom: 20px;
            width: 300px;
        }

        label {
            margin-left: 5%;
        }

        #login-acessar {
            color: black;
        }

        #esqueci-senha {
            display: block;
            color: rgb(147, 147, 147);
        }
    </style>
</head>

<body class="d-flex py-4 bg-body-tertiary justify-content-center align-items-center">
    <?php
    include 'alert/alert.php'
    ?>
    <main class="h-auto">
        <!-- Formulário -->
        <form action="login.php?tipo=<?= htmlspecialchars($tipoUsuario); ?>" method="post" class="py-4 px-3">
            <h3 class="fw-bold a-center mb-3 text-capitalize">
                <?= htmlspecialchars($tipoUsuario); ?>
            </h3>

            <!--Input do email-->
            <div class="form-floating d-flex justify-content-center">
                <input type="email" class="form-control" name="email" id="floatingEmail" placeholder="seu-email@gmail.com" required>
                <label for="floatingEmail">E-mail</label>
            </div>

            <!--Input da senha-->
            <div class="form-floating d-flex justify-content-center">
                <input type="password" class="form-control mb-1" name="senha" id="floatingSenha" placeholder="senha" required>
                <label for="floatingSenha">Senha</label>
            </div>

            <!--Esqueci a senha-->
            <a href="" class="mb-3 d-flex justify-content-end small" id="esqueci-senha">Esqueci a senha</a>

            <div class="div col-12 d-flex justify-content-end">
                <!--Botão de voltar-->
                <a href="index.php" class="btn text-black p-2 bg-white me-3" id="link_voltar">Voltar</a>

                <!--Botão de logar-->
                <button type="submit" class="btn p-2 bg-white" id="login-acessar">Acessar</button>
            </div>
        </form>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="script.js"></script>

</html>