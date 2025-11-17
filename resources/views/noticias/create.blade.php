<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editor de Noticias</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        #editorArea:empty:before {
            content: attr(placeholder);
            color: #9ca3af;
        }
        
        #editorArea:focus {
            outline: none;
        }
        
        #editorArea p, #editorArea div, #editorArea li {
            margin-bottom: 0.5rem;
        }
        
        #editorArea ul, #editorArea ol {
            padding-left: 1.5rem;
            margin: 0.5rem 0;
        }
        
        #editorArea ul {
            list-style-type: disc;
        }
        
        #editorArea ol {
            list-style-type: decimal;
        }
        
        .toolbar-btn.active {
            background-color: #dbeafe;
            border-color: #3b82f6;
        }
        
        /* Estilos para el select personalizado */
        .custom-select {
            position: relative;
            width: 100%;
        }
        
        .custom-select select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 2.5rem;
        }
        
        .custom-select::after {
            content: "▼";
            font-size: 0.8rem;
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            pointer-events: none;
            color: #6b7280;
        }
    </style>
</head>
    <br>
   <a href="{{ route('dashboard') }}" class="bg-white text-blue-800 px-6 py-2 rounded-lg font-semibold hover:bg-blue-100 transition inline-flex items-center">
  <i class="bi bi-arrow-left me-2"></i> <- Volver
</a>
<body class="bg-gray-100">
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-6">
                        ✏️ Crear Nueva Noticia
                    </h2>
                    
                    <form action="{{ route('noticias.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                        <!-- Título -->
                        <div class="mb-6">
                            <label for="titulo" class="block text-sm font-medium text-gray-700 mb-2">Título *</label>
                            <input type="text" id="titulo" name="titulo" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   required maxlength="255">
                        </div>

                        <!-- Entradilla -->
                        <div class="mb-6">
                            <label for="entradilla" class="block text-sm font-medium text-gray-700 mb-2">Entradilla *</label>
                            <textarea id="entradilla" name="entradilla" rows="3"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      required maxlength="500"></textarea>
                            <p class="text-sm text-gray-500 mt-1">Máximo 500 caracteres. Aparecerá como resumen.</p>
                        </div>

                        <!-- Cuerpo con Editor de Texto Enriquecido -->
                        <div class="mb-6">
                            <label for="cuerpo" class="block text-sm font-medium text-gray-700 mb-2">Cuerpo de la Noticia *</label>
                            
                            <!-- Barra de herramientas del editor - AHORA ARRIBA del área de edición -->
                            <div class="mb-2 p-3 bg-gray-100 rounded-lg border">
                                <p class="text-sm text-gray-600 mb-2">💡 <strong>Formato del texto:</strong></p>
                                <div class="flex flex-wrap gap-2 text-sm">
                                    <button type="button" onclick="formatText('bold')" class="toolbar-btn bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50">
                                        <strong>B</strong> Negrita
                                    </button>
                                    <button type="button" onclick="formatText('italic')" class="toolbar-btn bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50">
                                        <em>I</em> Cursiva
                                    </button>
                                    <button type="button" onclick="formatText('underline')" class="toolbar-btn bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50">
                                        <u>U</u> Subrayado
                                    </button>
                                    <button type="button" onclick="insertLink()" class="toolbar-btn bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50">
                                        🔗 Enlace
                                    </button>
                                    <button type="button" onclick="formatText('insertUnorderedList')" class="toolbar-btn bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50">
                                        • Lista
                                    </button>
                                    <button type="button" onclick="formatText('insertOrderedList')" class="toolbar-btn bg-white border border-gray-300 px-3 py-1 rounded hover:bg-gray-50">
                                        1. Lista numerada
                                    </button>
                                </div>
                            </div>
                            
                            <!-- Área de edición -->
                            <div id="editorArea" 
                                 class="w-full min-h-64 p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                                 contenteditable="true"
                                 style="min-height: 300px; max-height: 600px; overflow-y: auto; line-height: 1.6;"
                                 placeholder="Escribe el contenido de la noticia aquí...">
                            </div>
                            <textarea id="cuerpo" name="cuerpo" class="hidden" required></textarea>
                            <p class="text-sm text-gray-500 mt-1">Selecciona texto y usa los botones para formatear</p>
                        </div>

                        <!-- Autor Personalizado -->
                        <div class="mb-6">
                            <label for="autor_personalizado" class="block text-sm font-medium text-gray-700 mb-2">Autor Personalizado (Opcional)</label>
                            <input type="text" id="autor_personalizado" name="autor_personalizado" 
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   placeholder="Dejar vacío para usar tu nombre automáticamente">
                            <p class="text-sm text-gray-500 mt-1">Si lo dejas vacío, se usará: [Tu nombre]</p>
                        </div>

                        <!-- SEO -->
                        <div class="mb-6">
                            <label for="seo" class="block text-sm font-medium text-gray-700 mb-2">Descripción SEO</label>
                            <textarea id="seo" name="seo" rows="2"
                                      class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      maxlength="160"></textarea>
                            <p class="text-sm text-gray-500 mt-1">Máximo 160 caracteres. Para motores de búsqueda.</p>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
<!-- Categoría - DINÁMICA DESDE LA BD -->
<div>
    <label for="categoria_id" class="block text-sm font-medium text-gray-700 mb-2">Categoría *</label>
    <div class="custom-select">
        <select id="categoria_id" name="categoria_id"
                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white"
                required>
            <option value="">Seleccionar categoría</option>

            @foreach ($categorias as $categoria)
                <option value="{{ $categoria->id_categoria }}">
                    {{ $categoria->nombre }}
                </option>
            @endforeach

        </select>
    </div>
</div>


                            <!-- Fecha y Hora de Publicación -->
                            <div>
                                <label for="fecha_publicacion" class="block text-sm font-medium text-gray-700 mb-2">Fecha y Hora de Publicación</label>
                                <input type="datetime-local" id="fecha_publicacion" name="fecha_publicacion"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <p class="text-sm text-gray-500 mt-1">Dejar vacío para publicar inmediatamente.</p>
                            </div>
                        </div>

                        <!-- Imagen Destacada -->
                        <div class="mb-6">
                            <label for="imagen_portada" class="block text-sm font-medium text-gray-700 mb-2">Imagen Destacada</label>
                            <input type="file" id="imagen_portada" name="imagen_portada"
                                   accept="image/*"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <p class="text-sm text-gray-500 mt-1">Formatos: JPG, PNG, GIF. Máximo 2MB.</p>
                        </div>

                        <!-- Botones -->
                        <div class="flex justify-between items-center">
                            <a href="{{ route('dashboard') }}"
                               class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                                ← Volver al Dashboard
                            </a>
                            <button type="submit" 
                                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg transition duration-200">
                                💾 Crear Noticia
                            </button>
                            
                        </div>
                        

                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para el editor de texto -->
    <script>
        function updateTextarea() {
            const editor = document.getElementById('editorArea');
            const textarea = document.getElementById('cuerpo');
            textarea.value = editor.innerHTML;
        }

        // Función para formatear texto
        function formatText(command) {
            const editor = document.getElementById('editorArea');
            editor.focus();
            document.execCommand(command, false, null);
            updateTextarea();
        }

        // Función para insertar enlaces
        function insertLink() {
            const editor = document.getElementById('editorArea');
            const selection = window.getSelection();
            
            if (selection.toString().length === 0) {
                alert('Por favor, selecciona el texto que quieres convertir en enlace.');
                return;
            }
            
            const url = prompt('Ingresa la URL:');
            if (url) {
                editor.focus();
                document.execCommand('createLink', false, url);
                updateTextarea();
            }
        }

        // Inicializar cuando el documento esté listo
        document.addEventListener('DOMContentLoaded', function() {
            const editor = document.getElementById('editorArea');
            
            // Inicializar el contenido
            updateTextarea();

            // Manejar el pegado para limpiar formato excesivo
            editor.addEventListener('paste', function(e) {
                e.preventDefault();
                const text = (e.clipboardData || window.clipboardData).getData('text/plain');
                document.execCommand('insertText', false, text);
                updateTextarea();
            });

            // Actualizar el textarea cuando se cambie el contenido
            editor.addEventListener('input', updateTextarea);
            editor.addEventListener('blur', updateTextarea);
            
            // Hacer que el editor sea enfocable
            editor.addEventListener('click', function() {
                this.focus();
            });

            // Si no hay contenido, agregar un placeholder visual
            if (!editor.innerHTML.trim()) {
                editor.innerHTML = '';
            }

            // Manejar la tecla Enter para salir de listas fácilmente
            editor.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    const selection = window.getSelection();
                    const node = selection.anchorNode;
                    
                    // Verificar si estamos en una lista
                    if (node && node.parentNode && node.parentNode.tagName === 'LI') {
                        const listItem = node.parentNode;
                        
                        // Si el elemento de lista está vacío, salir de la lista
                        if (listItem.textContent.trim() === '' && !e.shiftKey) {
                            e.preventDefault();
                            
                            // Salir de la lista usando outdent
                            document.execCommand('outdent', false, null);
                            
                            // Insertar un nuevo párrafo
                            document.execCommand('insertHTML', false, '<p><br></p>');
                            
                            updateTextarea();
                        }
                    }
                    
                    // Permitir que el Enter normal funcione
                    setTimeout(updateTextarea, 0);
                }
            });
        });

        // Validación del formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const editor = document.getElementById('editorArea');
            const textContent = editor.textContent || editor.innerText;
            
            // Remover el texto del placeholder si existe
            const hasRealContent = textContent.trim() !== '' && 
                                 textContent.trim() !== 'Escribe el contenido de la noticia aquí...';
            
            if (!hasRealContent) {
                e.preventDefault();
                alert('El cuerpo de la noticia no puede estar vacío.');
                editor.focus();
                return false;
            }
            
            // Asegurarse de que el contenido esté actualizado
            updateTextarea();
            return true;
        });
    </script>


        
</body>
</html>