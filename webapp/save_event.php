<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    showMessage('Você precisa estar logado para criar um evento.', 'warning');
    header('Location: index.php');
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
if (!empty($_FILES['image']['name'])) {
    $uploadDir = __DIR__ . '/img/uploads';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('evt_', true) . '.' . $ext;
    $target = $uploadDir . '/' . $filename;
    if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
        // Salva caminho relativo para exibição
        $imagePath = 'img/uploads/' . $filename;
    }
}

// Inserir no banco (colunas de local e capacidade devem existir — veja bd/bd_events_create.sql para o schema)
try {
    $stmt = $pdo->prepare("INSERT INTO events (title, description, date, type, image, capacity, local_address, local_lat, local_lng) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$title, $description, $datetime, $type, $imagePath, $capacity, $local_address, $local_lat, $local_lng]);
    showMessage('Evento cadastrado com sucesso!', 'success');
    header('Location: index.php');
    exit;
} catch (PDOException $e) {
    // Se a tabela não tiver as colunas de local, informar ao usuário
    showMessage('Erro ao salvar evento: ' . $e->getMessage(), 'danger');
    header('Location: create_event.php');
    exit;
}

?>
