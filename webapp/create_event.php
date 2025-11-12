<?php
session_start();
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    showMessage('Você precisa estar logado para criar um evento.', 'warning');
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastrar Evento - AGP Events</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        #map { height: 350px; width: 100%; border-radius: 6px; border: 1px solid #ddd; }
    </style>
</head>
<body class="bg-light">
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h4 class="card-title mb-3">Cadastrar Evento</h4>
                        <form id="createEventForm" action="save_event.php" method="POST" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label class="form-label">Título</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Descrição</label>
                                <textarea name="description" class="form-control" rows="4" required></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Data</label>
                                    <input type="date" name="date" class="form-control" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Hora</label>
                                    <input type="time" name="time" class="form-control" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tipo</label>
                                <select name="type" class="form-select">
                                    <option value="show">Show</option>
                                    <option value="standup">Stand-up</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Capacidade</label>
                                <input type="number" name="capacity" class="form-control" min="1">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Imagem (opcional)</label>
                                <input type="file" name="image" accept="image/*" class="form-control">
                            </div>

                            <!-- Campo de localização com Autocomplete -->
                            <div class="mb-3">
                                <label class="form-label">Local do Evento</label>
                                <input id="autocomplete" name="local_input" class="form-control" placeholder="Digite o endereço ou nome do local" type="text" />
                                <small class="text-muted">Selecione um local da lista. Isso preencherá latitude/longitude automaticamente.</small>
                            </div>

                            <div id="map" class="mb-3"></div>

                            <!-- Campos escondidos para lat/lng/endereço formatado -->
                            <input type="hidden" id="local_address" name="local_address">
                            <input type="hidden" id="local_lat" name="local_lat">
                            <input type="hidden" id="local_lng" name="local_lng">

                            <button type="submit" class="btn btn-success">Salvar Evento</button>
                            <a href="index.php" class="btn btn-secondary ms-2">Cancelar</a>
                        </form>
                        <hr>
                        <p class="small text-muted">Dica: insira sua chave da API Google Maps na variável <code>$google_maps_api_key</code> no topo deste arquivo ou configure em `config.php`.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let map, marker, autocomplete;
        function initMap() {
            const defaultPos = { lat: -23.55052, lng: -46.633308 }; // São Paulo como fallback
            map = new google.maps.Map(document.getElementById('map'), {
                center: defaultPos,
                zoom: 12
            });

            marker = new google.maps.Marker({ map: map });

            // Autocomplete
            const input = document.getElementById('autocomplete');
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(['geometry', 'formatted_address', 'name']);
            autocomplete.addListener('place_changed', onPlaceChanged);
        }

        function onPlaceChanged() {
            const place = autocomplete.getPlace();
            if (!place.geometry) {
                alert('Nenhuma informação de localização disponível para o local selecionado.');
                return;
            }
            const loc = place.geometry.location;
            map.setCenter(loc);
            map.setZoom(15);
            marker.setPosition(loc);

            document.getElementById('local_lat').value = loc.lat();
            document.getElementById('local_lng').value = loc.lng();
            document.getElementById('local_address').value = place.formatted_address || place.name || document.getElementById('autocomplete').value;
        }

        // Garantir que o usuário selecionou um local do Autocomplete antes de enviar
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('createEventForm');
            form.addEventListener('submit', function (e) {
                const lat = document.getElementById('local_lat').value;
                const lng = document.getElementById('local_lng').value;
                if (!lat || !lng) {
                    e.preventDefault();
                    alert('Por favor, selecione um local válido na lista de sugestões para preencher latitude/longitude.');
                    document.getElementById('autocomplete').focus();
                    return false;
                }
            });
        });
    </script>

    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&libraries=places&callback=initMap"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
