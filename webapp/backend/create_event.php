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
    <link rel="stylesheet" href="../frontend/assets/css/style.css">
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

                            <!-- Campo de localização com suporte a coordenadas e endereço -->
                            <div class="mb-3">
                                <label class="form-label">Local do Evento</label>
                                <div class="input-group">
                                    <input id="locationInput" name="local_input" class="form-control" 
                                           placeholder="Ex: -23.252399,-45.885872 (lat,lng) ou Copacabana" 
                                           type="text" />
                                    <button id="searchBtn" type="button" class="btn btn-info">
                                        🔍 Buscar
                                    </button>
                                </div>
                                <small class="text-muted d-block mt-2">
                                    <strong>Formato:</strong> Digite <code>latitude,longitude</code> (ex: -23.55,-46.63) ou nome do local.<br>
                                    <strong>Dica:</strong> Se o Geocoding não funcionar, use coordenadas diretas.
                                </small>
                            </div>

                            <!-- Campos de entrada manual de lat/lng (fallback) -->
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Latitude (manual)</label>
                                    <input id="manualLat" type="number" class="form-control" 
                                           placeholder="-23.55" step="0.000001" 
                                           min="-90" max="90">
                                    <small class="text-muted">Range: -90 a 90</small>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Longitude (manual)</label>
                                    <input id="manualLng" type="number" class="form-control" 
                                           placeholder="-46.63" step="0.000001"
                                           min="-180" max="180">
                                    <small class="text-muted">Range: -180 a 180</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <button id="applyManualBtn" type="button" class="btn btn-success btn-sm">
                                    ✅ Aplicar Coordenadas
                                </button>
                                <button id="clearBtn" type="button" class="btn btn-secondary btn-sm">
                                    🗑️ Limpar Tudo
                                </button>
                            </div>

                            <div id="map" class="mb-3"></div>

                            <!-- Campos escondidos para lat/lng/endereço formatado -->
                            <input type="hidden" id="local_address" name="local_address">
                            <input type="hidden" id="local_lat" name="local_lat">
                            <input type="hidden" id="local_lng" name="local_lng">

                            <!-- Campo de status/resultado da busca -->
                            <div id="searchStatus" class="alert d-none" role="alert"></div>

                            <button type="submit" class="btn btn-success">Salvar Evento</button>
                            <a href="../index.php" class="btn btn-secondary ms-2">Cancelar</a>
                        </form>
                        <hr>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    let map, marker, autocomplete;
    
    function showStatus(message, type = 'info') {
        const statusDiv = document.getElementById('searchStatus');
        statusDiv.textContent = message;
        statusDiv.className = 'alert alert-' + type;
        statusDiv.classList.remove('d-none');
    }

    function clearStatus() {
        const statusDiv = document.getElementById('searchStatus');
        statusDiv.classList.add('d-none');
    }

    // Função para exibir erros do Google Maps no console
    window.gm_authFailure = function() {
        console.error('❌ Erro de autenticação do Google Maps.');
        showStatus('⚠️ Google Maps com erro. Use o método manual (lat/lng) para continuar.', 'warning');
    };

    function initMap() {
        console.log('🗺️ Inicializando mapa...');
        const defaultPos = { lat: -23.55052, lng: -46.633308 }; // São Paulo como fallback
        map = new google.maps.Map(document.getElementById('map'), {
            center: defaultPos,
            zoom: 12
        });

        marker = new google.maps.Marker({ map: map });

        // Tentar inicializar Autocomplete (pode falhar se API bloqueada)
        try {
            const input = document.getElementById('locationInput');
            autocomplete = new google.maps.places.Autocomplete(input);
            autocomplete.setFields(['geometry', 'formatted_address', 'name']);
            autocomplete.addListener('place_changed', onPlaceChanged);
            console.log('✅ Autocomplete inicializado');
        } catch (e) {
            console.warn('⚠️ Autocomplete indisponível. Use método manual ou coordenadas.');
        }

        console.log('✅ Mapa inicializado com sucesso');
    }

    function onPlaceChanged() {
        const place = autocomplete.getPlace();
        if (!place.geometry) {
            showStatus('Nenhuma informação de localização disponível.', 'warning');
            return;
        }
        const loc = place.geometry.location;
        map.setCenter(loc);
        map.setZoom(15);
        marker.setPosition(loc);

        document.getElementById('local_lat').value = loc.lat();
        document.getElementById('local_lng').value = loc.lng();
        document.getElementById('local_address').value = place.formatted_address || place.name || document.getElementById('locationInput').value;
        document.getElementById('manualLat').value = loc.lat();
        document.getElementById('manualLng').value = loc.lng();
        
        showStatus('✅ Local selecionado: ' + (place.formatted_address || place.name), 'success');
        console.log('📍 Local:', place.formatted_address, '| Lat:', loc.lat(), 'Lng:', loc.lng());
    }

    // Processar coordenadas digitadas no campo de busca
    document.getElementById('searchBtn').addEventListener('click', function() {
        const input = document.getElementById('locationInput').value.trim();
        if (!input) {
            showStatus('Digite coordenadas (lat,lng).', 'warning');
            return;
        }

        // Verificar se é formato de coordenadas (lat,lng)
        const coordRegex = /^(-?\d+\.?\d*)\s*,\s*(-?\d+\.?\d*)$/;
        const match = input.match(coordRegex);

        if (match) {
            // É coordenada
            const lat = parseFloat(match[1]);
            const lng = parseFloat(match[2]);
            
            // Validar range
            if (lat < -90 || lat > 90 || lng < -180 || lng > 180) {
                showStatus('❌ Coordenadas inválidas. Latitude: [-90, 90], Longitude: [-180, 180]', 'danger');
                return;
            }

            document.getElementById('manualLat').value = lat;
            document.getElementById('manualLng').value = lng;
            setLocation(lat, lng, `Coordenadas: ${lat}, ${lng}`);
            showStatus('✅ Coordenadas aplicadas!', 'success');
        } else {
            showStatus('⚠️ Formato inválido. Use lat,lng (ex: -23.55,-46.63)', 'warning');
        }
    });

    // Aplicar coordenadas manuais
    document.getElementById('applyManualBtn').addEventListener('click', function() {
        const lat = parseFloat(document.getElementById('manualLat').value);
        const lng = parseFloat(document.getElementById('manualLng').value);

        if (isNaN(lat) || isNaN(lng)) {
            showStatus('❌ Digite valores válidos para latitude e longitude.', 'danger');
            return;
        }

        if (lat < -90 || lat > 90 || lng < -180 || lng > 180) {
            showStatus('❌ Coordenadas fora do range. Lat: [-90,90], Lng: [-180,180]', 'danger');
            return;
        }

        setLocation(lat, lng, `Coordenadas: ${lat}, ${lng}`);
        showStatus('✅ Coordenadas aplicadas manualmente!', 'success');
    });

    // Limpar formulário
    document.getElementById('clearBtn').addEventListener('click', function() {
        document.getElementById('locationInput').value = '';
        document.getElementById('manualLat').value = '';
        document.getElementById('manualLng').value = '';
        document.getElementById('local_lat').value = '';
        document.getElementById('local_lng').value = '';
        document.getElementById('local_address').value = '';
        clearStatus();
        const defaultPos = { lat: -23.55052, lng: -46.633308 };
        map.setCenter(defaultPos);
        map.setZoom(12);
        marker.setPosition(defaultPos);
        console.log('🗑️ Formulário limpo');
    });

    // Atualizar mapa e campos com a localização
    function setLocation(lat, lng, address) {
        const loc = { lat, lng };
        
        try {
            if (map && marker) {
                map.setCenter(loc);
                map.setZoom(15);
                marker.setPosition(loc);
            }
        } catch (e) {
            console.warn('⚠️ Erro ao atualizar mapa:', e);
        }

        document.getElementById('local_lat').value = lat;
        document.getElementById('local_lng').value = lng;
        document.getElementById('local_address').value = address;

        console.log('📍 Local atualizado:', address, '| Lat:', lat, 'Lng:', lng);
    }

    // Validar antes de enviar
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('createEventForm');
        form.addEventListener('submit', function (e) {
            const lat = document.getElementById('local_lat').value;
            const lng = document.getElementById('local_lng').value;
            if (!lat || !lng) {
                e.preventDefault();
                showStatus('❌ Por favor, defina uma localização (use o formulário ou digite lat/lng manualmente).', 'danger');
                document.getElementById('locationInput').focus();
                return false;
            }
        });
    });
    </script>

    <!-- Script da API Google Maps (obrigatória) -->
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $google_maps_api_key; ?>&libraries=places&callback=initMap&onerror=gm_authFailure"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
