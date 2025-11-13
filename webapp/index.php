<?php
session_start();
require 'backend/config.php';

// Buscar eventos
$stmt = $pdo->query("SELECT * FROM events ORDER BY date DESC");
$events = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AGP Events</title>
    <!-- Bootstrap 5 CSS e Ícones -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="frontend/assets/css/style.css">
</head>
<body>
    <!-- Navbar com Bootstrap -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">AGP Events</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class="bi bi-calendar-event me-1"></i>Eventos
                        </a>
                    </li>
                    <?php if (isset($_SESSION['user_id'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="backend/create_event.php">
                            <i class="bi bi-plus-circle me-1"></i>Criar Evento
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
                <ul class="navbar-nav align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item nav-user-section">
                            <span class="navbar-text">
                                <i class="bi bi-person-circle me-1"></i>
                                Olá, <?php echo htmlspecialchars($_SESSION['username']); ?>!
                            </span>
                            <a class="nav-link" href="backend/logout.php">
                                <i class="bi bi-box-arrow-right me-1"></i>Sair
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Entrar
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?php echo $_SESSION['message']['type']; ?> alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['message']['text'];
                    unset($_SESSION['message']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <h2 class="mb-4">Próximos Eventos</h2>
        <div class="row">
            <?php if (empty($events)): ?>
                <div class="col-12">
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>Nenhum evento cadastrado ainda.
                        <?php if (isset($_SESSION['user_id'])): ?>
                            <a href="create_event.php" class="alert-link">Crie um novo evento!</a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php else: ?>
                <?php foreach ($events as $event): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100 shadow-sm">
                            <?php if ($event['image']): ?>
                                <img src="<?php echo htmlspecialchars($event['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($event['title']); ?>" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="card-img-top bg-secondary" style="height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-calendar-event text-white" style="font-size: 3rem;"></i>
                                </div>
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($event['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars(substr($event['description'], 0, 100)); ?>...</p>
                                <p class="card-text"><small class="text-muted">
                                    📅 <?php echo date('d/m/Y H:i', strtotime($event['date'])); ?> | 
                                    🎭 <?php echo ucfirst($event['type']); ?>
                                </small></p>
                                <?php if ($event['capacity']): ?>
                                    <p class="card-text"><small class="text-muted">👥 Capacidade: <?php echo $event['capacity']; ?> pessoas</small></p>
                                <?php endif; ?>
                                <?php if ($event['local_address']): ?>
                                    <p class="card-text"><small class="text-muted">📍 <?php echo htmlspecialchars($event['local_address']); ?></small></p>
                                <?php endif; ?>
                            </div>
                            <div class="card-footer bg-transparent">
                                <div class="btn-group w-100" role="group">
                                <a href="backend/view_event.php?id=<?php echo $event['id']; ?>" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye me-1"></i>Ver
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal<?php echo $event['id']; ?>">
                                        <i class="bi bi-trash me-1"></i>Deletar
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Modal de Confirmação de Exclusão -->
                        <div class="modal fade" id="deleteModal<?php echo $event['id']; ?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger text-white">
                                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Confirmar Exclusão</h5>
                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Tem certeza que deseja deletar o evento:</strong></p>
                                        <p class="text-danger"><strong><?php echo htmlspecialchars($event['title']); ?></strong></p>
                                        <p class="text-muted">Esta ação não pode ser desfeita!</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <form action="backend/delete-event.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                                            <button type="submit" class="btn btn-danger">
                                                <i class="bi bi-trash me-1"></i>Deletar Evento
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal de Login com Bootstrap -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Entrar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="backend/login.php" method="POST">
                        <div class="mb-3">
                            <label for="username" class="form-label">Usuário</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Entrar</button>
                    </form>
                    <div class="mt-3 text-center">
                        <a href="backend/cadastro.php">Não tem conta? Cadastre-se</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="frontend/assets/js/script.js"></script>
</body>
</html>