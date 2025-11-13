<?php
session_start();
require 'config.php';

// Verificar se o ID do evento foi fornecido
if (empty($_GET['id'])) {
    showMessage('ID do evento não fornecido.', 'danger');
    header('Location: ../index.php');
    exit;
}

$event_id = (int)$_GET['id'];

// Buscar o evento
try {
    $stmt = $pdo->prepare("SELECT * FROM events WHERE id = ?");
    $stmt->execute([$event_id]);
    $event = $stmt->fetch();

    if (!$event) {
        showMessage('Evento não encontrado.', 'danger');
        header('Location: ../index.php');
        exit;
    }
} catch (PDOException $e) {
    showMessage('Erro ao buscar evento: ' . $e->getMessage(), 'danger');
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo htmlspecialchars($event['title']); ?> - AGP Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="../frontend/assets/css/style.css">
    <style>
        #eventMap { height: 400px; width: 100%; border-radius: 6px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">AGP Events</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">
                        <i class="bi bi-arrow-left me-1"></i>Voltar
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <!-- Imagem do Evento -->
                <?php if ($event['image']): ?>
                    <img src="<?php echo htmlspecialchars($event['image']); ?>" class="img-fluid rounded mb-4" alt="<?php echo htmlspecialchars($event['title']); ?>" style="height: 400px; object-fit: cover; width: 100%;">
                <?php else: ?>
                    <div class="bg-secondary rounded mb-4 d-flex align-items-center justify-content-center" style="height: 400px;">
                        <i class="bi bi-calendar-event text-white" style="font-size: 4rem;"></i>
                    </div>
                <?php endif; ?>

                <!-- Detalhes do Evento -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h1 class="card-title mb-3"><?php echo htmlspecialchars($event['title']); ?></h1>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <h6 class="text-muted">Data e Hora</h6>
                                <p class="lead">
                                    <i class="bi bi-calendar-event text-primary me-2"></i>
                                    <?php echo date('d/m/Y', strtotime($event['date'])); ?> às 
                                    <?php echo date('H:i', strtotime($event['date'])); ?>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-muted">Tipo de Evento</h6>
                                <p class="lead">
                                    <i class="bi bi-theater text-success me-2"></i>
                                    <?php echo ucfirst($event['type']); ?>
                                </p>
                            </div>
                        </div>

                        <?php if ($event['capacity']): ?>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Capacidade</h6>
                                    <p class="lead">
                                        <i class="bi bi-people text-info me-2"></i>
                                        <?php echo $event['capacity']; ?> pessoas
                                    </p>
                                </div>
                            </div>
                        <?php endif; ?>

                        <hr>

                        <h5 class="mb-3">Descrição</h5>
                        <p class="lead"><?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                    </div>
                </div>

                <!-- Mapa com Localização -->
                <?php if ($event['local_lat'] && $event['local_lng']): ?>
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <i class="bi bi-geo-alt me-2"></i>
                            <strong>Localização do Evento</strong>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                <i class="bi bi-pin-map text-danger me-2"></i>
                                <strong><?php echo htmlspecialchars($event['local_address'] ?: 'Coordenadas: ' . $event['local_lat'] . ', ' . $event['local_lng']); ?></strong>
                            </p>
                            <div id="eventMap"></div>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- Botões de Ação -->
                <div class="d-flex gap-2 mb-4">
                    <a href="../index.php" class="btn btn-secondary">
                        <i class="bi bi-arrow-left me-1"></i>Voltar
                    </a>
                    <button type="button" class="btn btn-danger ms-auto" data-bs-toggle="modal" data-bs-target="#deleteModal">
                        <i class="bi bi-trash me-1"></i>Deletar Evento
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmação de Exclusão -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title"><i class="bi bi-exclamation-triangle me-2"></i>Confirmar Exclusão</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Tem certeza que deseja deletar este evento?</strong></p>
                    <p class="text-danger"><strong><?php echo htmlspecialchars($event['title']); ?></strong></p>
                    <p class="text-muted">Esta ação não pode ser desfeita!</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <form action="delete_event.php" method="POST" style="display: inline;">
                        <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-1"></i>Deletar Evento
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Google Maps Script (para visualizar localização) -->
    <?php if ($event['local_lat'] && $event['local_lng']): ?>
    <script>
        function initEventMap() {
            const loc = { lat: <?php echo $event['local_lat']; ?>, lng: <?php echo $event['local_lng']; ?> };
            const map = new google.maps.Map(document.getElementById('eventMap'), {
                center: loc,
                zoom: 15
            });
            new google.maps.Marker({
                position: loc,
                map: map,
                title: "<?php echo htmlspecialchars($event['local_address'] ?: $event['title']); ?>"
            });
        }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&callback=initEventMap"></script>
    <?php endif; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
