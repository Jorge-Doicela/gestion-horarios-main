# Funcionalidades de Exportación de Horarios

## Descripción

Se han implementado nuevas funcionalidades de exportación que permiten exportar horarios tanto completos como filtrados a formatos Excel y PDF.

## Características Implementadas

### 1. Exportación Completa

-   **Exportar Todo a Excel**: Exporta todos los horarios del sistema a formato Excel
-   **Exportar Todo a PDF**: Exporta todos los horarios del sistema a formato PDF

### 2. Exportación Filtrada

-   **Exportar Filtrado a Excel**: Exporta solo los horarios que coinciden con los filtros aplicados
-   **Exportar Filtrado a PDF**: Exporta solo los horarios que coinciden con los filtros aplicados

### 3. Filtros Soportados

Los botones de exportación filtrada respetan todos los filtros aplicados:

-   Búsqueda por texto (materia, docente, paralelo, espacio)
-   Filtro por paralelo
-   Filtro por docente
-   Filtro por estado
-   Filtro por modalidad
-   Filtro por período académico

## Archivos Creados/Modificados

### Controlador

-   `app/Http/Controllers/HorarioController.php` - Agregados métodos `exportExcelFiltrado()` y `exportPDFFiltrado()`

### Clase de Exportación

-   `app/Exports/HorariosFiltradosExport.php` - Nueva clase para exportar horarios filtrados a Excel

### Vista PDF

-   `resources/views/horarios/pdf_filtrado.blade.php` - Vista para generar PDF de horarios filtrados

### Rutas

-   `routes/web.php` - Agregadas rutas para exportación filtrada

### Vista Principal

-   `resources/views/horarios/index.blade.php` - Agregados botones de exportación

### JavaScript

-   `public/js/horarios.js` - Agregada funcionalidad para indicadores de carga

## Uso

### Exportación Completa

1. En la sección "Exportar Todo", hacer clic en:
    - **Excel**: Para descargar todos los horarios en formato Excel
    - **PDF**: Para descargar todos los horarios en formato PDF

### Exportación Filtrada

1. Aplicar los filtros deseados en la sección de filtros
2. En la sección "Exportar Filtrado", hacer clic en:
    - **Excel**: Para descargar solo los horarios filtrados en formato Excel
    - **PDF**: Para descargar solo los horarios filtrados en formato PDF

### Indicadores Visuales

-   Los botones muestran un indicador de carga durante la exportación
-   Los archivos se descargan automáticamente con nombres descriptivos
-   Los nombres de archivo incluyen timestamp para evitar conflictos

## Formato de Archivos

### Excel

-   **Columnas incluidas**: Paralelo, Materia, Docente, Espacio, Día, Hora, Período, Modalidad, Estado, Fecha Inicio, Fecha Fin
-   **Colores por modalidad**: Verde (presencial), Azul (virtual), Amarillo (híbrida)
-   **Colores por estado**: Gris (finalizado), Naranja (suspendido)
-   **Autoajuste de columnas**: Las columnas se ajustan automáticamente al contenido
-   **Logo institucional**: Incluye el logo del instituto en la esquina superior izquierda

### PDF

-   **Encabezado**: Logo institucional, título, fecha de generación
-   **Estadísticas**: Resumen de totales y distribución por estado y modalidad
-   **Tabla completa**: Todos los datos de los horarios
-   **Colores**: Diferenciación visual por modalidad y estado
-   **Pie de página**: Información institucional

## Rutas Disponibles

### Exportación Completa

-   `GET /horarios/export/excel` - Exportar todo a Excel
-   `GET /horarios/export/pdf` - Exportar todo a PDF

### Exportación Filtrada

-   `GET /horarios/export/excel-filtrado` - Exportar filtrado a Excel
-   `GET /horarios/export/pdf-filtrado` - Exportar filtrado a PDF

## Beneficios

1. **Flexibilidad**: Exportar todos los horarios o solo los filtrados
2. **Eficiencia**: Descarga rápida de archivos con formato profesional
3. **Análisis**: Los archivos Excel permiten análisis adicionales
4. **Documentación**: Los PDF son ideales para reportes y documentación
5. **Filtros Inteligentes**: Respeta todos los filtros aplicados en la interfaz
6. **Nombres Descriptivos**: Los archivos incluyen timestamp y descripción del contenido

## Compatibilidad

-   **Excel**: Compatible con Microsoft Excel, LibreOffice Calc, Google Sheets
-   **PDF**: Compatible con todos los lectores de PDF
-   **Navegadores**: Funciona en todos los navegadores modernos
-   **Dispositivos**: Responsive y funcional en móviles, tablets y desktop

## Mantenimiento

### Agregar Nuevos Campos

1. Modificar `HorariosFiltradosExport.php` para incluir nuevas columnas
2. Actualizar `pdf_filtrado.blade.php` para mostrar nuevos campos
3. Actualizar los métodos del controlador si es necesario

### Personalizar Estilos

1. Modificar los colores y estilos en `HorariosFiltradosExport.php`
2. Actualizar los estilos CSS en `pdf_filtrado.blade.php`
3. Ajustar el logo y branding según sea necesario

### Agregar Nuevos Formatos

1. Crear nueva clase de exportación siguiendo el patrón existente
2. Agregar método en el controlador
3. Crear vista correspondiente
4. Agregar rutas y botones en la interfaz
