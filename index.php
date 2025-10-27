<?php
// --- Configuración de conexión ---
$host = 'mysql-alexagon08.alwaysdata.net';
$db = 'alexagon08_bd_colegioo';
$user = '435440_bdcolegio';
$pass = 'contrasena2109_2008';
$mensajeBD = '';
$filas = [];

// --- Conexión y manejo de errores ---
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
    $mensajeBD = "✅ Base de datos conectada correctamente.";
} catch (PDOException $e) {
    $mensajeBD = "❌ Error de conexión: " . htmlspecialchars($e->getMessage());
}

// --- Consultas ---
if (!empty($pdo)) {

    // Mostrar todos los registros
    if (isset($_POST['mostrar_todos'])) {
        $stmt = $pdo->query("SELECT * FROM personas ORDER BY id ASC");
        $filas = $stmt->fetchAll();
    }

    // Filtro por ciudad (opcional)
    if (isset($_POST['ciudad'])) {
        $ciudad = $_POST['ciudad'];
        $stmt = $pdo->prepare("SELECT * FROM personas WHERE ciudad = ? ORDER BY nombre ASC");
        $stmt->execute([$ciudad]);
        $filas = $stmt->fetchAll();
    }

    // Filtro por promedio mayor a 8 (ejemplo)
    if (isset($_POST['promedio'])) {
        $stmt = $pdo->query("SELECT * FROM personas WHERE promedio > 8 ORDER BY promedio DESC");
        $filas = $stmt->fetchAll();
    }
}

function h($s) { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>

<!doctype html>
<html lang="es">
<head>
 <meta charset="utf-8">
 <title>Listado de Personas - bd_colegio</title>
 <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
 <style>
     body { background-color: #f8f9fa; font-family: 'Segoe UI', sans-serif; margin-top: 20px; }
     header { margin-bottom: 20px; }
     table th, table td { vertical-align: middle; }
 </style>
</head>
<body>
<div class="container">

    <!-- Header -->
    <header class="mb-3">
        <h1 class="text-center">Listado de Personas - bd_colegio</h1>
    </header>

    <!-- Mensaje de conexión -->
    <?php if ($mensajeBD): ?>
        <div class="alert <?= strpos($mensajeBD, 'Error') === false ? 'alert-success' : 'alert-danger' ?>" role="alert">
            <?= $mensajeBD ?>
        </div>
    <?php endif; ?>

    <!-- Botones de consulta -->
    <form method="POST" class="btn-group mb-3 flex-wrap" role="group">
        <button type="submit" name="mostrar_todos" class="btn btn-primary">Mostrar Todos</button>
        <button type="submit" name="promedio" class="btn btn-warning">Promedio &gt; 8</button>
        <button type="submit" name="ciudad" value="Zacatecas" class="btn btn-info text-white">Ciudad: Zacatecas</button>
        <button type="submit" name="ciudad" value="Guadalajara" class="btn btn-info text-white">Ciudad: Guadalajara</button>
    </form>

    <!-- Tabla -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold bg-dark text-white">Listado de Personas</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered mb-0 align-middle">
                    <thead class="table-dark">
                        <tr>
                            <?php if (!empty($filas)): ?>
                                <?php foreach (array_keys($filas[0]) as $col): ?>
                                    <th><?= h($col) ?></th>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Fecha Nacimiento</th>
                                <th>Ciudad</th>
                                <th>Promedio</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($filas)): ?>
                            <tr><td colspan="8" class="text-center py-4">Sin datos que mostrar</td></tr>
                        <?php else: ?>
                            <?php foreach ($filas as $r): ?>
                                <tr>
                                    <?php foreach ($r as $val): ?>
                                        <td><?= h($val) ?></td>
                                    <?php endforeach; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer small text-muted">Fuente: alexagon08_bd_colegioo.personas</div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
