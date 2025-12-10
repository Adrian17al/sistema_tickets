document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Menú Móvil
    const btnMobile = document.getElementById('mobile-menu-btn');
    const menuMobile = document.getElementById('mobile-menu');
    
    if (btnMobile && menuMobile) {
        btnMobile.addEventListener('click', () => {
            menuMobile.classList.toggle('hidden');
        });
    }

    // 2. Auto-ocultar alertas después de 3 segundos
    const alerts = document.querySelectorAll('.alert-dismissible');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500); 
            });
        }, 4000);
    }

    // 3. Buscador en tiempo real (Compatible con Móvil y Desktop)
    const searchInput = document.getElementById('table-search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            
            // Filtrar filas de tabla (Desktop)
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });

            // Filtrar tarjetas (Móvil)
            const cards = document.querySelectorAll('.mobile-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
        });
    }
});
