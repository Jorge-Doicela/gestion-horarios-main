// Funcionalidades JavaScript para la vista de horarios
document.addEventListener('DOMContentLoaded', function() {

    // Auto-submit del formulario cuando cambia el tipo de vista
    const viewTypeSelect = document.getElementById('viewType');
    if (viewTypeSelect) {
        viewTypeSelect.addEventListener('change', function() {
            const form = document.getElementById('filterForm');
            if (form) {
                form.submit();
            }
        });
    }

    // Efectos hover en las tarjetas de horarios
    const horarioCards = document.querySelectorAll('.horario-card');
    horarioCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.1)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 4px 6px rgba(0, 0, 0, 0.1)';
        });
    });

    // Filtros dinámicos - actualizar otros filtros cuando se selecciona uno
    const filterInputs = document.querySelectorAll('select[name], input[name]');
    filterInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Agregar clase de carga temporal
            const form = document.getElementById('filterForm');
            if (form) {
                form.classList.add('loading');
                setTimeout(() => {
                    form.classList.remove('loading');
                }, 500);
            }
        });
    });

    // Tooltips para información adicional
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', function() {
            const tooltip = this.getAttribute('data-tooltip');
            if (tooltip) {
                showTooltip(this, tooltip);
            }
        });

        element.addEventListener('mouseleave', function() {
            hideTooltip();
        });
    });

    // Función para mostrar tooltip
    function showTooltip(element, text) {
        const tooltip = document.createElement('div');
        tooltip.className = 'absolute z-50 px-2 py-1 text-sm text-white bg-gray-900 rounded shadow-lg';
        tooltip.textContent = text;
        tooltip.style.top = (element.offsetTop - 30) + 'px';
        tooltip.style.left = element.offsetLeft + 'px';
        tooltip.id = 'tooltip';

        document.body.appendChild(tooltip);
    }

    // Función para ocultar tooltip
    function hideTooltip() {
        const tooltip = document.getElementById('tooltip');
        if (tooltip) {
            tooltip.remove();
        }
    }

    // Animaciones de entrada para elementos
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-fade-in-up');
            }
        });
    }, observerOptions);

    // Observar elementos para animación
    const animatedElements = document.querySelectorAll('.animate-on-scroll');
    animatedElements.forEach(element => {
        observer.observe(element);
    });

    // Confirmación mejorada para eliminación
    const deleteButtons = document.querySelectorAll('button[onclick*="confirm"]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            if (!confirm('¿Está seguro de que desea eliminar este horario? Esta acción no se puede deshacer.')) {
                e.preventDefault();
                return false;
            }
        });
    });

    // Búsqueda en tiempo real (opcional)
    const searchInput = document.querySelector('input[name="search"]');
    if (searchInput) {
        let searchTimeout;
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Aquí se podría implementar búsqueda AJAX si se desea
                console.log('Búsqueda:', this.value);
            }, 300);
        });
    }

    // Responsive behavior
    function handleResize() {
        const isMobile = window.innerWidth < 768;
        const isTablet = window.innerWidth >= 768 && window.innerWidth < 1024;

        // Ajustar comportamiento según el tamaño de pantalla
        if (isMobile) {
            document.body.classList.add('mobile-view');
            document.body.classList.remove('tablet-view', 'desktop-view');
        } else if (isTablet) {
            document.body.classList.add('tablet-view');
            document.body.classList.remove('mobile-view', 'desktop-view');
        } else {
            document.body.classList.add('desktop-view');
            document.body.classList.remove('mobile-view', 'tablet-view');
        }
    }

    // Ejecutar al cargar y en resize
    handleResize();
    window.addEventListener('resize', handleResize);

    // Funcionalidad para botones de exportación
    const exportButtons = document.querySelectorAll('a[href*="export"]');
    exportButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Mostrar indicador de carga
            const originalText = this.innerHTML;
            this.innerHTML = '<div class="flex items-center"><div class="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2"></div>Exportando...</div>';
            this.style.pointerEvents = 'none';

            // Restaurar después de un tiempo (en caso de que la descarga no funcione)
            setTimeout(() => {
                this.innerHTML = originalText;
                this.style.pointerEvents = 'auto';
            }, 5000);
        });
    });
});

// Funciones utilitarias
function showLoading(element) {
    element.classList.add('loading');
    element.innerHTML = '<div class="flex items-center justify-center"><div class="animate-spin rounded-full h-6 w-6 border-b-2 border-indigo-600"></div></div>';
}

function hideLoading(element, originalContent) {
    element.classList.remove('loading');
    element.innerHTML = originalContent;
}

// Exportar funciones para uso global
window.HorariosUtils = {
    showLoading,
    hideLoading,
    showTooltip,
    hideTooltip
};
