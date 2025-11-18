<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario - Canal UTV</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            overflow: hidden;
        }
        .register-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            text-align: center;
        }
        .register-body {
            padding: 2rem;
        }
        .btn-register {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 30px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="register-card">
                    <div class="register-header">
                        <h2><i class="fas fa-user-plus me-2"></i>Registrar Nuevo Usuario</h2>
                        <p class="mb-0">Complete los datos del nuevo usuario</p>
                    </div>
                    
                    <div class="register-body">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nombre" class="form-label">Nombre *</label>
                                    <input id="nombre" type="text" class="form-control" name="nombre" value="{{ old('nombre') }}" required autofocus>
                                    @error('nombre')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="apellido" class="form-label">Apellido *</label>
                                    <input id="apellido" type="text" class="form-control" name="apellido" value="{{ old('apellido') }}" required>
                                    @error('apellido')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="role" class="form-label">Rol *</label>
                                <select id="role" class="form-select" name="role" required>
                                    <option value="">Seleccionar rol</option>
                                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>👨‍💼 Administrador</option>
                                    <option value="periodista" {{ old('role') == 'periodista' ? 'selected' : '' }}>📰 Periodista</option>
                                </select>
                                @error('role')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña *</label>
                                <input id="password" type="password" class="form-control" name="password" required>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña *</label>
                                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-register btn-lg">
                                    <i class="fas fa-user-plus me-2"></i>Registrar Usuario
                                </button>
                                
                                <a href="{{ route('admin.gestion-usuarios') }}" class="btn btn-outline-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver a Gestión de Usuarios
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>