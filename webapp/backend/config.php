<?php


// 🔔 Função global para mostrar mensagens na sessão
function showMessage($message, $type = 'danger') {
    $_SESSION['message'] = [
        'text' => $message,
        'type' => $type
    ];
}

// 🔧 Configuração do banco
$host = 'localhost';
$db   = 'bd_events'; // usando banco único centralizado
$user = 'root';   // Altere se seu MySQL tiver outro usuário
$pass = '';       // Altere se tiver senha

// Chave do Google Maps / Places (Maps JavaScript API - obrigatória)
$google_maps_api_key = 'AIzaSyD1ymgJSOFD9yCS4hoC7hNeU8Km40bbQi0';

try {
    // Conexão PDO com charset UTF-8
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro na conexão: " . $e->getMessage());
}
?>
