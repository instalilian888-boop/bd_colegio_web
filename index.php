<?php
// index.php - Mostrar la tabla `personas` desde la BD en AlwaysData usando PDO

// --- CONFIGURACIÓN DE CONEXIÓN ---
$db_host = 'mysql-alexagon08.alwaysdata.net';  // Host correcto de AlwaysData
$db_name = 'alexagon08_bd_colegioo';           // Nombre exacto de la base
$db_user = '435440_bdcolegio';                 // Usuario de tu BD
$db_pass = 'contrasena2109_2008';              // Contraseña correcta
// ---------------------------------

try {
    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);
} catch (PDOException $e) {
    echo "<h2 style='color:red;'>❌ Error de conexión a la base de datos</h2>";
    echo "<p>Comprueba host, usuario, contraseña y que la base exista.</p>";
    exit;
}

try {
    $stmt = $pdo->query("SELECT * FROM personas");
    $personas = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<h2 style='color:red;'>❌ Error al consultar la tabla 'personas'</h2>";
    echo "<p>Verifica que la tabla exista en la base de datos.</p>";
    exit;
}

function h($s) { return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Listado de personas - bd_colegio</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body { font-family: Arial, Helvetica, sans-serif; margin: 20px; }
    table { border-collapse: collapse; width: 100%; max-width: 1100px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
    th { background: #f2f2f2; }
    caption { font-size: 1.25rem; margin-bottom: 10px; font-weight: bold; }
    .empty { color: #666; }
  </style>
</head>
<body>
  <h1>Tabla: personas (bd_colegio)</h1>

  <?php if (empty($personas)): ?>
    <p class="empty">No se encontraron registros en la tabla <strong>personas</strong>.</p>
  <?php else: ?>
    <table>
      <caption>Registros encontrados: <?= count($personas) ?></caption>
      <thead>
        <tr>
          <?php foreach (array_keys($personas[0]) as $col): ?>
            <th><?= h($col) ?></th>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($personas as $row): ?>
          <tr>
            <?php foreach ($row as $val): ?>
              <td><?= h($val) ?></td>
            <?php endforeach; ?>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

  <p style="margin-top:20px; font-size:0.9rem; color:#555;">
    Nota: si ves un error, revisa host, usuario, contraseña y nombre de la tabla.
  </p>
</body>
</html>
