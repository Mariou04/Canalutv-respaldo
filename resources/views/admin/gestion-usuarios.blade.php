<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Canal UTV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar-brand {
            font-weight: bold;
        }
        .table th {
            border-top: none;
        }
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            border: 1px solid rgba(0, 0, 0, 0.125);
        }
        .btn-registro {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-registro:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
        .btn-actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }
        .btn-actions form {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <br>

        <!-- Contenido principal -->
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h1 class="h3 text-dark">
                            <i class="fas fa-users-cog me-2"></i>Gestión de Usuarios
                        </h1>
                        <div>
                            <!-- BOTÓN DE REGISTRO AQUÍ -->
                            <a href="/register" class="btn btn-registro me-2">
                                <i class="fas fa-user-plus me-2"></i>Registrar Nuevo Usuario
                            </a>
                            <a href="{{ route('admin.panel') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-1"></i>Volver al Panel
                            </a>
                        </div>
                    </div>

                    <!-- Mensajes de éxito/error -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Estadísticas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card border-0 bg-primary text-white">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $usuarios->count() }}</h3>
                                    <small>Total Usuarios</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-success text-white">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $usuarios->where('activo', true)->count() }}</h3>
                                    <small>Usuarios Activos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-warning text-white">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $usuarios->where('activo', false)->count() }}</h3>
                                    <small>Usuarios Inactivos</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-0 bg-info text-white">
                                <div class="card-body text-center py-3">
                                    <h3 class="mb-1">{{ $usuarios->where('rol_id', 1)->count() }}</h3>
                                    <small>Administradores</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tabla de usuarios -->
                    <div class="card">
                        <div class="card-header bg-light d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list me-1"></i>Lista de Usuarios Registrados
                            </h5>
                            <span class="badge bg-primary">
                                Total: {{ $usuarios->count() }}
                            </span>
                        </div>
                        <div class="card-body">
                            @if($usuarios->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre Completo</th>
                                            <th>Email</th>
                                            <th>Rol</th>
                                            <th>Estado</th>
                                            <th>Registro</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($usuarios as $usuario)
                                        <tr>
                                            <td><strong>#{{ $usuario->id_usuario }}</strong></td>
                                            <td>{{ $usuario->nombre }} {{ $usuario->apellido }}</td>
                                            <td>{{ $usuario->email }}</td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $usuario->rol->nombre ?? 'Sin rol' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge {{ $usuario->activo ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                                </span>
                                            </td>
                                            <td>
                                                <small>{{ $usuario->created_at->format('d/m/Y') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-actions">
                                                    <form action="{{ route('admin.usuarios.toggle', $usuario->id_usuario) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm {{ $usuario->activo ? 'btn-warning' : 'btn-success' }}"
                                                                title="{{ $usuario->activo ? 'Desactivar usuario' : 'Activar usuario' }}">
                                                            <i class="fas {{ $usuario->activo ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                                            {{ $usuario->activo ? 'Desactivar' : 'Activar' }}
                                                        </button>
                                                    </form>
                                                    
                                                    <!-- Botón Eliminar -->
                                                    <form action="{{ route('admin.usuarios.destroy', $usuario->id_usuario) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                                title="Eliminar usuario permanentemente"
                                                                onclick="return confirm('¿Estás seguro de eliminar a {{ $usuario->nombre }} {{ $usuario->apellido }}?')">
                                                            <i class="fas fa-trash"></i> Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="alert alert-info text-center">
                                <i class="fas fa-info-circle me-2"></i>
                                No hay usuarios registrados en el sistema.
                                <br>
                                <a href="/register" class="btn btn-primary mt-2">
                                    <i class="fas fa-user-plus me-1"></i>Registrar Primer Usuario
                                </a>
                            </div>
                            @endif
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>