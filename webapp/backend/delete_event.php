<?php
session_start();
require 'config.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['user_id'])) {
    showMessage('Você precisa estar logado para deletar um evento.', 'warning');
    header('Location: ../index.php');
    exit;
}

// Verificar se o ID do evento foi enviado
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_POST['event_id'])) {
    showMessage('ID do evento não fornecido.', 'danger');
    header('Location: ../index.php');
    exit;
}

$event_id = (int)$_POST['event_id'];

// Buscar o evento para verificar se existe e obter o caminho da imagem
try {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if (!$event) {
        showMessage('Evento não encontrado.', 'danger');
        header('Location: ../index.php');
        exit;
    }

    // Se houver imagem, tentar deletar o arquivo
    if ($event['image'] && file_exists($event['image'])) {
        @unlink($event['image']);
    }

    // Deletar o evento do banco
    $stmt = $pdo->prepare("DELETE FROM events WHERE id = ?");
    if ($stmt->execute([$event_id])) {
        showMessage('Evento deletado com sucesso!', 'success');
    } else {
        showMessage('Erro ao deletar o evento.', 'danger');
    }
} catch (PDOException $e) {
    showMessage('Erro no banco de dados: ' . $e->getMessage(), 'danger');
}

header('Location: ../index.php');
exit;
?>
