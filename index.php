<?php
// index.php - Mostrar la tabla `personas` desde la BD en AlwaysData usando PDO

// --- CONFIGURA ESTOS VALORES ---
$db_host = 'mysql-alexagon08.alwaysdata.net'; // host (según tus mensajes anteriores)
$db_name = 'alexagon08_bd_colegioo';          // nombre de la base (me indicaste este)
$db_user = '435440_bdcolegio';               // usuario (ejemplo usado antes; ajústalo si es distinto)
$db_pass = 'contrasena2109_2008';            // contraseña que indicaste
// -------------------------------

try {
    // DSN con charset
    $dsn = "mysql:host={$db_host};dbname={$db_name};charset=utf8mb4";
    // Opciones recomendadas
    $opts = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // excepciones en errores
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // arrays asociativos
        PDO::ATTR_EMULATE_PREPARES => false,                // usar prepares reales
    ];

    $pdo = new PDO($dsn, $db_user, $db_pass, $opts);
} catch (PDOException $e) {
    // Error de conexión: mostrar mensaje amigable (no exponer detalles en producción)
    echo "<h2>Error de conexión a la base de datos</h2>";
    echo "<p>Comprueba host, usuario, contraseña y que la base exista.</p>";
    // Para depuración temporal puedes descomentar la siguiente línea:
    // echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    exit;
}

// Consulta: obtener todos los registros de la tabla `personas`
try {
    $stmt = $pdo->query("SELECT * FROM personas");
    $personas = $stmt->fetchAll();
} catch (PDOException $e) {
    echo "<h2>Error al consultar la tabla `personas`</h2>";
    echo "<p>Revisa que la tabla exista y que el usuario tenga permisos.</p>";
    // Para depuración temporal:
    // echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    exit;
}

// Helper para escapar salida (seguridad XSS)
function h($s) {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
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
          <?php
            // Mostrar cabeceras dinámicas según columnas devueltas
            $first = $personas[0];
            foreach (array_keys($first) as $col) {
                echo "<th>" . h($col) . "</th>";
            }
          ?>
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
    Nota: si tienes errores revisa host, usuario, contraseña y que la tabla exista. 
    Evita subir credenciales en repositorios públicos; usa un archivo de configuración o variables de entorno en producción.
  </p>
</body>
</html>
