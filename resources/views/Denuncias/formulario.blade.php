<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denuncia Ciudadana</title>

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        /* Suave animación para el mensaje de éxito */
        .fade-in {
            animation: fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-5px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body class="bg-light">

    <div class="container py-5">

        <!-- Botón Volver -->
        <a href="{{ url('/') }}" class="btn btn-outline-primary d-inline-flex align-items-center mb-4">
            <i class="bi bi-arrow-left me-2"></i> Volver
        </a>

        <h1 class="text-center mb-4">Peticiones, quejas y reclamos</h1>

        <div class="card shadow-sm">
            <div class="card-body">

                <!-- Mensaje de éxito -->
                @if (session('success'))
                    <div class="alert alert-success fade-in fw-semibold">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Formulario -->
                <form action="{{ route('denuncia.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-bold">Título</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Escribe el título de la denuncia">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="4" placeholder="Describe la situación"></textarea>
                    </div>

                    <button class="btn btn-success w-100 fw-bold">
                        <i class="bi bi-send-fill me-1"></i> Enviar denuncia
                    </button>
                </form>

            </div>
        </div>

    </div>

    <!-- JS Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
