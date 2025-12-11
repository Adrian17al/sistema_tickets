document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Menú Móvil
    const btnMobile = document.getElementById('mobile-menu-btn');
    const menuMobile = document.getElementById('mobile-menu');
    
    if (btnMobile && menuMobile) {
        btnMobile.addEventListener('click', () => {
            menuMobile.classList.toggle('hidden');
        });
    }

    // 2. Auto-ocultar alertas
    const alerts = document.querySelectorAll('.alert-dismissible');
    if (alerts.length > 0) {
        setTimeout(() => {
            alerts.forEach(el => {
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500); 
            });
        }, 4000);
    }

    // 3. Buscador
    const searchInput = document.getElementById('table-search');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const value = this.value.toLowerCase();
            const rows = document.querySelectorAll('tbody tr');
            rows.forEach(row => {
                const text = row.textContent.toLowerCase();
                row.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
            const cards = document.querySelectorAll('.mobile-card');
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                card.style.display = text.indexOf(value) > -1 ? '' : 'none';
            });
        });
    }

    // 4. SISTEMA DE CONFIRMACIÓN ROBUSTO
    document.addEventListener('click', function(e) {
        const target = e.target.closest('.confirm-action');
        
        if (target) {
            e.preventDefault(); 
            
            const title = target.dataset.title || '¿Estás seguro?';
            const text = target.dataset.text || 'Esta acción no se puede deshacer';
            const icon = target.dataset.icon || 'warning';
            const confirmBtnText = target.dataset.btnText || 'Sí, continuar';
            const confirmBtnColor = target.dataset.btnColor || '#3085d6';

            // Verificamos si SweetAlert cargó correctamente
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: title,
                    text: text,
                    icon: icon,
                    showCancelButton: true,
                    confirmButtonColor: confirmBtnColor,
                    cancelButtonColor: '#d33',
                    confirmButtonText: confirmBtnText,
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        executeAction(target);
                    }
                });
            } else {
                // Fallback (por si no hay internet o falla la librería)
                if (confirm(title + "\n" + text)) {
                    executeAction(target);
                }
            }
        }
    });

    // Confirmación Salir
    document.addEventListener('click', function(e) {
        const target = e.target.closest('.confirm-logout');
        if (target) {
            e.preventDefault();
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¿Cerrar Sesión?',
                    text: "Tendrás que ingresar tus credenciales nuevamente.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, salir'
                }).then((result) => {
                    if (result.isConfirmed) window.location.href = target.href;
                });
            } else {
                if(confirm("¿Cerrar Sesión?")) window.location.href = target.href;
            }
        }
    });

    function executeAction(target) {
        if (target.tagName === 'A') {
            window.location.href = target.href;
        } else if (target.tagName === 'BUTTON' && target.type === 'submit') {
            target.closest('form').submit();
        }
    }
});
