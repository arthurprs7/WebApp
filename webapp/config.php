<?php
// Função global para mostrar mensagens
function showMessage($message, $type = 'danger') {
    if (isset($_SESSION['message'])) {
        unset($_SESSION['message']);
    }
    $_SESSION['message'] = [
        'text' => $message,
        'type' => $type
    ];
}

$host = 'localhost';
$db = 'agp_events';
$user = 'root';  // Altere para seu usuário MySQL
$pass = '';      // Altere para sua senha

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>