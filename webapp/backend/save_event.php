<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    showMessage('Você precisa estar logado para criar um evento.', 'warning');
    header('Location: ../index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: create_event.php');
    exit;
}

// Dados do formulário
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$type = $_POST['type'] ?? 'show';
$capacity = is_numeric($_POST['capacity'] ?? null) ? (int)$_POST['capacity'] : null;
$local_address = trim($_POST['local_address'] ?? '');
$local_lat = is_numeric($_POST['local_lat'] ?? null) ? (float)$_POST['local_lat'] : null;
$local_lng = is_numeric($_POST['local_lng'] ?? null) ? (float)$_POST['local_lng'] : null;

// Validações simples
if ($title === '' || $date === '' || $time === '') {
    showMessage('Título, data e hora são obrigatórios.', 'danger');
    header('Location: create_event.php');
    exit;
}

$datetime = $date . ' ' . $time;

// Tratamento da imagem (opcional)
$imagePath = null;
if (!empty($_FILES['image']['name']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
    // Diretório público de uploads (visível a partir do index.php)
    $publicDir = __DIR__ . '/../frontend/assets/img/uploads';
    if (!is_dir($publicDir)) {
        mkdir($publicDir, 0755, true);
    }

    // Validação simples de tipo (permitir apenas imagens básicas)
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $fileType = mime_content_type($_FILES['image']['tmp_name']);
    if (!in_array($fileType, $allowedTypes)) {
        showMessage('Tipo de arquivo não permitido. Envie JPG, PNG, GIF ou WEBP.', 'danger');
        header('Location: create_event.php');
        exit;
    }

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('evt_', true) . '.' . $ext;
    $target = $publicDir . '/' . $filename;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Salva caminho relativo a partir da raiz do projeto para exibição no front-end
        $imagePath = 'frontend/assets/img/uploads/' . $filename;
    } else {
        showMessage('Falha ao mover o arquivo enviado.', 'danger');
        header('Location: create_event.php');
        exit;
    }
}

// Inserir no banco (coordenadas são obrigatórias)
try {
    $stmt = $pdo->prepare("INSERT INTO events (title, description, date, type, image, capacity, local_address, local_lat, local_lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $datetime, $type, $imagePath, $capacity, $local_address, $local_lat, $local_lng]);
    showMessage('Evento cadastrado com sucesso!', 'success');
    header('Location: ../index.php');
    exit;
} catch (PDOException $e) {
    showMessage('Erro ao salvar evento: ' . $e->getMessage(), 'danger');
    header('Location: create_event.php');
    exit;
}

?>
