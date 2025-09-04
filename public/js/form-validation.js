// Form Validation JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Validación en tiempo real para formularios
    const forms = document.querySelectorAll('form[data-validate="true"]');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, select, textarea');
        
        inputs.forEach(input => {
            // Validación en tiempo real
            input.addEventListener('blur', function() {
                validateField(this);
            });
            
            input.addEventListener('input', function() {
                clearFieldError(this);
            });
        });
        
        // Validación al enviar el formulario
        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                showNotification('Por favor, corrija los errores antes de continuar', 'error');
            }
        });
    });
    
    // Función para validar un campo individual
    function validateField(field) {
        const value = field.value.trim();
        const fieldName = field.getAttribute('name');
        const isRequired = field.hasAttribute('required');
        const minLength = field.getAttribute('minlength');
        const maxLength = field.getAttribute('maxlength');
        const pattern = field.getAttribute('pattern');
        
        clearFieldError(field);
        
        // Validación de campo requerido
        if (isRequired && !value) {
            showFieldError(field, 'Este campo es obligatorio');
            return false;
        }
        
        // Validación de longitud mínima
        if (minLength && value.length < parseInt(minLength)) {
            showFieldError(field, `Debe tener al menos ${minLength} caracteres`);
            return false;
        }
        
        // Validación de longitud máxima
        if (maxLength && value.length > parseInt(maxLength)) {
            showFieldError(field, `No puede exceder ${maxLength} caracteres`);
            return false;
        }
        
        // Validación de patrón (email, teléfono, etc.)
        if (pattern && value && !new RegExp(pattern).test(value)) {
            showFieldError(field, 'El formato no es válido');
            return false;
        }
        
        // Validaciones específicas por tipo de campo
        if (field.type === 'email' && value && !isValidEmail(value)) {
            showFieldError(field, 'El formato del email no es válido');
            return false;
        }
        
        if (field.type === 'date' && value) {
            const selectedDate = new Date(value);
            const today = new Date();
            
            if (fieldName === 'fecha_inicio' && selectedDate < today) {
                showFieldError(field, 'La fecha de inicio no puede ser anterior a hoy');
                return false;
            }
            
            if (fieldName === 'fecha_fin') {
                const fechaInicio = document.querySelector('input[name="fecha_inicio"]');
                if (fechaInicio && fechaInicio.value) {
                    const inicioDate = new Date(fechaInicio.value);
                    if (selectedDate < inicioDate) {
                        showFieldError(field, 'La fecha de fin debe ser posterior a la fecha de inicio');
                        return false;
                    }
                }
            }
        }
        
        return true;
    }
    
    // Función para mostrar error en un campo
    function showFieldError(field, message) {
        const errorElement = document.createElement('div');
        errorElement.className = 'field-error text-red-600 text-sm mt-1';
        errorElement.textContent = message;
        
        field.classList.add('border-red-500', 'focus:ring-red-500');
        field.parentNode.appendChild(errorElement);
    }
    
    // Función para limpiar error de un campo
    function clearFieldError(field) {
        const errorElement = field.parentNode.querySelector('.field-error');
        if (errorElement) {
            errorElement.remove();
        }
        
        field.classList.remove('border-red-500', 'focus:ring-red-500');
        field.classList.add('border-gray-300', 'focus:ring-indigo-500');
    }
    
    // Función para validar email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Función para mostrar notificaciones
    function showNotification(message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300 translate-x-full`;
        
        const colors = {
            success: 'bg-green-500 text-white',
            error: 'bg-red-500 text-white',
            warning: 'bg-yellow-500 text-white',
            info: 'bg-blue-500 text-white'
        };
        
        notification.className += ` ${colors[type] || colors.info}`;
        notification.innerHTML = `
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <span>${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;
        
        document.body.appendChild(notification);
        
        // Animar entrada
        setTimeout(() => {
            notification.classList.remove('translate-x-full');
        }, 100);
        
        // Auto-remover después de 5 segundos
        setTimeout(() => {
            notification.classList.add('translate-x-full');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, 300);
        }, 5000);
    }
    
    // Búsqueda en tiempo real
    const searchInputs = document.querySelectorAll('input[name="search"]');
    searchInputs.forEach(input => {
        let searchTimeout;
        
        input.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                // Aquí se puede implementar búsqueda AJAX si se desea
                console.log('Búsqueda:', this.value);
            }, 300);
        });
    });
    
    // Confirmación de eliminación
    const deleteButtons = document.querySelectorAll('button[data-confirm-delete]');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-confirm-message') || '¿Está seguro de que desea eliminar este elemento?';
            
            if (confirm(message)) {
                this.closest('form').submit();
            }
        });
    });
});

// Función global para mostrar notificaciones desde el backend
window.showNotification = function(message, type = 'info') {
    // Esta función será llamada desde las vistas Blade
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm transform transition-all duration-300`;
    
    const colors = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        warning: 'bg-yellow-500 text-white',
        info: 'bg-blue-500 text-white'
    };
    
    notification.className += ` ${colors[type] || colors.info}`;
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span>${message}</span>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-4 text-white hover:text-gray-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(notification);
    
    // Animar entrada
    setTimeout(() => {
        notification.classList.add('translate-x-0');
    }, 100);
    
    // Auto-remover después de 5 segundos
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 300);
    }, 5000);
};
