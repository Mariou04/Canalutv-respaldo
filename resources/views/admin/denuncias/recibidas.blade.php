<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Denuncias Recibidas</title>

    <!-- BOOTSTRAP 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body class="bg-light">

    <div class="container py-5">

        <!-- BOTÓN VOLVER -->
        <a href="{{ route('dashboard') }}" class="btn btn-outline-primary mb-4">
            ← Volver
        </a>

        <h1 class="mb-4 fw-bold">Denuncias recibidas</h1>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Mensaje</th>
                            <th>Fecha</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($denuncias as $d)
                        <tr>
                            <td>{{ $d->id }}</td>
                            <td>{{ $d->mensaje }}</td>
                            <td>{{ $d->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

</body>
</html>
