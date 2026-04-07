<!DOCTYPE html>
<html>

<head>

    <title>Listado Talleres</title>
    <link rel="stylesheet" href="public/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="public/js/jquery-4.0.0.min.js"></script>
    <script src="public/js/taller.js"></script>
</head>

<body class="container mt-5">

    <nav>
        <div>
            <a href="index.php?page=talleres">Talleres</a>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
                <a href="index.php?page=admin">Gestionar Solicitudes</a>
            <?php endif; ?>
        </div>
        <div>
            <span> <?= htmlspecialchars($_SESSION['nombre'] ?? $_SESSION['user'] ?? 'Usuario') ?></span>
            <button id="btnLogout" class="btn btn-primary">Cerrar sesión</button>
        </div>
    </nav>
    <main>
        <h3>Talleres disponibles</h3>

        <div class="card">
            <p style="text-align:center; margin-bottom:15px; color:#555;">
                Explora los talleres disponibles y solicita tu espacio.
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Cupo disponible</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody id="tabla-talleres">
                    <tr>
                        <td colspan="4">Cargando talleres...</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>