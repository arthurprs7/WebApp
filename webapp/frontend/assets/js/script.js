// ================================================
// AGP Events - JavaScript Utilities
// ================================================

// Função global para mostrar alertas
function showAlert(message, type = 'danger') {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    // Inserir no topo da página
    const container = document.querySelector('.container') || document.body;
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto-remover após 5 segundos
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}

// Validação de coordenadas
function isValidCoordinate(lat, lng) {
    const latNum = parseFloat(lat);
    const lngNum = parseFloat(lng);
    return !isNaN(latNum) && !isNaN(lngNum) && latNum >= -90 && latNum <= 90 && lngNum >= -180 && lngNum <= 180;
}

// Formatação de data/hora
function formatDateTime(dateString) {
    const date = new Date(dateString);
    return date.toLocaleDateString('pt-BR') + ' ' + date.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
}

// Função para debug no console
function debug(message, data = null) {
    if (window.DEBUG_MODE) {
        console.log(`[AGP Events] ${message}`, data || '');
    }
}

// Event listeners para forms
document.addEventListener('DOMContentLoaded', function() {
    // Validação de forms Bootstrap
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Se o formulário for inválido, prevenir envio e mostrar validação do Bootstrap
            if (!this.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            this.classList.add('was-validated');
        });
    });
});
